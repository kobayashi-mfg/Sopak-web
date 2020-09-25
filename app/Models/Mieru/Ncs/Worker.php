<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table='workers';

    public function getById($id){
        $workers = Worker::where('id', '=', $id)->get();
        // 新しい日付順に取得する
        // $sql= "SELECT * FROM workers where id = ?;";

        if(empty($workers)){
            return null;
        }else{
            return $workers[0]->original['worker_name'];
        }
    }
}
