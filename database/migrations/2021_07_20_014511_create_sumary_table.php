<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSumaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_result_summary', function (Blueprint $table) {
          $table->string('unid',50)->primary();
          $table->string('plan_unid')->nullable()->default('');
          $table->date('plan_date')->nullable();
          $table->integer('plan_month')->nullable()->default(0);
          $table->integer('plan_year')->nullable()->default(0);
          $table->string('doc_status',50)->nullable()->default('');
          $table->string('questions_unid',50)->nullable()->default('');
          $table->string('questions_rev',50)->nullable()->default('00');
          $table->string('questions_header',200)->nullable()->default('');
          $table->integer('total_item')->nullable()->default(0);
          $table->integer('total_score')->nullable()->default(0);
          $table->integer('area_score')->nullable()->default(0);
          $table->string('area_unid',50)->nullable()->default('');
          $table->string('area_name',200)->nullable()->default('');
          $table->string('area_owner',200)->nullable()->default('');
          $table->string('auditor_unid',50)->nullable()->default('');
          $table->string('auditor_name',200)->nullable()->default('');
          $table->string('auditor_position',50)->nullable()->default('');
          $table->string('position_name',200)->nullable()->default('');
          $table->string('create_by',200)->nullable()->default('');
          $table->string('create_time',50)->nullable()->default('');
          $table->string('edit_by',200)->nullable()->default('');
          $table->string('edit_time',50)->nullable()->default('');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_result_summary');
    }
}
