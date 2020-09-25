<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthNcWorktimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('month_nc_worktime', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->integer('worktime');
            $table->timestamp('created_at');

            //プライマリキー設定
            $table->unique(['date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('month_nc_worktime');
    }
}
