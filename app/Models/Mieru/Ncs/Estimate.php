<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mieru\Ncs\Manufacturing;
use App\Models\Mieru\Ncs\Purchasing;
use App\Models\Mieru\Ncs\Product;
use App\Models\Mieru\Ncs\Work;

class Estimate extends Model
{
    protected $table='estimates';

    //図番で見積を探す
    public static function getById($id){
        $ests = Estimate::where('id', '=', $id)->get();
        // $sql= "SELECT * FROM estimates where id = ? order by created_at desc;";

        $estimates = array();
        foreach($ests as $est){
            array_push($estimates, $est->original);
        }
        if(empty($estimates)){
            return null;
        }else{
            return $estimates[0];
        }
    }

    //全期間における収支配列作成
    public static function getTotalMoney($productions, $works, $startday, $finishday){
        $purchasing_model = new Purchasing();

        //moneyとtotal_moneyで異なる部分を上書いている
        $money = static::getMoney($productions, $works, $startday, $finishday);
        $money['depreciation'] = $purchasing_model->getTotalMachineDepreciation(); //機械代金総計
        $money['other'] = 2000000; //土地代200万円

        $total_material_cost = 0;
        foreach ($productions as $day => $products_arr) {
            if(!empty($products_arr)){
        		foreach ((array)$products_arr as $product) {
                    $same_products = Product::getProductsByZuban($product['product_no']);
                    // $material_cost = Purchasing::getUnitMaterialCost($same_products) * $product['quantity'];
                    $material_cost = Purchasing::getUnitMaterialCost($product) * $product['quantity'];
                    $total_material_cost += $material_cost;
                }
            }
        }
        $money['material'] = $total_material_cost;

        $money['expense'] =$money['material'] + $money['labour'] + $money['depreciation'] + $money['other'];
        $money['profit'] = $money['sales'] - $money['expense'];
        $money['profit_rate'] = $money['sales'] == 0? '0.0' :round($money['profit']/$money['sales']*1000)/10;
        $money['real_profit'] = $money['real_sales'] - $money['expense'];
        $money['real_profit_rate'] = $money['real_sales'] == 0? '0.0' :round($money['real_profit']/$money['real_sales']*1000)/10;

        return $money;
    }

    public static function getSaleByZuban($zuban,$kosuu, $is_repeat){
        $estimates = static::getEstimatesByZuban($zuban);
        $sale = 0;
        if(!is_null($estimates)){
            $estimate = array_shift($estimates);
            $sale = static::reEstimateSingle($estimate, $kosuu, $is_repeat);
        }
        return $sale;
    }

    //1つの見積に対する見積再計算
    public static function reEstimateSingle($estimate, $kosuu, $is_repeat){
        if($estimate['change_count'] > 0){
            $change_count = $estimate['change_count'];
        }else{
            $change_count = static::_getChangeCount($estimate);
        }
        $sale = static::_getSaleFromChangeCount($estimate, $kosuu, $change_count, $is_repeat);
        return $sale;
    }

    // 複数の見積に対する見積再計算して配列
    public static function reEstimate($estimates, $kosuu, $is_repeat){
        $sale_arr=[];
        foreach($estimates as $estimate){
            if($estimate['change_count'] > 0){
                $change_count = $estimate['change_count'];
            }else{
                $change_count = static::_getChangeCount($estimate);
            }
            $sale = static::_getSaleFromChangeCount($estimate, $kosuu, $change_count, $is_repeat);
            array_push($sale_arr, $sale);
        }
        return $sale_arr;
    }

    public static function getLocalMoney($productions, $works, $startday, $finishday, $material_cost){
        $money = static::getMoney($productions, $works, $startday, $finishday);
        $money['material']=$material_cost;
        $money['expense'] = $money['material'] + $money['labour'] + $money['depreciation'] + $money['other'];
        $money['profit'] = $money['sales'] - $money['expense'];
        $money['profit_rate'] = $money['sales'] == 0? '0.0' :round($money['profit']/$money['sales']*1000)/10;

        $money['real_profit'] = $money['real_sales'] - $money['expense'];
        $money['real_profit_rate'] = $money['real_sales'] == 0? '0.0' :round($money['real_profit']/$money['real_sales']*1000)/10;

        return $money;

    }


