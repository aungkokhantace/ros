<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTypeTables extends Migration
{

    public function up()
    {
        Schema::create('order_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::drop('order_type');
    }
}
