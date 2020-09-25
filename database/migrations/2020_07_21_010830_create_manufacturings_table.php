<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturings', function (Blueprint $table) {
            $table->id();
            $table->string('estimate_group_id');
            $table->string('type');
            $table->float('diameter');
            $table->float('distance');
            $table->float('depth');
            $table->float('depth_of_once');
            $table->integer('quantity');
            $table->boolean('is_blind_hole');
            $table->float('chamfer_size');
            $table->boolean('is_sanding');
            $table->float('cutting_time');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufacturings');
    }
}
