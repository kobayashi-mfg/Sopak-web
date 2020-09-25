<?php
namespace App\Classes\Mieru\Library;
use Illuminate\Http\Request;
use DateTime;

class NcSearchSetting{
    private $setting = [];

    private $setday;
    private $finishday;
    private $display_interval;
    private $this_month_last_day;
    private $kikai_startday;

    public function __construct(Request $request){
        $this->setting['display_interval'] = $this->setDisplayInterval($request);
        $this->setting['startday'] = $this->setStartday($request);
        $this->setting['finishday'] = $this->setFinishday($request);
        $this->setting['without_bankin'] = $this->setWithoutbankin($request);
        $this->setting['this_month_last_day'] = $this->setThisMonthLastDay();
        $this->setting['kikai_startday'] = $this->setKikaiStartday();
    }

    public function __get($key){
        return $this->setting[$key];
    }

    public function setDisplayInterval($request){
        if(isset($request->display_interval)){
            // $this->display_interval = $request->display_interval;
            return $request->display_interval;
        }else{
            // $this->display_interval = "day";
            return "day";
        }
    }

    public function setStartday($request){
        if(isset($request->startday)){
            $setday = new DateTime($request->startday);
            if($request->display_interval == "month"){
                $setday= $setday->modify('first day of this month');
            }
        }else{
            $setday = new DateTime();
            $setday= $setday->modify('first day of this month');
        }
        return $setday->format('Y-m-d');
    }

    public function setFinishday($request){
        if(isset($request->finishday)){
            if($request->finishday <= $request->startday){
                $setday = new DateTime($request->startday);
            }else{
                $setday = new DateTime($request->finishday);
            }

            if($request->display_interval == "month"){
                $setday = $setday->modify('last day of this month');
            }
        }else{
            $setday = new DateTime();
            $setday->modify('last day of this month');
        }
        return $setday->format('Y-m-d');
    }

    public function setWithoutbankin($request){
        if(isset($request->without_bankin)){
            return true;
        }else{
            return false;
        }
    }

    public function setThisMonthLastDay(){
        $this_month_last_day = new DateTime();
        $this_month_last_day = $this_month_last_day->modify('last day of this month');
        return $this_month_last_day->format('Y-m-d');
    }

    public function setKikaiStartday(){
        $setday = new DateTime("2019-03-01");
        return $setday->format('Y-m-d');
    }
}
