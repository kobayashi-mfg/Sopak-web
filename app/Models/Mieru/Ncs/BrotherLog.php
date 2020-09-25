<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;

class BrotherLog extends Model
{
    protected $table='brother_logs';

    public static function getForGraph($key,$startday,$finishday,$display){
        $startday = new DateTime($startday);
        $finishday = new DateTime($finishday);
        $firstDate = new DateTime($startday->format('y-m-d'),new DateTimeZone('Asia/Tokyo'));
        $result_arr = [];
        $k = 0;

            if($display == "day"){
                $diff = $startday->diff($finishday);
                $interval = $diff->days + 1;
                for ($i = 0; $i < $interval; $i++){
                    $log = BrotherLog::where('date', '=', $firstDate)->first();
                    // $item = array();
                    $searchDay = $firstDate->format('y-m-d');
                    if($log){
                        switch ($key) {
                            case 'quantity':
                                $result_arr[$searchDay] = $log->$key;
                                break;
                            case 'operate_time':
                                $result_arr[$searchDay] = round(($log->$key)/10/60);
                                break;
                            default:
                                break;
                        }
                    }else{
                        $result_arr[$searchDay] = 0;
                    }

                    $firstDate = $firstDate->modify('+1 days');
                }
            }else{  //$diplay == "month"
                $finishDate = new DateTime($finishday->format('y-m-d'),new DateTimeZone('Asia/Tokyo'));
                $interval_month = ($finishDate->format('y') - $firstDate->format('y') ) * 12 + ($finishDate->format('m') - $firstDate->format('m') ) +1;

                //!!!!!!diff->mが月によって結果がバラバラなため利用できず
                $secondDate = new DateTime($startday->format('y-m-d'),new DateTimeZone('Asia/Tokyo'));
                $secondDate = $secondDate->modify('last day of this month');

                for ( $j = 0; $j < $interval_month; $j++){
                    $logs = BrotherLog::where('date','>=', $firstDate)->where('date', '<=', $secondDate)->get();
                    $result = 0;
                    foreach ($logs as $log) {
                        switch ($key) {
                            case 'quantity':
                                $result += $log->$key;
                                break;
                            case 'operate_time':
                                $result += ($log->$key)/10/60;
                                break;
                            default:
                                break;
                        }
                    }
                    $result_arr[$firstDate->format('y-m-d')] = round($result);
                    $firstDate->modify('first day of next month');
                    $secondDate->modify('last day of next month');
                }
            }
        return $result_arr;
    }


}
