<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerHasEpcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_has_epcs', function (Blueprint $table) {
			$table->unsignedBigInteger('epc_tbl_id')->index();
			$table->unsignedBigInteger('worker_tbl_id')->index();
			
			$table->foreign('epc_tbl_id')->references('epc_tbl_id')->on('electronic_product_codes');
			$table->foreign('worker_tbl_id')->references('worker_tbl_id')->on('workers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_has_epcs');
    }
}
