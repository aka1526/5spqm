<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditpositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_auditposition', function (Blueprint $table) {
          $table->string('unid',50)->primary();
          $table->integer('position_no')->nullable()->default(0);
          $table->string('position_name',200)->nullable()->default('');
          $table->string('position_name_eng',200)->nullable()->default('');
          $table->string('auditor_period',50)->nullable()->default('');
          $table->integer('period_qty')->nullable()->default(0);
          $table->string('period_type',50)->nullable()->default('');
          $table->string('create_by',50)->nullable();
          $table->string('create_time',50)->nullable();
          $table->string('edit_by',50)->nullable();
          $table->string('edit_time',50)->nullable();
          $table->string('status',50)->nullable()->default('Y');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_auditposition');
    }
}
