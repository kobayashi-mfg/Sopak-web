<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->string('group_id');
            $table->integer('revision_number');
            $table->integer('worker_id');
            $table->integer('customer_id');
            $table->string('figure_id');
            $table->string('material_type');
            $table->float('material_width');
            $table->float('material_height');
            $table->float('material_depth');
            $table->integer('material_cost');
            $table->integer('is_temporary_material_cost');
            $table->integer('change_count');
            $table->float('coding_time');
            $table->float('dry_run_time');
            $table->float('jig_creation_time');
            $table->float('manufacturing_time');
            $table->float('total_time');
            $table->integer('unit_price');
            $table->integer('quantity');
            $table->integer('total_price');
            $table->integer('adjusted_price');
            $table->string('adjustment_reason');
            $table->timestamp('created_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimates');
    }
}
