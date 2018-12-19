<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTypeTables extends Migration
{

    public function up()
    {
        Schema::create('member_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->text('description');
            $table->double('discount_amount');
            $table->integer('life_time');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('member_type');
    }
}
