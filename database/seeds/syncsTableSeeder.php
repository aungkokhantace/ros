<?php

use Illuminate\Database\Seeder;

class syncsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('syncs_tables')->insert([
            'table_name' => 'category',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'items',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'add_on',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'member_type',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'members',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'favourites',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'set_menu',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'set_item',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'rooms',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'tables',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'booking',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'config',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'promotions',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'kitchen',
            'version' => '1',
            'active' => '1',
            'created_by' => '1',
            'updated_by' =>'1',
            'deleted_by' =>''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'promotion_items',
            'version' => '1',
            'active' => '1',
            'created_by' => '1',
            'updated_by' =>'1',
            'deleted_by' =>''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'discount',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'locations',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'discount_log',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'config_log',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'shift_category',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'shift_user',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'table_name' => 'shift_setmenu',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
    }
}
