<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formers', function (Blueprint $table) {
            $table->bigIncrements('former_tbl_id');
			$table->float('former_weight', 7, 2);
			$table->datetime('created_at');
			$table->unsignedBigInteger('epc_tbl_id')->index();
			$table->unsignedBigInteger('qc_code_tbl_id')->index();
			$table->unsignedBigInteger('cs_tbl_id')->index();
			$table->unsignedBigInteger('beacon_tbl_id')->index();
			
			$table->foreign('epc_tbl_id')->references('epc_tbl_id')->on('electronic_product_codes');
			$table->foreign('qc_code_tbl_id')->references('qc_code_tbl_id')->on('quality_check_codes');
			$table->foreign('cs_tbl_id')->references('cs_tbl_id')->on('casting_stations');
			$table->foreign('beacon_tbl_id')->references('beacon_tbl_id')->on('beacons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formers');
    }
}
