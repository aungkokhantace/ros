<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_settings', function(Blueprint $table) {
            $table->string('code');
            $table->string('type');
            $table->string('value');
            $table->text('description');

            //Common to all table ----------------------------------------------
            $table->string('created_by',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('deleted_by',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(array('code','type'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('core_settings');
    }
}
