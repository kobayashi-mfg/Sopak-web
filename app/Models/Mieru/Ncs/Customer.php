<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = '顧客住所';
    protected $primaryKey = 'ID';

    public static function getCustomerArr(){
        $customers = Customer::get();
        $customer_arr = array();
        foreach ($customers as $cus) {
            array_push($customer_arr, $cus->original);
        }
        return $customer_arr;
    }

    public static function getCustomerKanji($id){
        $customers = Customer::where('客先コード', '=', $id)->get();
        $customer = $customers[0]->original;
        if($customer){
            return $customer['漢字名'];
        }else{
            return null;
        }
    }
}
