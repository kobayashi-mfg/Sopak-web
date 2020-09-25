<?php

namespace App\Http\Controllers\Mieru\Ncs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mieru\Ncs\Work;
use App\Models\Mieru\Ncs\Product;
use App\Models\Mieru\Ncs\Customer;
use App\Models\Mieru\Ncs\Estimate;
use App\Models\Mieru\Ncs\Purchasing;
use App\Models\Mieru\Ncs\Picture;
use App\Models\Mieru\Ncs\BrotherLog;
use DateTime;
use DateTimeZone;
use App\Classes\Mieru\Library\NcSearchSetting;

class NcsController extends Controller
{
    // public function index(){
    //     return view('index');
    // }

    public function index(Request $request){
        $setting = new NcSearchSetting($request);

        $works = Work::getWorksDevidedByDay($setting->startday, $setting->finishday);	//[日付け=>作業(sg)] 1つの日付に対して複数の作業あり
        $made_products = Product::getMadeProducts($works, $setting->startday, $setting->finishday, $setting->without_bankin);

        //機械加工の製品のみで絞った場合、作業を上書きする
        if($setting->without_bankin){
            $works = Work::getWorksByProducts($made_products);
        }

        //製造台帳内容
        $customers = Customer::getCustomerArr();
        $packing_list = Purchasing::getPackingList($made_products, $customers);

        ///利益profit = 売上(材料費抜き済)sales - 材料費mateial - 人件費labour - 原価償却費(工具費用+材料費ってことになっているが工具費用のこと)depreciation - その他other, 　expense=費用 real_sales=濱平さんの算出方法参考営業売上計 real_profit=濱平さん営業利益
        $total_material_cost = $packing_list['material_cost'];
        //指定期間内のお金を得る
        $money = Estimate::getLocalMoney($made_products, $works, $setting->startday, $setting->finishday, $total_material_cost);
        unset($packing_list['material_cost']);

        //作用製品数グラフ
        // $made_products_count = $this->_getCountEachDay($made_products, 'quantity', $setting->startday, $setting->finishday, $setting->display_interval);
        // $product_total = $this->_getTotal($made_products_count);

        $made_products_count = BrotherLog::getForGraph('quantity', $setting->startday, $setting->finishday, $setting->display_interval);    //作業台帳ではなく、Brotherのログより作業個数を作成
        $product_total = $this->_getTotal($made_products_count);

        //作業者作業時間グラフ
        $work_time = $this->_getCountEachDay($works, 'Sg_Jtstan', $setting->startday, $setting->finishday, $setting->display_interval);
        $brother_work_time = BrotherLog::getForGraph('operate_time', $setting->startday, $setting->finishday, $setting->display_interval);
        $work_time_total = $this->_getTotal($work_time);

        //売上推移グラフ用(全期間における収支)
        $total_works = Work::getWorksDevidedByDay($setting->kikai_startday, $setting->this_month_last_day);
        $total_made_products = Product::getMadeProducts($total_works, $setting->kikai_startday, $setting->this_month_last_day, $setting->without_bankin);
        $total_sale_each_month = $this->_getTotalSale($setting->kikai_startday, $setting->this_month_last_day, $setting->without_bankin, $total_made_products);
        $total_money = Estimate::getTotalMoney($total_made_products, $total_works, $setting->kikai_startday, $setting->this_month_last_day);

        return view('mieru.ncs.index', compact('total_sale_each_month', 'total_money', 'setting','money','made_products_count', 'product_total', 'work_time', 'brother_work_time', 'work_time_total', 'packing_list' ));
    }

    public function show($zuban){
        //図面画像用のリンク作成
        $link = Picture::getPictureLink($zuban);
        if($link == null){
            return redirect(route('mieru.ncs.index'));
        }

        //図番製品取得
        $products = Product::getProductsByZuban($zuban);
        $customer_name = Customer::getCustomerKanji($products[0]['customer_id']);

        $estimates = Estimate::getEstimatesByZuban($zuban);
        $estimate = array_shift($estimates);

        //表示データ作成
        $data = $this->_getShowData($products, $estimate);

        $info = array();
        $info['customer_name'] = $customer_name;
        $average_cost = $data['total_quantity'] != 0 ? round($data['total_sale']/$data['total_quantity']) : 0;
        $info['average_cost'] = number_format((float)$average_cost);
        $info['total_quantity'] = $data['total_quantity'];
        $info['total_sale'] = number_format((float)$data['total_sale']);
        $info['total_real_sale'] = number_format((float) $data['total_real_sale']);

        //余分なデータを消す
        unset($data['total_quantity'], $data['total_real_sale'], $data['total_sale']);
        return view('mieru.ncs.show', compact('link','zuban','info', 'data'));
    }

    //全期間における月ごとの売り上げ取得
    private function _getTotalSale($startday, $finishday, $without_bankin, $total_made_products){
        $total_sale_each_day = Estimate::getSalesEachProduct($total_made_products);
        $total_sale_each_month = $this->_getTotalSaleEachMonth($total_sale_each_day, $startday, $finishday, "month");
        return $total_sale_each_month;
    }

    private function _getTotalSaleEachMonth($sales, $startday, $finishday, $display){
        $result = array();
        foreach($sales as $day => $values){
            array_push($result, $values);
        }
        $result = $this->_getCount($result, $startday, $finishday, $display);
        return $result;
    }

