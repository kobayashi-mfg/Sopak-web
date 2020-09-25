<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\EstimateMachiningClass\EstimateCalculator;

class Manufacturing extends Model
{
    protected $table='manufacturings';

    //estimateのグループidから加工想定実績を呼び出す
    public static function getByEstimateGroupId($id){
        $manus = Manufacturing::where('estimate_group_id', '=', $id)->orderBy('created_at', 'desc')->get();
        // $sql= "SELECT * FROM manufacturings where estimate_group_id = ? order by created_at desc;";
        $manufacturings = array();
        foreach ($manus as $manu) {
            array_push($manufacturings, $manu->original);
        }

        if(empty($manufacturings)){
            return null;
        }else{
            return $manufacturings;
        }
    }

    public static function getManufacturingsArr(Request $request){
        $processes = $request->register_process;
        $filled_process = array();
        $process_key = array('type','diameter', 'distance', 'depth', 'once_depth','count', 'is_blindhole', 'C_length', 'is_thunder');

        foreach ((array)$processes as $process) {
            if($process){
                $get_process = json_decode($process);
                array_push($filled_process, array_combine($process_key,$get_process));
            }else{
                break;
            }
        }
        return $filled_process;
    }

    public function getCuttingTime($request, $process_noname){
        $process_key = array('type','diameter', 'distance', 'depth', 'once_depth','count', 'is_blindhole', 'C_length', 'is_thunder');
        $process = array_combine($process_key, $process_noname);

        $calculator = new EstimateCalculator($request);
        return $calculator->CalculateManufacturingTime($process, $request->material_type);
    }
}
