<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndmillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endmills', function (Blueprint $table) {
            $table->id();
            $table->double('diameter');
            $table->string('endmill_name');
            $table->integer('ss_grooving_rotation');
            $table->integer('sus_grooving_rotation');
            $table->integer('al_grooving_rotation');
            $table->integer('ss_grooving_feeding');
            $table->integer('sus_grooving_feeding');
            $table->integer('al_grooving_feeding');
            $table->integer('ss_sideface_rotation');
            $table->integer('sus_sideface_rotation');
            $table->integer('al_sideface_rotation');
            $table->integer('ss_sideface_feeding');
            $table->integer('sus_sideface_feeding');
            $table->integer('al_sideface_feeding');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endmills');
    }
}
