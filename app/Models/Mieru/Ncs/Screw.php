<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class Screw extends Model
{
    protected $table='screws';

    protected $fillable = [
        'diameter',
        'pich',
        'pilot_hole_diameter',
        'is_blind_hole',
        'ss_point_rotation',
        'sus_point_rotation',
        'al_point_rotation',
        'ss_spiral_rotation',
        'sus_spiral_rotation',
        'al_spiral_rotation',
        'ss_center_dril_feeding',
        'sus_center_dril_feeding',
        'al_center_dril_feeding',
    ];

    public function ValidateRulesMessages(){
        return array(
            'rules' => [
                'diameter' => 'required|between:0,100000',
                'pich' => 'required|between:0,100000',
                'pilot_hole_diameter' => 'required|between:0,100000',
                'is_blind_hole' => 'nullable',
                'ss_point_rotation' => 'required|between:0,100000',
                'sus_point_rotation' => 'required|between:0,100000',
                'al_point_rotation' => 'required|between:0,100000',
                'ss_spiral_rotation' => 'required|between:0,100000',
                'sus_spiral_rotation' => 'required|between:0,100000',
                'al_spiral_rotation' => 'required|between:0,100000',
                'ss_center_dril_feeding' => 'required|between:0,100000',
                'sus_center_dril_feeding' => 'required|between:0,100000',
                'al_center_dril_feeding' => 'required|between:0,100000',
            ],
            'messages' => [
                'diameter.required' => '工具径を入力して下さい。',
                'diameter.between' => '工具径は0以上100000以下で入力して下さい。',
                'pich.required' => 'ピッチを入力して下さい。',
                'pich.between' => 'ピッチは0以上100000以下で入力して下さい。',
                'pilot_hole_diameter.required' => '下穴径を入力して下さい。',
                'pilot_hole_diameter.between' => '下穴径は0以上100000以下で入力して下さい。',
                'is_blind_hole.nullable' => '止まり穴かどうかを入力して下さい。',
                'ss_point_rotaion.required' => 'ポイントタップ回転速度(SS)を入力して下さい。',
                'ss_point_rotaion.between' => 'ポイントタップ回転速度(SS)は0以上100000以下で入力して下さい。',
                'sus_point_rotaion.required' => 'ポイントタップ回転速度(SUS)を入力して下さい。',
                'sus_point_rotaion.between' => 'ポイントタップ回転速度(SUS)は0以上100000以下で入力して下さい。',
                'al_point_rotaion.required' => 'ポイントタップ回転速度(Al)を入力して下さい。',
                'al_point_rotaion.between' => 'ポイントタップ回転速度(Al)は0以上100000以下で入力して下さい。',
                'ss_spiral_rotaion.required' => 'スクリュータップ回転速度(SS)を入力して下さい。',
                'ss_spiral_rotaion.between' => 'スクリュータップ回転速度(SS)は0以上100000以下で入力して下さい。',
                'sus_spiral_rotaion.required' => 'スクリュータップ回転速度(SUS)を入力して下さい。',
                'sus_spiral_rotaion.between' => 'スクリュータップ回転速度(SUS)は0以上100000以下で入力して下さい。',
                'al_spiral_rotaion.required' => 'スクリュータップ回転速度(Al)を入力して下さい。',
                'al_spiral_rotaion.between' => 'スクリュータップ回転速度(Al)は0以上100000以下で入力して下さい。',
                'ss_center_dril_feeding.required' => 'センタードリル送り速度(SS)を入力して下さい。',
                'ss_center_dril_feeding.between' => 'センタードリル送り速度(SS)は0以上100000以下で入力して下さい。',
                'sus_center_dril_feeding.required' => 'センタードリル送り速度(SUS)を入力して下さい。',
                'sus_center_dril_feeding.between' => 'センタードリル送り速度(SUS)は0以上100000以下で入力して下さい。',
                'al_center_dril_feeding.required' => 'センタードリル送り速度(Al)を入力して下さい。',
                'al_center_dril_feeding.between' => 'センタードリル送り速度(Al)は0以上100000以下で入力して下さい。',
            ]
        );
    }


    public function storeMachingTool($request){
        $screw = new Screw();
        $screw->fill($request->all());
        $screw->timestamps = false;
        $screw->save();
    }
}
