<?php

namespace App\EstimateMachiningClass;

use Illuminate\Http\Request;
use App\Models\Ncs\Endmill;
use App\EstimateMachiningClass\AppSettings;


class CounterboringClass
{
    private $diameter;
    private $depth;
    private $quantity;
    public static $counter_boring_tool_prefix = "座ぐり";

    public function __construct($process){
        $this->diameter = $process['diameter'];
        $this->depth = $process['depth'];
        $this->quantity = $process['count'];
    }

    public function CalculateManufacturingTime($material){
        $time_of_match = $this->CuttingTimeOfMatch($material);
        if(!empty($time_of_match)){
            return $time_of_match;
        }

        $em_of_use = $this->GetEndmillToUse();
        if($this->diameter < 2 * $em_of_use->diameter - 0.4){ //怪しいーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
            $axial_lap_count = $this->depth / (pi() * ($this->diameter- $em_of_use->diameter) * tan(deg2rad(2)));
            $axial_trajectory_distance = ((pi() * ($this->diameter - $em_of_use->diameter)) / cos(deg2rad(2)))* $axial_lap_count;
            return (($axial_trajectory_distance / ($this->getGroovingFeeding($material, $em_of_use) / 3)) * $this->quantity ) + AppSettings::$SetupTimeOfOnce;
        }else{
            $axial_lap_count = $this->depth / (2 * pi() * ($em_of_use->diameter - 0.2) * tan(deg2rad(2)));
            $axial_trajectory_distance = ((2 * pi() * ($em_of_use->diameter -0.2)) / cos(deg2rad(2))) * $axial_lap_count;
            $cut_count = $this->depth - ($em_of_use->diameter / 4);
            $roll_count = ceil( ($this->diameter - $em_of_use->diameter) / $em_of_use->diameter);
            $radial_cut_amount = $em_of_use->diameter - 0.1;
            $radial_trajectory_distance = 2 * pi() * ( $em_of_use->diameter / 2 + ($roll_count * $radial_cut_amount)) * $roll_count * $cut_count;
            $counter_boring_distance = $axial_trajectory_distance + $radial_trajectory_distance;
            return (($counter_boring_distance / ($this->getGroovingFeeding($material, $em_of_use) / 3)) * $this->quantity) + AppSettings::$SetupTimeOfOnce;
        }
    }

	//穴径より小さい、一番大きなエンド見るを取得します。
    private function GetEndmillToUse(){
        return Endmill::where('endmill_name', 'like', '%'.Endmill::$FinishToolPrefix.'%')->orderBy('diameter', 'desc')->where('diameter', '<=', $this->diameter)->first();
    }

	//マッチする座ぐり用エンドミルがあった場合に加工時間を返します。ない場合nullを返します。
    private function CuttingTimeOfMatch($material){
        $match_tool = Endmill::getEndmillContains(static::$counter_boring_tool_prefix, $this->diameter);
        if($match_tool == null){
            $match_tool = Endmill::where('diameter', '=', $this->diameter)->first();
        }
        if($match_tool == null){ return null; }
        return  (($this->depth/ $this->getGroovingRotaion($material, $match_tool)) * $this->quantity) + AppSettings::$SetupTimeOfOnce;
    }

    public function getGroovingRotaion($material, $endmill){
        $feeding_column = strtolower($material).'_grooving_rotation';
        return $endmill->$feeding_column;
    }
    public function getGroovingFeeding($material, $endmill){
        $feeding_column = strtolower($material).'_grooving_feeding';
        return $endmill->$feeding_column;
    }
}
