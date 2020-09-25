<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_id');
            $table->string('figure_id');
            $table->string('product_name');
            $table->integer('product_id');
            $table->string('category');
            $table->string('process');
            $table->integer('sg_id');
            $table->string('server_name');

            $table->string('folder_path');
            $table->string('file_name');
            $table->string('division');
            $table->string('handling');
            $table->integer('weight');
            $table->integer('thickness');
            $table->integer('width');
            $table->integer('length');
            $table->integer('height');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pictures');
    }
}
