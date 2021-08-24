<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_tbl_id');
			$table->date('prod_date');
			//$table->time('order_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->float('fmr_opt_wgt_min', 7, 2);
			$table->float('fmr_opt_wgt_max', 7, 2);
			$table->integer('order_qty');
			$table->integer('done_qty')->default('0');
			$table->integer('failed_qty')->default('0');
			$table->integer('status')->default('1');
			$table->unsignedBigInteger('customer_tbl_id')->index();
			$table->unsignedBigInteger('mould_mdl_tbl_id')->index();
			$table->unsignedBigInteger('cs_tbl_id')->index();
			
			$table->foreign('customer_tbl_id')->references('customer_tbl_id')->on('customers');
			$table->foreign('mould_mdl_tbl_id')->references('mould_mdl_tbl_id')->on('mould_models');
			$table->foreign('cs_tbl_id')->references('cs_tbl_id')->on('casting_stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