    private function _getShowData($products, $estimate){
        $total_quantity = 0;
        $total_sale = 0;
        $total_real_sale = 0;
        $data = array();
        foreach ($products as $product) {
            $datum = array();
            $total_quantity += $product['quantity'];

            //リピート品かどうか
            $is_repeat = Product::isRepeatProduct($product);
            $sale = 0;
            $sale = Estimate::reEstimateSingle($estimate, $product['quantity'], $is_repeat);
            $total_sale += $sale;
            $total_real_sale += ($product['price1'] + $product['price2']) * $product['quantity'];

            // $worktime_arr = array([0] => array(['対象の作業時間']=>[割合]),[1] => array(['対象の作業時間']=>[割合]))
            $worktime_arr = Work::getWorkTimeArrByProduct($product);
            $wtime = 0;
            foreach($worktime_arr as $worktime){
                $wtime += key($worktime);
            }

            $day = Work::getWorkLastDay($product['id']);
            $month_worktotaltime = $this->_getMonthWorkTime($day);
            $cost = Purchasing::getExpenseEachWork($product, $worktime_arr, $month_worktotaltime);
            $same_products = Product::getProductsByZuban($product['product_no']);
            // $material_unitcost = Purchasing::getUnitMaterialCost($same_products);
            $material_unitcost = Purchasing::getUnitMaterialCost($product);
            $material_cost = $material_unitcost * $product['quantity'];
            $cost = $cost + $material_unitcost * $product['quantity'];

            $datum['delivery_date'] = $product['delivery_date'];
            $datum['id'] = $product['id'];
            $datum['quantity'] = $product['quantity'];
            $datum['ave_worktime'] = round($wtime / $product['quantity'] *10 ) / 10;

            $datum['sale'] = number_format((float)$sale);
            $datum['real_sale'] =  number_format((float)($product['price1'] + $product['price2']) * $product['quantity']);
            $datum['cost'] = number_format((float) $cost);
            $datum['profit_rate'] = $sale == 0? '0.0' : round(($sale-$cost)/$sale*1000)/10;
            $datum['material_cost'] = $material_cost;
            array_push($data, $datum);
        }
        $data['total_quantity'] = $total_quantity;
        $data['total_sale'] = $total_sale;
        $data['total_real_sale'] = $total_real_sale;
        return $data;
    }

    private function _getMonthWorkTime($product_day){
    	$pday = str_replace("/","-",$product_day);
    	$fDay = new DateTime($pday);
    	$sDay = new DateTime($pday);
    	$sDay->modify('first day of this month');
    	$sDay->modify('-1 days');
    	$year = $sDay->format('Y');
    	$month = $sDay->format('m');
    	$day = $fDay->format('d');
    	$sDay->setDate($year,$month,$day);
        $sDay = $sDay->format('Y-m-d');
    	$fDay = $fDay->format('Y-m-d');


    	$works = Work::getWorksDevidedByDay($sDay, $fDay);
    	$work_time_total = 0;
    	foreach ($works as $day => $values) {
    		if($values){
    			foreach ((array)$values as $work) {
    				$work_time_total+=$work['Sg_Jtstan'];
    			}
    		}
    	}
    	return $work_time_total;
    }

    private function _getCount($obj_arr, $startday, $finishday, $display){
        $startday = new DateTime($startday);
        $finishday = new DateTime($finishday);
        $firstDate = new DateTime($startday->format('y-m-d'),new DateTimeZone('Asia/Tokyo'));
        $result_arr = [];
        $k = 0;

            if($display == "day"){
                $diff = $startday->diff($finishday);
                $interval = $diff->days + 1;
                for ($i = 0; $i < $interval; $i++){
                    $result = $obj_arr[$i];

                    $result_arr[$firstDate->format('y-m-d')] = $result;
                    $firstDate = $firstDate->modify('+1 days');
                }
            }else{  //$diplay == "month"
                $finishDate = new DateTime($finishday->format('y-m-d'),new DateTimeZone('Asia/Tokyo'));
                $interval_month = ($finishDate->format('y') - $firstDate->format('y') ) * 12 + ($finishDate->format('m') - $firstDate->format('m') ) +1;

                //!!!!!!diff->mが月によって結果がバラバラなため利用できず
                $secondDate = new DateTime($startday->format('y-m-d'),new DateTimeZone('Asia/Tokyo'));
                $secondDate = $secondDate->modify('last day of this month');

                for ( $j = 0; $j < $interval_month; $j++){
                    $result = 0;
                    $interval_days = $firstDate->diff($secondDate)->days + 1;
                    for ($i = 0; $i < $interval_days; $i++){
                        if(isset($obj_arr[$k])){
                            $result += $obj_arr[$k];
                            $k++;
                        }
                    }
                    $result_arr[$firstDate->format('y-m-d')] = $result;

                    $firstDate->modify('first day of next month');
                    $secondDate->modify('last day of next month');
                }
            }
        return $result_arr;
    }

    //配列(オブジェクトのi) itemキーを合計する
    private function _getCountEachDay($objs, $item, $startday, $finishday, $display){
        $obj_arr = array();
        foreach($objs as $day => $values){
            $count = 0;
            if($values){
                foreach($values as $obj){
                    $count+=$obj[$item];
                }
            }
            array_push($obj_arr, $count);
        }
        $result = $this->_getCount($obj_arr, $startday, $finishday, $display);
        return $result;
    }

    //一次配列の値を合計する
    private function _getTotal($array){
        $result = 0;
        foreach ($array as $value) {
            $result += $value;
        }
        return $result;
    }
}
