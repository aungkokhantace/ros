<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderSetmenuDetailTable extends Migration
{
   
    public function up()
    {
         Schema::create('order_setmenu_detail', function (Blueprint $table) {
            $table->string('order_detail_id');
            $table->integer('setmenu_id');
            $table->integer('item_id');
            $table->integer('order_type_id');
            $table->integer('quantity');
            $table->string('exception')->nullable();
            $table->dateTime('order_time');
            $table->datetime('order_duration')->nullable();
            $table->datetime('cooking_time')->nullable();
            $table->datetime('waiter_duration')->nullable();
            $table->integer('waiter_id');
            $table->string('waiter_status',50)->nullable();
            $table->integer('status_id');
            $table->string('cancel_status',50)->nullable();
            $table->string('message');
            $table->string('remark');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

   
    public function down()
    {
       Schema::drop('order_setmenu_detail');
    }
}
