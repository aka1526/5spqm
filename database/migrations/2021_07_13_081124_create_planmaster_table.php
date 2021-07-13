<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanmasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_planmaster', function (Blueprint $table) {
          $table->string('unid',50)->primary();
          $table->string('area_unid',50)->nullable();
          $table->integer('area_index')->nullable();
          $table->string('area_name',200)->nullable();
          $table->string('area_owner',200)->nullable();
          $table->string('position_type',50)->nullable();
          $table->string('groups',50)->nullable();
          $table->date('datestart')->nullable();
          $table->date('dateend')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_planmaster');
    }
}
