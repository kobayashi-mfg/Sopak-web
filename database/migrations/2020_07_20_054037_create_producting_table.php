<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producting', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->string('product_no');
            $table->string('product_name');
            $table->integer('quantity')->nullable();
            $table->integer('customer_id')->nullable();
            $table->float('price1')->nullable();
            $table->float('price2')->nullable();
            $table->float('price3')->nullable();
            $table->float('price4')->nullable();

            $table->float('price5')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->date('ship_date')->nullable();
            $table->string('status');
            $table->string('worker_name');
            $table->date('work_date')->nullable();
            $table->integer('production_quantity')->nullable();
            $table->integer('edition_no')->nullable();
            $table->string('treatment')->nullable();

            $table->string('treatment_supplier')->nullable();
            $table->integer('child_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('treatment_code')->nullable();
            $table->date('received_order_date')->nullable();
            $table->date('billing_date')->nullable();
            $table->date('original_delivery_date')->nullable();
            $table->integer('status_flag1')->nullable();
            $table->integer('status_flag2')->nullable();
            $table->integer('status_flag3')->nullable();

            $table->string('status_flag_str1')->nullable();
            $table->string('record_status')->nullable();
            $table->integer('order_no_id')->nullable();
            $table->integer('order_no_id_index')->nullable();
            $table->integer('voucher_no')->nullable();
            $table->integer('voucher_line_quantity')->nullable();
            $table->date('vaucher_closing_date')->nullable();
            $table->date('vaucher_date')->nullable();
            $table->string('option1')->nullable();
            $table->string('option2')->nullable();

            $table->string('option3')->nullable();
            $table->string('option4')->nullable();
            $table->string('option5')->nullable();
            $table->string('option6')->nullable();
            $table->string('option7')->nullable();
            $table->string('option8')->nullable();
            $table->string('option9')->nullable();
            $table->string('option10')->nullable();
            $table->string('original_product_no')->nullable();
            $table->string('search_product_no')->nullable();

            $table->string('delivery_place')->nullable();
            $table->string('customer_stuff_code')->nullable();
            $table->float('original_quantity')->nullable();
            $table->string('order_denomination')->nullable();
            $table->string('order_reception_person_code')->nullable();
            $table->date('scheduled_delevery_date')->nullable();
            $table->float('stock')->nullable();
            $table->string('stock_flag')->nullable();
            $table->string('instruction_flag')->nullable();
            $table->float('shipment_quantity')->nullable();

            $table->integer('packing_quantity')->nullable();
            $table->string('destination')->nullable();
            $table->string('order_reception_person_barcode')->nullable();
            $table->string('latest')->nullable();
            $table->string('shipping_order')->nullable();
            $table->string('precedence_flag')->nullable();
            $table->integer('boxing_quantity')->nullable();
            $table->integer('paint_no')->nullable();
            $table->integer('ID_Num');
            $table->string('customer_id_char4')->nullable();

            // //プライマリキー設定
            // $table->unique(['product_no', 'product_name', 'status']);
            // $table->unique(['worker_name', 'ID_Num']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producting');
    }
}
