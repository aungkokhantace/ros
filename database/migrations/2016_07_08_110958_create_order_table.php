<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{

    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->string('id');
            $table->integer('user_id');
            $table->integer('take_id')->nullable();
            $table->dateTime('order_time');
            $table->integer('member_id');
            $table->double('total_extra_price');
            $table->double('total_discount_amount');
            $table->double('total_price');
            $table->double('member_discount');
            $table->double('member_discount_amount');
            $table->double('service_amount');
            $table->double('tax_amount');
            $table->double('foc_amount')->nullable();
            $table->text('foc_description')->nullable();
            $table->double('total_price_foc');
            $table->double('all_total_amount');
            $table->double('payment_amount');   
            $table->double('refund');
            $table->integer('status')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('order');
    }
}
