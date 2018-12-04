<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('remark', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('remark_code');
            $table->text('description')->nullable();
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::drop('remark');
    }
}
