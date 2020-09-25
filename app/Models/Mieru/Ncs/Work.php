<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Work extends Model
{
    protected $table='sg_table';

    //作業最終日取得
    public static function getWorkLastDay($id){
        $ws = Work::where('Sg_sb', '=', $id)->where('Sg_Sn', '=', '機械加工')->get();
        $works= array();
        foreach($ws as $w){
            array_push($works, $w->original);
        }
        // $sql ="SELECT * FROM sg_table where Sg_sb = ? AND Sg_Sn ='機械加工';";

        $last_work=end($works);
        return $last_work['Sg_Chakb'];
    }

    public static function getWorkTimeSum($works){
        $sum = 0;
        foreach ($works as $day => $values) {
            if($values){
                foreach ($values as $work) {
                    $sum+=$work['Sg_Jtstan'];
                }
            }
        }
        return $sum;
    }

    //製番における作業時間計
    public static function getWorkTimeArrByProduct($product){
        $works = Work::where('Sg_sb', '=', $product['id'])->where('Sg_Sn', '=', '機械加工')->get();
        $time_arr = [];
        // $sql ="SELECT * FROM sg_table where Sg_sb = ? AND Sg_Sn ='機械加工';";

        if($works){
            foreach($works as $target_work){
                $sagyos = Work::Where('Sg_Chakb', '=', $target_work->original['Sg_Chakb'])->where('Sg_Sn', '=', '機械加工')->get();

                $sgs = array();
                foreach ($sagyos as $sagyo) {
                    array_push($sgs, $sagyo->original);
                }
                // //ターゲット作業と同じ日の作業を取ってくる
                // $sql ="SELECT * FROM sg_table where Sg_Chakb = ? AND Sg_Sn ='機械加工';";

                //ターゲット作業作業日における作業時間を合計する
                $time = 0;
                foreach ($sgs as $sg) {
                    $time += $sg['Sg_Jtstan'];
                }
                //ターゲット作業の一日における割合を出す
                $time_rate = $target_work['Sg_Jtstan'] / $time;

                array_push($time_arr, array($target_work['Sg_Jtstan'] => $time_rate));
            }
        }
        // $time_arr = array([0] => array(['対象の作業時間']=>[一日における対象作業時間の割合]),[1] => array(['対象の作業時間']=>[割合]))
        return $time_arr;
    }

    // 該当期間の作業を得る
    public static function getWorksDevidedByDay($startDate, $finishDate){
        $startday = new DateTime($startDate);
        $finishday = new DateTime($finishDate);
        $interval_days = $startday->diff($finishday)->days + 1;

        $firstDate = new DateTime($startDate);
        $secondDate = new DateTime($startDate);
        $secondDate = $secondDate->modify('+1 days');

        $works_in_day = array();
        for ($i = 0; $i < $interval_days; $i++){
            $works = static::getWorkDuring($firstDate, $secondDate);
            if($works){
                $works_in_day[$firstDate->format('y-m-d')] = $works;
            }else{
                $works_in_day[$firstDate->format('y-m-d')] = 0;
            }
            $firstDate = $firstDate->modify('+1 days');
            $secondDate = $secondDate->modify('+1 days');
        }

        return $works_in_day;
    }

    public static function getWorksByProducts($products){
        $work_arr = [];
        foreach($products as $day => $values){
            $work_items = array();
            foreach((array)$values as $product){
                if(!empty($product['id'])){
                    $works = Work::Where('Sg_sb','=',$product['id'])->where('Sg_Sn', '=', '機械加工')->get();
                    // $sql ="SELECT * FROM sg_table where Sg_sb = ? AND Sg_Sn ='機械加工';";
                    if(!empty($works)){
                        foreach($works as $work){
                            array_push($work_items,$work);
                        }
                    }
                }
            }
            $work_arr[$day] = $work_items;
        }
        return $work_arr;
    }

    public static function getWorkDuring($startDate, $finishDate){
        // $sql ="SELECT * FROM sg_table where Sg_Chakb >= ? AND Sg_Chakb < ? AND Sg_Sn ='機械加工';";
        $firstday = static::_changeDateFormat($startDate);
        $secondday = static::_changeDateFormat($finishDate);
        $works = static::where([
            ['Sg_Sn', '=', '機械加工'],
            ['Sg_Chakb','>=', $firstday],
            ['Sg_Chakb','<', $secondday]
        ])->get();
        $result = array();
        foreach($works as $work){
            array_push($result, $work->original);
        }
        return $result;
    }


    private static function _changeDateFormat($date){
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $want_year=substr($year,2);
        return $want_year."/".$month."/".$day;
    }
}
