<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('employee_no');  // 権限
            $table->string('fullname');// 氏名カラムを追加
            $table->string('phone')->nullable();  // 電話番号カラムを追加

            //プライマリキー設定
            $table->unique(['employee_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('employee_no');
            $table->dropColumn('fullname');
            $table->dropColumn('phone');
        });
    }
}
