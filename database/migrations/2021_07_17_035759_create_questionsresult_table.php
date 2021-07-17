<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsresultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_questions_result', function (Blueprint $table) {

          $table->string('unid',50)->primary();

          $table->string('ques_unid',50)->nullable()->default();
          $table->string('ques_rev',50)->nullable()->default('00');
          $table->string('ques_header',200)->nullable()->default('');

          $table->string('positions_type',50)->nullable()->default('');
          $table->string('position_name',200)->nullable()->default('');

          $table->string('area_unid',50)->nullable()->default('');
          $table->string('area_name',200)->nullable()->default('');
          $table->string('area_owner',200)->nullable()->default('');

          $table->integer('result_index')->nullable()->default(0);
          $table->string('result_toppic',200)->nullable()->default('');
          $table->string('result_desc',200)->nullable()->default('');
          $table->integer('result_val')->nullable()->default(0);

          $table->string('auditor_unid',50)->nullable()->default('');
          $table->string('auditor_name',200)->nullable()->default('');

          $table->string('status',50)->nullable()->default('Y');
          $table->string('result_type',50)->nullable()->default('VALUE');
          
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
        Schema::dropIfExists('tbl_questions_result');
    }
}
