<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mieru\Ncs\Work;
use \DateTime;

class Product extends Model
{
    protected $table='producting';


    //リピート品かどうか
    public static function isRepeatProduct($product){
        $seiban = $product['id'];
        $zuban = $product['product_no'];

        $past_products = Product::where('product_no', '=', $zuban)->orderBy('delivery_date', 'asc')->get();
        // $sql ="SELECT * from producting where product_no = ? order by delivery_date asc;";

        //リピート品なら過去の製造記録が複数あるはず。
        if(!empty($past_products[0]) && $seiban !== $past_products[0]['id']){
            return true;
        }else{
            return false;
        }
    }

    //図番製品取得
    public static function getProductsByZuban($zuban){
        $products = Product::where('product_no', '=', $zuban)->orderBy('delivery_date', 'desc')->get();
        $result = array();
        foreach ($products as $product) {
            array_push($result, $product->original);
        }
        return $result;
    }

    // 実際に制作した製品を得る
    public static function getMadeProducts($works, $startday, $finishday, $except_bankin){
        //作業製番に被りのない作業を集める
        $works_not_overlap = static::_deleteWorkOverlap($works);

        //被りのない製番を使って作業をとってくる(表示日付外の日付の製品も含まれる)
        $works_recapture = static::_recaptureWork($works_not_overlap, $except_bankin);


        $products = array();
        foreach ($works_recapture as $work){
            $product = static::_getProduct($work['Sg_sb']);
            if(!array_key_exists($work['Sg_Chakb'],$products)){
                $products[$work['Sg_Chakb']] = array();
            }
            array_push($products[$work['Sg_Chakb']],$product);
        }

        //表示日付外の製品を省く
        $select_products = static::_selectProducts($products,$startday,$finishday);
        return $select_products;
    }


    //重なっていない製番の作業だけ抜き出す
    private static function _deleteWorkOverlap($works){
        //重なりを消すために日付の最新順にする
        $reversed_work = array_reverse($works);

        //重なりを消す 後ろ(最新から見て行って製番が重なっていないのを抜き出す)
        $tmp_work = array();
        foreach($reversed_work as $day => $values){
            if($values){
                foreach((array)$values as $work){
                    $Sg_sb_array =  array_column($tmp_work,'Sg_sb');
                    if(!in_array($work['Sg_sb'], $Sg_sb_array)){
                        array_push($tmp_work, $work);
                    }
                }
            }
        }
        return $tmp_work;
    }

    //作業台帳より制作した製品に対する最新作業を取得
    private static function _recaptureWork($works, $except_bankin){
        $result_works = array();
            foreach($works as $work){
                $is_accepted = true;
                if( $except_bankin ){
                    $results = Work::where('Sg_Sb', '=', $work['Sg_sb'])
                                ->where(function($query){
                                    $query->where('Sg_Sn','like', '%曲%')->orWhere('Sg_Sn', 'like', '%溶接%');
                                })->get();

                    foreach($results as $work){
                        if(isset($work->original)){
                            $is_accepted = false;
                            break;
                        }
                    }
                }
                if($is_accepted ){
                    $result = Work::where('Sg_sb', '=', $work['Sg_sb'])->where('Sg_Sn','=', '機械加工')->OrderBy('Sg_Chakb','desc')->limit(1)->get();

                    foreach ($result as $value) {
                        if(isset($value->original)){
                            $push_result = $value->original;
                            array_push($result_works, $push_result);
                        }
                    }
                }
            }
        return $result_works;
    }

    private static function _getProduct($Sg_sb){
        $result = 0;
        $results = static::where('id', '=', $Sg_sb)->limit(1)->get();
        // $stmt = $this->_db->query("SELECT * FROM producting WHERE id='".$Sg_sb ."' LIMIT 1;");

        if(isset($results[0]->original)){
            return $results[0]->original;
        }else{
            return null;
        }
    }

    //表示日付外の製品を省く
    private static function _selectProducts($products,$startday,$finishday){
        $searchDate = new DateTime($startday);
        $finishday = new DateTime($finishday);
        $interval_days = $searchDate->diff($finishday)->days + 1;

        $result = array();
        for ($i = 0; $i < $interval_days; $i++){
            $searchDay = $searchDate->format('y/m/d');

            if(array_key_exists($searchDay, $products)){
                $search_products = $products[$searchDay];
                $result[$searchDay]=$search_products;
            }else{
                $result[$searchDay]=0;
            }
            $searchDate = $searchDate->modify('+1 days');
        }

        return $result;
    }
}
