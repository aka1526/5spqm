<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_auditor', function (Blueprint $table) {
          $table->string('unid',50)->primary();
          $table->string('audit_position_unid',50)->nullable()->default('');
          $table->string('audit_position',200)->nullable()->default('');
          $table->string('auditor_group',200)->nullable()->default('');
          $table->integer('auditor_item')->nullable()->default(0);
          $table->string('auditor_name',200)->nullable()->default('');
          $table->string('auditor_area',50)->nullable()->default('');
          $table->string('area_name',200)->nullable()->default('');

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
        Schema::dropIfExists('tbl_auditor');
    }
}
