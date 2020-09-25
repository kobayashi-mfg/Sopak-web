<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class Endmill extends Model
{
    protected $fillable = [
        'diameter',
        'endmill_name',
        'ss_grooving_rotation',
        'sus_grooving_rotation',
        'al_grooving_rotation',
        'ss_grooving_feeding',
        'sus_grooving_feeding',
        'al_grooving_feeding',
        'ss_sideface_rotation',
        'sus_sideface_rotation',
        'al_sideface_rotation',
        'ss_sideface_feeding',
        'sus_sideface_feeding',
        'al_sideface_feeding',
    ];

    protected $table='endmills';

    public static $FinishToolPrefix = "仕上げ";

    public static function getEndmillContains($prefix, $diameter){
        $endmill = Endmill::where('endmill_name', 'like', '%'.$prefix.'%')->where('diameter', '=', $diameter)->first();
        return $endmill;
    }

    public function ValidateRulesMessages(){
         return array(
           'rules'=> [
               'diameter' => 'required|between:0,100000',
               'endmill_name' => 'required|max:20',
               'ss_grooving_rotation'=> 'required|numeric|between:0,100000',
               'sus_grooving_rotation'=> 'required|numeric|between:0,100000',
               'al_grooving_rotation'=> 'required|numeric|between:0,100000',
               'ss_grooving_feeding'=> 'required|numeric|between:0,100000',
               'sus_grooving_feeding'=> 'required|numeric|between:0,100000',
               'al_grooving_feeding'=> 'required|numeric|between:0,100000',
               'ss_sideface_rotation'=> 'required|numeric|between:0,100000',
               'sus_sideface_rotation'=> 'required|numeric|between:0,100000',
               'al_sideface_rotation'=> 'required|numeric|between:0,100000',
               'ss_sideface_feeding'=> 'required|numeric|between:0,100000',
               'sus_sideface_feeding'=> 'required|numeric|between:0,100000',
               'al_sideface_feeding'=> 'required|numeric|between:0,100000',
           ],
           'messages'=>[
               'diameter.required' => '直径を入力して下さい。',
               'diameter.between' => '直径は0以上100000以下で入力して下さい。',
               'endmill_name.required' => '名前を入力して下さい。',
               'endmill_name.max' => '名前は20文字以下で入力して下さい。',
               'ss_grooving_rotation.required' => '溝切削回転速度(SS)を入力して下さい。',
               'ss_grooving_rotation.between' => '溝切削回転速度(SS)を0以上100000以下で入力して下さい。',
               'sus_grooving_rotation.required' => '溝切削回転速度(SUS)を入力して下さい。',
               'sus_grooving_rotation.between' => '溝切削回転速度(SUS)を0以上100000以下で入力して下さい。',
               'al_grooving_rotation.required' => '溝切削回転速度(Al)を入力して下さい。',
               'al_grooving_rotation.between' => '溝切削回転速度(Al)を0以上100000以下で入力して下さい。',
               'ss_grooving_feeding.required' => '溝切削送り速度(SS)を入力して下さい。',
               'ss_grooving_feeding.between' => '溝切削送り速度(SS)を0以上100000以下で入力して下さい。',
               'sus_grooving_feeding.required' => '溝切削送り速度(SUS)を入力して下さい。',
               'sus_grooving_feeding.between' => '溝切削送り速度(SUS)を0以上100000以下で入力して下さい。',
               'al_grooving_feeding.required' => '溝切削送り速度(Al)を入力して下さい。',
               'al_grooving_feeding.between' => '溝切削送り速度(Al)を0以上100000以下で入力して下さい。',
               'ss_sideface_rotation.required' => '側面切削回転速度(SS)を入力して下さい。',
               'ss_sideface_rotation.between' => '側面切削回転速度(SS)を0以上100000以下で入力して下さい。',
               'sus_sideface_rotation.required' => '側面切削回転速度(SUS)を入力して下さい。',
               'sus_sideface_rotation.between' => '側面切削回転速度(SUS)を0以上100000以下で入力して下さい。',
               'al_sideface_rotation.required' => '側面切削回転速度(Al)を入力して下さい。',
               'al_sideface_rotation.between' => '側面切削回転速度(Al)を0以上100000以下で入力して下さい。',
               'ss_sideface_feeding.required' => '側面切削送り速度(SS)を入力して下さい。',
               'ss_sideface_feeding.between' => '側面切削送り速度(SS)を0以上100000以下で入力して下さい。',
               'sus_sideface_feeding.required' => '側面切削送り速度(SUS)を入力して下さい。',
               'sus_sideface_feeding.between' => '側面切削送り速度(SUS)を0以上100000以下で入力して下さい。',
               'al_sideface_feeding.required' => '側面切削送り速度(Al)を入力して下さい。',
               'al_sideface_feeding.between' => '側面切削送り速度(Al)を0以上100000以下で入力して下さい。',
           ]
       );
    }

    public function storeMachingTool($request){
        $endmill = new Endmill();
        $endmill->fill($request->all());
        $endmill->timestamps = false;
        $endmill->save();
    }

}
