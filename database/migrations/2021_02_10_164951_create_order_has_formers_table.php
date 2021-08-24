<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHasFormersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_has_formers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_tbl_id')->index();
            $table->unsignedBigInteger('former_tbl_id')->index();
			
			$table->foreign('order_tbl_id')->references('order_tbl_id')->on('orders');
			$table->foreign('former_tbl_id')->references('former_tbl_id')->on('formers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_has_formers');
    }
}
