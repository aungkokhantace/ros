<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchInSetItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('set_item', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('item_id'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('set_item', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
    }
}
