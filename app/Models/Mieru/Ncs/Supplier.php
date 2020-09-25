<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table='suppliers';

    public static function getSupplier(){
        $supps = Supplier::where('is_deleted', '=', 'false')->orderBy('name', 'asc')->get();

        $suppliers = array();
        foreach ($supps as $sup) {
            array_push($suppliers, $sup->original);
        }
        return $suppliers;
    }
}
