<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerHasDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_has_department', function (Blueprint $table) {
            $table->unsignedBigInteger('worker_tbl_id')->index();
            $table->unsignedBigInteger('dprt_tbl_id')->index();
            
            $table->foreign('worker_tbl_id')->references('worker_tbl_id')->on('workers');
            $table->foreign('dprt_tbl_id')->references('dprt_tbl_id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_has_department');
    }
}
