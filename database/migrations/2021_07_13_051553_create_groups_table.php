<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_groups', function (Blueprint $table) {
          $table->string('unid',50)->nullable();
          $table->integer('group_index')->nullable()->default(1);
          $table->string('group_position',50)->nullable();  
          $table->string('group_name',50)->primary();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_groups');
    }
}
