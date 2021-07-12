<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_auditarea', function (Blueprint $table) {
          $table->string('unid',50)->primary();
          $table->string('position_name_eng',200)->nullable()->default('');
          $table->string('auditor_unid',50)->nullable()->default('');
          $table->string('auditor_name',50)->nullable()->default('');
          $table->string('area_unid',50)->nullable();
          $table->integer('area_index')->nullable();
          $table->string('area_name',200)->nullable();
          $table->string('area_owner',200)->nullable();
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
        Schema::dropIfExists('tbl_auditarea');
    }
}
