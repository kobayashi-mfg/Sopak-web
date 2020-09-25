<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create顧客住所Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('顧客住所', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('Stamp');
            $table->string('客先コード');
            $table->string('漢字名')->nullable();
            $table->string('フォルダー名称')->nullable();
            $table->string('所属')->nullable();
            $table->string('ニックネーム')->nullable();
            $table->string('カナ名')->nullable();
            $table->string('郵便番号')->nullable();
            $table->string('住所１')->nullable();

            $table->string('住所２')->nullable();
            $table->string('電話番号')->nullable();
            $table->string('FAX番号')->nullable();
            $table->string('代表e-mail')->nullable();
            $table->string('短縮')->nullable();
            $table->float('係数１')->nullable();
            $table->float('係数２')->nullable();
            $table->string('備考１')->nullable();
            $table->string('備考２')->nullable();
            $table->string('担当者1')->nullable();

            $table->string('担当者2')->nullable();
            $table->string('担当者3')->nullable();
            $table->string('担当者4')->nullable();
            $table->string('締切日')->nullable();
            $table->string('支払日')->nullable();
            $table->boolean('客先会社');
            $table->boolean('客先社員');
            $table->boolean('仕入会社');
            $table->boolean('社員');
            $table->boolean('年賀状');

            $table->boolean('お気に入り');
            $table->string('更新者')->nullable();
            $table->dateTime('更新日時')->nullable();

            //プライマリキー設定
            $table->unique(['客先コード']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('顧客住所');
    }
}
