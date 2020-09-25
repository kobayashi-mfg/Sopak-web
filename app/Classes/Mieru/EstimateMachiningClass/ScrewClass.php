<?php

namespace App\EstimateMachiningClass;

use Illuminate\Http\Request;
use App\Models\Ncs\Screw;
use App\EstimateMachiningClass\DrilClass;
use App\EstimateMachiningClass\AppSettings;


class ScrewClass
{
    private $diameter;
    private $depth;
    private $quantity;
    private $is_blindhole;

    public function __construct($process){
        $this->diameter = $process['diameter'];
        $this->depth = $process['depth'];
        $this->quantity = $process['count'];
        $this->is_blindhole = $process['is_blindhole'];
    }

    public function GetCenterDrilCuttingTimeMinute($material, $screw){
        return ($this->diameter - 1/2)/ $this->GetFeeding($material, $screw);
    }

    //一回当たりのねじ切りだけの時間を取得します。
    private function GetScrewCuttingTimeOnce($material, $screw){
        $screw_rotation = 1;
        $point_rotation = $this->GetPointRotation($material, $screw);
        $spiral_rotation = $this->GetSpiralRotation($material, $screw);

        if(!$this->is_blindhole){  //止めねじでないならポイントタップ、止めねじならスパイラルタップの回転数を取得
            $screw_rotation = $point_rotation;
            if($screw_rotation == 0){
                //phpではメッセージボックスまたはアラートを出せないので、勝手にスパイラルタップで加工を行う
                $screw_rotation = $spiral_rotation;
            }
        }
        return $this->depth / ($screw_rotation * $screw->pich);
    }

    public function GetPointRotation($material, $screw){
        $feeding_column = strtolower($material).'_point_rotation';
        return $screw->$feeding_column;
    }

    public function GetSpiralRotation($material, $screw){
        $feeding_column = strtolower($material).'_spiral_rotation';
        return $screw->$feeding_column;
    }

	/// 材料に対応したセンタードリル送り速度
    public function GetFeeding($material, $screw){
        $feeding_column = strtolower($material).'_center_dril_feeding';
        return $screw->$feeding_column;
    }

	/// この加工の計算結果を返します。数量考慮します。
    public function CalculateManufacturingTime($material_type){
        $screw = Screw::where('diameter', '=', $this->diameter)->first();
        $result = 0;
        $result += $this->GetCenterDrilCuttingTimeMinute($material_type, $screw);
        $match_screw_pilot_hole = $screw->pilot_hole_diameter;
        $result += DrilClass::GetDrilProcessingTimes($material_type, $match_screw_pilot_hole, $this->depth, $this->quantity);   //下穴の切削時間
        $result += ($this->GetScrewCuttingTimeOnce($material_type, $screw) * $this->quantity) + AppSettings::$SetupTimeOfOnce;  //ねじ切りの切削時間
        return $result;
    }


}
