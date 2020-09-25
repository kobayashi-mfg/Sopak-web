<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamfers', function (Blueprint $table) {
            $table->id();
            $table->string('tool_name');
            $table->integer('ss_rotation');
            $table->integer('sus_rotation');
            $table->integer('al_rotation');
            $table->integer('ss_feeding');
            $table->integer('sus_feeding');
            $table->integer('al_feeding');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chamfers');
    }
}
