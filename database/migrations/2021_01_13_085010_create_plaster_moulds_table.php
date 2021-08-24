<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlasterMouldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plaster_moulds', function (Blueprint $table) {
			$table->bigIncrements('plaster_mould_tbl_id');
			$table->datetime('created_at');
			$table->unsignedBigInteger('epc_tbl_id')->index();
			$table->unsignedBigInteger('mould_mdl_tbl_id')->index();
			
			$table->foreign('epc_tbl_id')->references('epc_tbl_id')->on('electronic_product_codes');
			$table->foreign('mould_mdl_tbl_id')->references('mould_mdl_tbl_id')->on('mould_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plaster_moulds');
    }
}
