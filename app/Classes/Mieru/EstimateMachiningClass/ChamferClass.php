<?php

namespace App\EstimateMachiningClass;

use Illuminate\Http\Request;
use App\Models\Ncs\Chamfer;
use App\Models\Ncs\Endmill;


class ChamferClass
{
    private $distance;
    private $quantity;
    private $C_lengthe;
    private $is_thunder;

    public function __construct($process){
        $this->distance = $process['distance'];
        $this->quantity = $process['count'];
        $this->C_length = $process['C_length'];
        $this->is_thunder = $process['is_thunder'];
    }

    public function GetCuttingTimeMinute($material){
        $master_chamfer = Chamfer::first();
        $chamfer_size = $this->C_length;
        if($chamfer_size <= 3){
            return $this->distance / $this->GetFeeding($material, $master_chamfer);
        }else if (3 < $chamfer_size && $chamfer_size < 7){
            return ceil($chamfer_size / 2) * $this->distance / $this->GetFeeding($material, $master_chamfer);
        }else{
            $em_of_use = Endmill::orderBy('diameter', 'desc')->where('diameter', '>=', $this->diameter)->first();
            $cs = 2;
            while(true){
                $this->distance += $cs * sqrt(2);
                $cs += 2.0;
                if($chamfer_size <= $cs){ break; }
                if($chamfer_size - 2 < $cs && $cs < $chamfer_size){ $cs = $chamfer_size; }
            }
            return $this->distance / $this->GetFeeding($material, $em_of_use);
        }
    }

    public function GetFeeding($material, $chamfer){
        $feeding_column = strtolower($material).'_feeding';
        return $chamfer->$feeding_column;
    }

	/// この加工の計算結果を返します。数量考慮します。
    public function CalculateManufacturingTime($material_type){
        return $this->is_thunder ? 2 : $this->GetCuttingTimeMinute($material_type);
    }


}
