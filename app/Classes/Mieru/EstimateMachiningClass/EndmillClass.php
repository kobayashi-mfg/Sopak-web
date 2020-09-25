<?php

namespace App\EstimateMachiningClass;

use Illuminate\Http\Request;
use App\Models\Ncs\Endmill;


class EndmillClass
{
    private $diameter;
    private $distance;
    private $depth;
    private $once_depth;

    public function __construct($process){
        $this->diameter = $process['diameter'];
        $this->distance = $process['distance'];
        $this->depth = $process['depth'];
        $this->once_depth = $process['once_depth'];
    }

    public static function GetDepthBoringTime($material, $cut_depth, $endmill){
        return $cut_depth / static::GetFeeding($material, $endmill);
    }

    public static function GetFeeding($material, $endmill = null){
        $feeding_column = strtolower($material).'_grooving_feeding';
        return $endmill->$feeding_column;
    }

    public function GetFeedingFromThis($material){
        $feeding_column = strtolower($material).'_grooving_feeding';
        $endmill = Endmill::where('endmill_name','like', '仕上げ%')->where('diameter', '=', $this->diameter)->first();
        return $endmill->$feeding_column;
    }

    public function CalculateManufacturingTime($material_type){
        $count = ceil($this->depth/$this->once_depth);
        return ($this->distance / $this->GetFeedingFromThis($material_type)) * $count;
    }

    public static function GetEndmillOfUse($diameter){
        $return_endmill = null;
        $endmills = Endmill::orderBy('diameter', 'desc')->get();
        foreach ($endmills as $endmill) {
            if($endmill->diameter <= $diameter){
                $return_endmill = $endmill;
                break;
            }
        }
        return $return_endmill;
    }


}
