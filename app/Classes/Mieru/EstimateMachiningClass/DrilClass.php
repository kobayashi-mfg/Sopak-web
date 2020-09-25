<?php

namespace App\EstimateMachiningClass;

use Illuminate\Http\Request;
use App\Models\Ncs\Dril;
use App\EstimateMachiningClass\CenterdrilClass;
use App\EstimateMachiningClass\EndmillClass;
use App\EstimateMachiningClass\AppSettings;


class DrilClass
{
    private $diameter;
    private $depth;
    private $quantity;

    public function __construct($process){
        $this->diameter = $process['diameter'];
        $this->depth = $process['depth'];
        $this->quantity = $process['count'];
    }

    public static function GetCuttingTimeMinute($material, $dril, $depth){
        return $depth / static::GetFeeding($material, $dril);
    }

    public static function GetFeeding($material, $dril){
        $feeding_column = strtolower($material).'_feeding';
        return $dril->$feeding_column;
    }


    public function CalculateManufacturingTime($material_type){
        return $this->GetDrilProcessingTimes($material_type, $this->diameter, $this->depth, $this->quantity);
    }

    /// ドリル計算メソッド(新)
    public static function GetDrilProcessingTimes($material, $cut_diameter, $cut_depth, $cut_quantity){
        $match_dril = Dril::where('diameter', $cut_diameter)->first();
        if($match_dril){
            //1,2. 一致するドリルがあるケース
            return static::GetOnlyDrilCuttingTime($match_dril, $material, $cut_diameter, $cut_depth, $cut_quantity);
        }

        $near_dril = static::GetNewDril($cut_diameter);
        $use_Em = EndmillClass::GetEndmillOfUse($cut_diameter);
        if(empty($use_Em)) { throw new \Exception("穴が小さすぎるため加工できません。"); }
        $dril_time = static::GetOnlyDrilCuttingTime($near_dril, $material, $cut_diameter, $cut_depth, $cut_quantity);
        if($cut_diameter == $use_Em->diameter){
            //5. エンドミル径と加工穴径が同じケース
            $endmill_time = EndmillClass::GetDepthBoringTime($material, $cut_depth, $use_Em);
            return ($endmill_time * $cut_quantity) + AppSettings::$SetupTimeOfOnce + $dril_time;
        }

        if($cut_diameter >= 2 * $use_Em->diameter - 0.4){
            //4. 穴径 >= (2 * エンドミル径) - 0.4
            $axial_lap_count = $cut_depth / (2 * pi() * ($use_Em->diameter - 0.2) * tan(deg2rad(2.0)));
            $axial_trajectory_distance = ( ( 2 * pi() * ($use_Em->diameter - 0.2) )/cos(deg2rad(2.0)) ) * $axial_lap_count;
            $cut_count = $cut_depth / ($use_Em->diameter/4);
            $roll_count = (int) ceil( ($cut_diameter - $use_Em->diameter) / $use_Em->diameter); //C#ではすべて半径にしていたが、意味は同じになる
            $radial_cut_amout = $use_Em->diameter * 0.1; //半径方向軌道距離
            $radial_trajectory_distance = ( 2 * pi() * ($use_Em->diameter/2 +($roll_count * $radial_cut_amout))) * $roll_count * $cut_count;
            $endmill_trajectory_distance = $axial_trajectory_distance + $radial_trajectory_distance;//エンドミル軌道距離
            $endmill_cut_time = $endmill_trajectory_distance / (EndmillClass::GetFeeding($material, $use_Em) / 3);//エンドミル切削時間
            return ($endmill_cut_time * $cut_quantity) + AppSettings::$SetupTimeOfOnce + $dril_time;
        }else{
            //3. 穴径 < (2 * エンドミル径) - 0.4
            $axial_lap_count = $cut_depth / ( pi() * ($cut_diameter - $use_Em->diameter) * tan(deg2rad(2.0)));
            $axial_trajectory_distance = ((pi() * ($cut_diameter - $use_Em->diameter)) / cos(deg2rad(2.0)) * $axial_lap_count);
            $endmill_cut_time = ($axial_trajectory_distance / (EndmillClass::GetFeeding($material, $use_Em) / 3));
            return ( $endmill_cut_time * $cut_quantity) + AppSettings::$SetupTimeOfOnce + $dril_time;
        }
        return ;
    }

    private static function GetOnlyDrilCuttingTime($match_dril, $material, $cut_diameter, $cut_depth, $cut_quantity){
        $using_dril = $match_dril;
        $center_dril_time = CenterdrilClass::GetPorcessingTime($material, $cut_diameter, $cut_depth);
        $cut_time = static::GetCuttingTimeMinute($material, $using_dril, $cut_depth);
        $pilot_hole_time = static::GetPilotCuttingMin($cut_diameter, $cut_depth, $material);
        $is_over_7mm = ($cut_diameter >= 7);
        $setup_time = AppSettings::$SetupTimeOfOnce * ($is_over_7mm ? 3 : 2);
        return (($center_dril_time + $pilot_hole_time + $cut_time) * $cut_quantity) + $setup_time;
    }

    private static function GetPilotCuttingMin($parent_diameter, $depth, $material_type){
        $dril3_3 = Dril::where('diameter', '=', '3.3')->first();
        $dril3_3_depth = $depth;
        return ($parent_diameter >= 7 ? static::GetCuttingTimeMinute($material_type, $dril3_3, $dril3_3_depth) : 0);
    }

    //切りたい穴より小さいドリルを取得
    private static function GetNewDril($diameter){
        $drils = Dril::orderBy('diameter', 'desc')->get();
        $min_diff_dril = null;
        foreach($drils as $dril){
            if($dril->diameter < $diameter){
                $min_diff_dril = $dril;
                break;
            }
        }
        return $min_diff_dril;
    }
}
