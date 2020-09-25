<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screws', function (Blueprint $table) {
            $table->id();
            $table->double('diameter');
            $table->double('pich');
            $table->double('pilot_hole_diameter');
            $table->boolean('is_blind_hole')->default(0);
            $table->integer('ss_point_rotation');
            $table->integer('sus_point_rotation');
            $table->integer('al_point_rotation');
            $table->integer('ss_spiral_rotation');
            $table->integer('sus_spiral_rotation');
            $table->integer('al_spiral_rotation');
            $table->integer('ss_center_dril_feeding');
            $table->integer('sus_center_dril_feeding');
            $table->integer('al_center_dril_feeding');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('screws');
    }
}
