<?php

namespace App\EstimateMachiningClass;

use Illuminate\Http\Request;
use App\Models\Ncs\Centerdril;


class CenterdrilClass
{
    private $diameter;
    private $depth;
    private $quantity;

    public function __construct($process){
        $this->diameter = $process['diameter'];
        $this->depth = $process['depth'];
        $this->quantity = $process['count'];
    }


    public function CalculateManufacturingTime($material_type){
        return GetDrilProcessingTimes($material_type, $this->diameter, $this->depth, $this->quantity);
    }

    public static function GetFeeding($material, $centerdril){
        $feeding_column = strtolower($material).'_feeding';
        return $centerdril->$feeding_column;
    }

	/// センタードリルの加工時間を出力します。
    public static function GetPorcessingTime($material, $cut_diameter, $cut_depth){
        $centerdril = static::GetCenterdrilToUse($cut_diameter);
        // $centerdrils = Centerdril::get();
        // $centerdril = $centerdrils[0];
        if($centerdril->diameter > $cut_diameter){
            return ($cut_diameter / 2) / static::GetFeeding($material, $centerdril);
        }else{
            return (($centerdril->diameter - 2) / 2) / static::GetFeeding($material, $centerdril);
        }
    }

    public static function GetCenterdrilToUse($diameter){
        $centerdril = Centerdril::orderBy('diameter', 'asc')->where('diameter', '>', $diameter)->first();
        if(!$centerdril){
            $centerdril = Centerdril::orderBy('diameter', 'desc')->first();
        }
        return $centerdril;
    }
}
