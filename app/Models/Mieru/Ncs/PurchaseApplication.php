<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class PurchaseApplication extends Model
{
    protected $table='purchase_applications';

    public static function getAll($status){
        switch ($status) {
            case '':    //削除以外すべての場合
                $apps = static::getAllExceptDelete();
                break;
            default:
                $apps = static::getOnly($status);
                break;
        }
        return $apps;
    }

    //ソフトデリートしたもの以外を呼ぶ
    public static function getAllExceptDelete(){
        $apps = PurchaseApplication::where('status','>','0')->orderBy('created_at', 'desc')->paginate(10);
        // $result = array();
        // foreach ($apps as $app) {
        //     array_push($result, $app->original);
        // }
        return $apps;
    }

    //状態に合わせた申請を呼び出す
    public static function getOnly($status){
        $apps = PurchaseApplication::where('status','=', $status)->orderBy('created_at', 'desc')->paginate(10);
        // $result = array();
        // foreach ($apps as $app) {
        //     array_push($result, $app->original);
        // }
        return $apps;
    }

}
