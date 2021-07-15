<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tbl_questions_area', function (Blueprint $table) {
        $table->string('unid',50)->primary();
        $table->string('ques_unid')->nullable()->default('');
        $table->integer('area_index')->nullable()->default(0);
        $table->string('area_unid')->nullable()->default('');
        $table->string('area_name')->nullable()->default('');
        $table->string('create_by',200)->nullable()->default('');
        $table->string('create_time',50)->nullable()->default('');
        $table->string('edit_by',200)->nullable()->default('');
        $table->string('edit_time',50)->nullable()->default('');
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
        Schema::dropIfExists('tbl_questions_area');
    }
}