    //productions配列から図番を取り出し、見積を呼び出す
    public static function getMoney($productions, $works, $startday, $finishday){

        $money = array('profit' => 0, 'material'=>0,'sales'=>0,  'labour'=>0, 'depreciation'=>0, 'other'=>0, 'expense'=>0, 'real_sale'=> 0, 'real_profit'=>0); ///利益profit = 売上(材料費抜き済)sales - 材料費mateial - 人件費labour - 原価償却費(工具費用+材料費ってことになっているが工具費用のこと)depreciation - その他other, 　expense=費用 real_sales=濱平さんの算出方法参考営業売上計 real_profit=濱平さん営業利益
        $money['sales'] = static::_getSales($productions);
        $money['real_sales'] = static::_getRealSale($productions);

        $money['depreciation'] = Purchasing::getMachineDepreciation($startday, $finishday) * 250/365; //もとは一日当たりの費用を算出するものであり、勤務日は365日中250日で算出しているため
        $money['other'] = Purchasing::getOtherCost($startday, $finishday)* 250/365; //もとは一日当たりの費用を算出するものであり、勤務日は365日中250日で算出しているため
        $work_time_sum = Work::getWorkTimeSum($works);
        $money['labour'] = $work_time_sum * 30; 	//時給1800円=分給30円

        return $money;
    }

    public static function getSalesEachProduct($products){
        $result = array();
        foreach ($products as $day => $values) {
            $sale = 0;
            foreach ((array)$values as $product) {
                if($product){
                    $estimates = static::getEstimatesByZuban($product['product_no']);

                    //見積が複数あるときは最新のものを利用している<---要検討-------------------------------------------
                    //図番が省略されているせいで見つからないものアリ(例 図番NAG-5B30449)
                    // if(isset($estimates[0])  && $i == 1){
                    if(isset($estimates[0])){
                        $estimate = $estimates[0];
                        $sale += static::_getSalesWithQuantity($estimate, $product);
                        // $sale = $this->_getSalesWithQuantity($estimate, $product);
                    }
                }
            }
            $result[$day] = $sale;
        }
        return $result;
    }

    //売上
    private static function _getSales($productions){
        $sale = 0;
        $i =1;
        foreach ($productions as $day => $values) {
            foreach((array)$values as $product){
                if($product){
                    $estimates = static::getEstimatesByZuban($product['product_no']);

                    //見積が複数あるときは最新のものを利用している<---要検討-------------------------------------------
                    //図番が省略されているせいで見つからないものアリ(例 図番NAG-5B30449)
                    // if(isset($estimates[0])  && $i == 1){
                    if(isset($estimates[0])){
                        $estimate = $estimates[0];
                        $sale += static::_getSalesWithQuantity($estimate, $product);
                        // $sale = $this->_getSalesWithQuantity($estimate, $product);
                    }
                }
                $i++;
            }
        }
        return $sale;
    }


    public static function getEstimatesByZuban($zuban){
        $estimates = Estimate::where('figure_id','=',$zuban)->orderBy('created_at','desc')->get();
        // // 新しい日付順に取得する
        // $sql= "SELECT * FROM estimates where figure_id = ? order by created_at desc;";
        if(isset($estimates)){
            $result_arr = array();
            //object型から配列に変更
            foreach($estimates as $estimate){
                array_push($result_arr, $estimate->original);
            }
            return $result_arr;
        }else{
            return null;
        }
    }

