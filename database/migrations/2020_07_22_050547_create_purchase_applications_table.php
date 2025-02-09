<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('process');
            $table->integer('worker_id');
            $table->string('item_co');
            $table->string('item_name');
            $table->string('item_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('biko')->nullable();
            $table->integer('status');
            $table->timestamps();
            $table->integer('decided_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_applications');
    }
}
