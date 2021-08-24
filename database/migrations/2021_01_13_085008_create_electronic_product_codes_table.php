<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectronicProductCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electronic_product_codes', function (Blueprint $table) {
			$table->bigIncrements('epc_tbl_id');
			$table->string('epc')->unique();
			$table->string('tid');
			$table->date('created_at');
			$table->date('last_used');
			$table->unsignedBigInteger('pms_tbl_id')->index();
			
			$table->foreign('pms_tbl_id')->references('pms_tbl_id')->on('plaster_moulding_stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('electronic_product_codes');
    }
}