    private static function _getSalesWithQuantity($estimate, $product){

        $change_count = 0;
        // 見積時の製品個数と注文時の製品個数が異なる場合、再計算
        if($estimate['quantity'] != $product['quantity']){

            if($estimate['change_count'] > 0){
                $change_count = $estimate['change_count'];
            }else if($estimate['quantity'] == 1){
                //持ち替え回数に記述がなく、かつ、見積時は製品個数が1つの場合<---要検討-------------------------------------------
                $change_count = 0;
            }else{
                $change_count = static::_getChangeCount($estimate);
            }

            $product_model = new Product();
            $is_repeat = $product_model->isRepeatProduct($product);
            $sale = static::_getSaleFromChangeCount($estimate, $product['quantity'], $change_count, $is_repeat);
        }else{
            $sale = $estimate['total_price'];
        }

        return $sale;
    }

    //持ち替え回数のDBテーブルカラムがなかったため、見積から逆算させるプログラム
    private static function _getChangeCount($estimate){
        $CHARGE = 100;  // 100円/分
        $total_price = $estimate['total_price'];
        $unit_price = ceil($estimate['total_time'] * $CHARGE + $estimate['material_cost']);
        $quantity = $estimate['quantity'];
        $setup_time = $estimate['coding_time'] + $estimate['dry_run_time'] + $estimate['jig_creation_time'];
        $inspection = floor(($quantity - 1)/20 + 2);
        $blind_hole = static::_getBlindHole($estimate['group_id']);

        $left = 3 * $quantity - $inspection - 2;
        $right_1 = ($unit_price * $quantity - $total_price) / $CHARGE;
        $right_2 = ($quantity - 1) * $setup_time + 3*($quantity - $inspection) * $blind_hole;
        $change_count = ($right_1 - $right_2)/$left;
        return $change_count;
    }

    private static function _getBlindHole($group_id){
        $manus = Manufacturing::where('estimate_group_id', '=', $group_id)->get();
        $manufacturings = array();
        foreach($manus as $manu){
            array_push($manufacturings, $manu);
        }
        // $sql= "SELECT * FROM manufacturings where estimate_group_id = ?;";

        $count = 0;
        foreach ($manufacturings as $manu) {
            if($manu['is_blind_hole']){
                $count ++;
            }
        }

        return $count;
    }

    //算出した持ち替え回数を用いて、異なる個数での見積を算出する
    private static function _getSaleFromChangeCount($estimate,$quantity,$change_count,$is_repeat){
        $CHARGE = 100;  // 100円/分

        // 数値の丸め方によってphp版とlaravel版で値が微妙に変わってくる
        $unit_price = ceil($estimate['total_time'] * $CHARGE + $estimate['material_cost']);

        // $quantity = $product['quantity'];
        $origin_setup_time = $change_count * 2;

        $inspection = floor(($quantity - 1)/20 + 2);
        $blind_hole = static::_getBlindHole($estimate['group_id']);
        $inspection_time = $change_count * 1 + $blind_hole * 3;

        $total_price = $unit_price * $quantity;

        $setup_time = $estimate['coding_time'] +$estimate['dry_run_time'] + $estimate['jig_creation_time'];
        if($quantity > 1){
            //リピート品かどうか
            if(!$is_repeat){    //初期だった場合
                $total_price = $total_price - (($quantity - 1)* ($setup_time + $origin_setup_time)* $CHARGE) - (($quantity - $inspection) * ($inspection_time) * $CHARGE);
            }else{  //リピートだった場合
                //1個以降すべてでcoding、jigの費用がかからず、2個目以降すべてでdry_runの費用がかからない
                $total_price = $total_price - ($quantity * ($estimate['coding_time'] + $estimate['jig_creation_time']) * $CHARGE) - (($quantity - 1) * ($estimate['dry_run_time'] + $origin_setup_time ) * $CHARGE) - (($quantity - $inspection) * ($inspection_time) * $CHARGE);
            }
        }

        return $total_price;
    }

    private static function _getRealSale($productions){
        $sale = 0;
        foreach ($productions as $day => $values) {
            foreach((array)$values as $product){
                if($product){
                    $sale+= ($product['price1'] + $product['price2']) * $product['quantity'];
                }
            }
        }
        return $sale;
    }
}
