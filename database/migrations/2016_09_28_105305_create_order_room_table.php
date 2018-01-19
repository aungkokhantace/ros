<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRoomTable extends Migration
{
    
    public function up()
    {
         Schema::create('order_room', function (Blueprint $table) {
            $table->integer('id')->increment();
            $table->string('order_id');
            $table->integer('room_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

   
    public function down()
    {
        Schema::drop('order_room');
    
    }
}
