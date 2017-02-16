<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetMenusTables extends Migration
{

    public function up()
    {
        Schema::create('set_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('set_menus_name');
            $table->string('set_menus_price');
            $table->string('image');
            $table->text('mobile_image');
            $table->integer ('status');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('set_menu');
    }
}
