<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class Dril extends Model
{
    protected $table='drils';

    protected $fillable = [
        'diameter',
        'ss_rotation',
        'sus_rotation',
        'al_rotation',
        'ss_feeding',
        'sus_feeding',
        'al_feeding',
    ];

    public function ValidateRulesMessages(){
        return array(
            'rules' => [
                'diameter' => 'required|between:0,100000',
                'ss_rotation' => 'required|between:0,100000',
                'sus_rotation' => 'required|between:0,100000',
                'al_rotation' => 'required|between:0,100000',
                'ss_feeding' => 'required|between:0,100000',
                'sus_feeding' => 'required|between:0,100000',
                'al_feeding' => 'required|between:0,100000',
            ],
            'messages' => [
                'diameter.required' => '工具径を入力して下さい。',
                'diameter.between' => '工具径は0以上100000以下で入力して下さい。',
                'ss_rotation.required' => '回転速度(SS)を入力して下さい。',
                'ss_rotation.between' => '回転速度(SS)を0以上100000以下で入力して下さい。',
                'sus_rotation.required' => '回転速度(SUS)を入力して下さい。',
                'sus_rotation.between' => '回転速度(SUS)を0以上100000以下で入力して下さい。',
                'al_rotation.required' => '回転速度(Al)を入力して下さい。',
                'al_rotation.between' => '回転速度(Al)を0以上100000以下で入力して下さい。',
                'ss_feeding.required' => '送り速度(SS)を入力して下さい。',
                'ss_feeding.between' => '送り速度(SS)を0以上100000以下で入力して下さい。',
                'sus_feeding.required' => '送り速度(SUS)を入力して下さい。',
                'sus_feeding.between' => '送り速度(SUS)を0以上100000以下で入力して下さい。',
                'al_feeding.required' => '送り速度(Al)を入力して下さい。',
                'al_feeding.between' => '送り速度(Al)を0以上100000以下で入力して下さい。',

            ]
        );
    }

    public function storeMachingTool($request){
        $dril = new Dril();
        $dril->fill($request->all());
        $dril->timestamps = false;
        $dril->save();
    }

}
