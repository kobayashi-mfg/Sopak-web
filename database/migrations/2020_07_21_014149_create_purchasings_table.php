<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasings', function (Blueprint $table) {
            $table->id();
            $table->integer('stamp');
            $table->integer('outsource_no');
            $table->integer('serial_no');
            $table->integer('work_no');
            $table->integer('slip_no');
            $table->string('customer_id');
            $table->string('customer_kanji');
            $table->string('control_no');
            $table->string('outsourcer_id');

            $table->string('outsourcer_name');
            $table->string('outsourcer_kana');
            $table->dateTime('arrived_at');
            $table->integer('display_order');
            $table->string('figure_id');
            $table->string('product_name');
            $table->text('content');
            $table->integer('quantity');
            $table->integer('outsourced_unit_price');
            $table->integer('subtotal');

            $table->dateTime('outsourcer_delivery_at');
            $table->dateTime('customer_delivery_at');
            $table->dateTime('arrange_at');
            $table->string('next_process');
            $table->string('next_process_to');
            $table->string('division');
            $table->string('staff');
            $table->boolean('is_arrived');
            $table->dateTime('deadline');
            $table->integer('tax_rate');

            $table->integer('adjustment');
            $table->text('remark');
            $table->text('addendum');
            $table->text('progress');
            $table->dateTime('accepted_at');
            $table->boolean('is_accepted');
            $table->boolean('outsource_ledger_migration');
            $table->string('order_requester');
            $table->string('author');
            $table->string('updated_by');

            $table->timestamps();
            $table->integer('integration_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchasings');
    }
}
