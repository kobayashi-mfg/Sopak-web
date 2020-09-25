<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceivedFieldsToPurchaseApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_applications', function (Blueprint $table) {
            $table->integer('received_user_id')->nullable();
            $table->dateTime('received_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_applications', function (Blueprint $table) {
            $table->dropColumn('received_user_id');
            $table->dropColumn('received_at');
        });
    }
}
