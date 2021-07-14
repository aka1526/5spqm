<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanpositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_planposition', function (Blueprint $table) {
          $table->string('unid',50)->primary();
          $table->integer('plan_year')->nullable();
          $table->integer('plan_month')->nullable();
          $table->date('plan_date')->nullable();
          $table->string('plan_area_unid',50)->nullable()->default('');
          $table->integer('plan_area_index')->nullable()->default(0);
          $table->string('plan_area_name',200)->nullable()->default('');
          $table->string('plan_area_owner',200)->nullable()->default('');
          $table->string('position_type',50)->nullable()->default('');
          $table->string('plan_groups',50)->nullable()->default('');
          $table->string('plan_status')->nullable()->default('Y');

          $table->string('create_by',200)->nullable();
          $table->string('create_time',50)->nullable();
          $table->string('edit_by',200)->nullable();
          $table->string('edit_time',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_planposition');
    }
}
