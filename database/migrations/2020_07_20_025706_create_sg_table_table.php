<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sg_table', function (Blueprint $table) {
            $table->integer('Sg_kb');
            $table->integer('Sg_sb');
            $table->string('Sg_zb');
            $table->integer('Sg_Mkb');
            $table->integer('Sg_Tkb');
            $table->string('Sg_Sn');
            $table->string('Sg_snou');
            $table->string('Sg_Syotei');
            $table->string('Sg_Ssha');
            $table->integer('Sg_Sshac');

            $table->float('Sg_Jtstan');
            $table->float('Sg_Jnbtan');
            $table->float('Sg_Sgytan');
            $table->integer('Sg_Seisuu');
            $table->integer('Sg_Sgytan_old');
            $table->string('Sg_Biko');
            $table->string('Sg_Sbiko');
            $table->string('Sg_St');
            $table->integer('Sg_Osb');
            $table->integer('Sg_Ksb');

            $table->string('Sg_Chakb');
            $table->string('Sg_Chakt');
            $table->string('Sg_Kanb');
            $table->string('Sg_Kant');
            $table->string('Sg_Chakt2');
            $table->string('Sg_Chakb2');
            $table->string('Sg_Kanb2');
            $table->string('Sg_Kant2');
            $table->string('Sg_HenF');
            $table->integer('Sg_Jun');

            $table->integer('Sg_SoutiNo');
            $table->integer('SgID');
            $table->integer('Sg_CaMe');
            $table->integer('Sg_CaFa');
            $table->integer('Sg_SubCam1')->nullable();
            $table->integer('Sg_SubCam2')->nullable();
            $table->integer('Sg_SubCam3')->nullable();
            $table->string('Sg_Sousai');
            $table->string('Sg_Control');
            $table->integer('Id_num');

            //プライマリキー設定
            $table->unique(['Sg_kb', 'Sg_sb', 'Sg_Sn', 'ID_Num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sg_table');
    }
}
