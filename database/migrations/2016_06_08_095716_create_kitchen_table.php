<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenTable extends Migration
{

    public function up()
    {
        Schema::create('kitchen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('kitchen');
    }
}
