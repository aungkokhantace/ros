<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTableTables extends Migration
{
    
    public function up()
    {
        Schema::create('booking_table', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->nullable();
            $table->integer('table_id')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
           
        });
    }

    
    public function down()
    {
        Schema::drop('booking_table');
    }
}
