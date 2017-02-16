<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddOnTables extends Migration
{

    public function up()
    {
        Schema::create('add_on', function (Blueprint $table) {
            $table->increments('id');
            $table->string('food_name');
            $table->integer('category_id');
            $table->string('description');
            $table->string('image');
            $table->text('mobile_image');
            $table->integer('price');
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
        Schema::drop('add_on');
    }
}
