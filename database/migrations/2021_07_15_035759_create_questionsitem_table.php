<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_questionsitem', function (Blueprint $table) {
          $table->string('unid',50)->primary();
          $table->string('item_refunid',50)->nullable()->default('');
          $table->integer('item_index')->nullable()->default(0);
          $table->string('item_toppic',200)->nullable()->default('');
          $table->string('item_desc',200)->nullable()->default('');
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
        Schema::dropIfExists('tbl_questionsitem');
    }
}
