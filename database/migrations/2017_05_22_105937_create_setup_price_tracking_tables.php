<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetupPriceTrackingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setup_price_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_name')->nullable();
            $table->string('table_id')->nullable();
            $table->string('table_id_type')->nullable();
            $table->string('action')->nullable();
            $table->decimal('old_price',10,2)->nullable();
            $table->decimal('new_price',10,2)->nullable();

            //Common to all table ----------------------------------------------
            $table->string('created_by',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('deleted_by',100)->nullable();
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
        Schema::drop('setup_price_tracking');
    }
}
