<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_day', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('status'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });

        Schema::table('order_details', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('cancel_status'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });

        Schema::table('order_extra', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('status'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });

        Schema::table('order_room', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('room_id'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });
        Schema::table('order_setmenu_detail', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('remark'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });
        Schema::table('order_shift', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('status'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });
        Schema::table('order_tables', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('table_id'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });
        Schema::table('order', function (Blueprint $table) {
             $table->integer('restaurant_id ')->nullable()->after('shift_id'); 
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
        Schema::table('order_day', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
         Schema::table('order_details', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
          Schema::table('order_extra', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
           Schema::table('order_room', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
          Schema::table('order_setmenu_detail', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
        Schema::table('order_shift', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
        Schema::table('order_tables', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
        Schema::table('order', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
    }
}
