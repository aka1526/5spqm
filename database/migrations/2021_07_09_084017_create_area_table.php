<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_area', function (Blueprint $table) {
        $table->string('unid',50)->primary();
        $table->integer('area_index')->nullable();
        $table->string('area_name',200)->nullable();
        $table->string('area_owner',200)->nullable();
        $table->string('create_by',50)->nullable();
        $table->string('create_time',50)->nullable();
        $table->string('edit_by',50)->nullable();
        $table->string('edit_time',50)->nullable();
        $table->string('status',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_area');
    }
}
