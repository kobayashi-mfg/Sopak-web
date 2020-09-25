<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class Worktime extends Model
{
    protected $table='month_nc_worktime';

    public static function GetMonthWorkTime($product_day){
        $pday = str_replace("/","-",$product_day);
        $search_day = '20'.$pday.' 00:00:00';

        // return $search_day;

        $worktimes = Worktime::where('date', '=', $search_day)->get();
        if(empty($worktimes[0]->worktime)){
            return 0;
        }
        return $worktimes[0]->worktime;
    }
}
