<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_activation_key');
            $table->double('tax');
            $table->double('service');
            $table->double('room_charge');
            $table->time('booking_warning_time');
            $table->time('booking_waiting_time');
            $table->time('booking_service_time');
            $table->string('restaurant_name');
            $table->string('logo');
            $table->string('mobile_logo');
            $table->text('mobile_image');
            $table->string('email');
            $table->string('website');
            $table->string('phone');
            $table->string('address');
            $table->string('message');
            $table->string('remark');
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
        Schema::drop('config_log');
    }
}
