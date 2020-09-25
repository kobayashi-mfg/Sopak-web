<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mieru\Ncs\Product;
use App\Models\Mieru\Ncs\Purchasing;
use App\Models\Mieru\Ncs\Estimate;
use App\Models\Mieru\Ncs\Work;
use App\Models\Mieru\Ncs\Worktime;
use Datetime;

class Purchasing extends Model
{
    protected $table='purchasings';

    public function getTotalMachineDepreciation(){
        $purchasings = Purchasing::where('outsourcer_id', '=', '0017')->get();
        //機械加工装置の全値段
        // $sql = "SELECT * FROM purchasings where outsourcer_id = '0017';"; //疋田産業(0017)から購入したものは機械加工用

        $cost = 0;
        foreach ($purchasings as $key => $value) {
            $cost += $value->original['subtotal'];
        }
        $cost = $cost + 15000000; //+機械代金1500万円

        return $cost;
    }

    public static function getOtherCost($startday, $finishday){
        $firstDate = new DateTime($startday);
        $finishday = new DateTime($finishday);
        $interval_days = $firstDate->diff($finishday)->days + 1;

        //一日あたりの土地代:200万円/(7年×250日)=1142円
        return 1143 * $interval_days;
    }

    public static function getMachineDepreciation($startday, $finishday){
        $firstDate = new DateTime($startday);
        $finishday = new DateTime($finishday);
        $interval_days = $firstDate->diff($finishday)->days + 1;

        $searchDay = new \DateTime($startday);
        $searchDay->modify('-7 year')->format('Y-m-d H:i:s');
        $datetime = $searchDay->format('Y-m-d H:i:s');

        //7年で原価償却する
        $purs = Purchasing::where('arrived_at', '>', $datetime)->where('outsourcer_id', '=', '0017')->get();
        // $sql = "SELECT * FROM purchasings where arrived_at > ? and outsourcer_id = '0017';"; //疋田産業(0017)から購入したものは機械加工用
        // $stmt = $this->_db->prepare($sql);
        // $stmt->execute(array($datetime));
        // $purchasings = $stmt->fetchAll();

        $purchasings = array();
        foreach($purs as $pur){
            array_push($purchasings, $pur);
        }
        $cost = 0;
        foreach ($purchasings as $key => $value) {
            $cost += $value['subtotal'];
        }

        $cost = $cost + 15000000; //+機械代金1500万円

        return round($cost / 7 / 250 * $interval_days);
    }

    public static function getPackingList($products, $customers){
        $product_model = new Product();
        $packing_list = array();
        $total_material_cost = 0;
        foreach ($products as $day => $products_arr) {
        	if(!empty($products_arr)){
        		foreach ((array)$products_arr as $product) {
        			$packing_list_item=array();
        			$same_products = Product::getProductsByZuban($product['product_no']);
        			// $material_cost = Purchasing::getUnitMaterialCost($same_products) * $product['quantity'];
        			$material_cost = Purchasing::getUnitMaterialCost($product) * $product['quantity'];
        			$total_material_cost += $material_cost;

        			$packing_list_item[] = $day;	//0.機械加工終了日
        			$packing_list_item[] = static::GetCustomerName($customers,$product['customer_id']);	//1.会社名
        			$packing_list_item[] = $product['id'];	//2.製番
        			$packing_list_item[] = $product['product_name'];	//3.製品名
        			$packing_list_item[] = $product['product_no'];	//4.図番
        			$packing_list_item[] = $product['quantity'];	//5.数量

                    $is_repeat = $product_model->isRepeatProduct($product);
        			$sale = Estimate::getSaleByZuban($product['product_no'],$product['quantity'], $is_repeat);
        			$packing_list_item[] = $sale;	//6.見積
        			$packing_list_item[] = ($product['price1'] + $product['price2']) * $product['quantity'];	//7.売上
        			$packing_list_item[] = $material_cost;	//8.材料費


        			$estimates = Estimate::getEstimatesByZuban($product['product_no']);
        			$estimate = array_shift($estimates);
        			$worktime_arr = Work::getWorkTimeArrByProduct($product);


        			//固定費(fixed_cost) = 一ヶ月の減価償却費 / 加工終了日から前の一ヶ月の作業分数
        			$month_worktotaltime = Worktime::GetMonthWorkTime($day);
        			$cost =  Purchasing::getExpenseEachWork($product,$worktime_arr,$month_worktotaltime) + $material_cost ;
        			$packing_list_item[] = number_format((float)$cost);	//9.費用

                    $profit_rate = $sale > 0? round(($sale - $cost) / $sale * 1000) / 10 : '0.0';
        			$packing_list_item[] = $profit_rate;	//10.利益率(見積)

        			array_push($packing_list, $packing_list_item);
        		}
        	}
        }
        $packing_list['material_cost'] = $total_material_cost;
        return $packing_list;
    }

