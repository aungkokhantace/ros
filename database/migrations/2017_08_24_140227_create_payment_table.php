<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('paid_amount', 8, 2);
            $table->decimal('change_amount', 8, 2);
            $table->decimal('rounding_amount', 8, 2)->nullable();
            $table->string('order_id',200);
            $table->tinyInteger('payment_type');
            $table->integer('payment_card_id');
            $table->string('uuid',50);
            $table->tinyInteger('status');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('card');
    }
}
