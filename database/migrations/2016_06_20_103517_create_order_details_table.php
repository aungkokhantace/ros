<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{

    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_detail_id');
            $table->string('order_id');
            $table->integer('item_id')->nullable();
            $table->integer('order_type_id');
            $table->integer('setmenu_id')->nullable();
            $table->boolean('take_item');
            $table->integer('quantity');
            $table->string('exception')->nullable();
            $table->string('discount_amount')->nullable();
            $table->integer('promotion_id')->nullable();
            $table->double('amount');
            $table->double('amount_with_discount');
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
        Schema::drop('order_details');
    }
}
>>>>>>> v1.0.3