    //一日の仕事に対する材料費以外の費用を算出
    public static function getExpenseEachWork($product, $worktime_arr,$month_worktime){
        if($month_worktime==0){
            return 0;
        }
        $cost_arr = [];
        $i =0;

        $date = $product['delivery_date'];

        $searchDay = new DateTime($date);
        $searchDay->modify('-7 year')->format('Y-m-d H:i:s');
        $datetime = $searchDay->format('Y-m-d H:i:s');

        //7年で原価償却する
        $purs = Purchasing::where('arrived_at','>',$datetime)->where('outsourcer_id', '=', '0017')->get();
        // $sql = "SELECT * FROM purchasings where arrived_at > ? and outsourcer_id = '0017';"; //疋田産業(0017)から購入したものは機械加工用
        // $stmt = $this->_db->prepare($sql);
        // $stmt->execute(array($datetime));
        // $purchasings = $stmt->fetchAll();
        $purchasings = array();
        foreach($purs as $pur){
            array_push($purchasings, $pur);
        }


        $machine_cost = 0;
        foreach ($purchasings as $key => $value) {
            $machine_cost += $value['subtotal'];
        }

        $total_cost = 0;
        $month_depreciation = ($machine_cost + 15000000 )/ 7 / 12; //一ヶ月固定費費用 + 機械代金1500万円
        $minute_depreciation = $month_depreciation / $month_worktime; //一分固定費費用
        $month_other = 2000000 / 7 / 12; //一ヶ月の土地代
        $minute_other = $month_other / $month_worktime; //一分当たりの土地代
        $minute_labour = 30; //時給1800円->分30円
        $minute_cost = $minute_depreciation + $minute_other + $minute_labour;
        foreach ($worktime_arr as $worktime) {
            foreach ((array)$worktime as $time => $rate) {
                $total_cost += $minute_cost * $time;
            }
        }

        return $total_cost;
    }

    //同図番の製品(製番)に対する外注台帳で過去を検索して材料費算出
    public static function getUnitMaterialCost($product){
        $is_exist = false;
        $unit_price = 0;
        // foreach ($products as $product) {
            $purchasings = Purchasing::where('serial_no', '=', $product['id'])->get();
            // $sql = "SELECT * FROM purchasings WHERE ";

            foreach($purchasings as $pur){
                if($pur->original['outsourced_unit_price']!=0){
                    $is_exist = true;
                }
            }
            if($is_exist){
                foreach ($purchasings as $purchasing) {
                    $unit_price += $purchasing->original['outsourced_unit_price'];
                }
                // break;
            }
        // }

        return $unit_price;
    }

    public static function GetCustomerName($customers, $id){
        $result = null;
        if(isset($id)){
            $keyIndex = array_search($id, array_column($customers, '客先コード'));
            if($keyIndex){
                $result = $customers[$keyIndex]['漢字名'];
            }
        }
        return $result;
    }
}
