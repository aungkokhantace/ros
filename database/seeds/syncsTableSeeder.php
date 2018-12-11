<?php

use Illuminate\Database\Seeder;

class syncsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('syncs_tables')->delete();
        
        DB::table('syncs_tables')->insert([
            'id'         => '1',
            'table_name' => 'category',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '2',
            'table_name' => 'items',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '3',
            'table_name' => 'add_on',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '4',
            'table_name' => 'member_type',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '5',
            'table_name' => 'members',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '6',
            'table_name' => 'favourites',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '7',
            'table_name' => 'set_menu',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '8',
            'table_name' => 'set_item',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '9',
            'table_name' => 'rooms',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '10',
            'table_name' => 'tables',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '11',
            'table_name' => 'booking',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '12',
            'table_name' => 'config',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '13',
            'table_name' => 'promotions',
            'version'  => '1',
            'active'  => '1',
            'created_by'   => '1',
            'updated_by'=> '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '14',
            'table_name' => 'kitchen',
            'version' => '1',
            'active' => '1',
            'created_by' => '1',
            'updated_by' =>'1',
            'deleted_by' =>''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '15',
            'table_name' => 'promotion_items',
            'version' => '1',
            'active' => '1',
            'created_by' => '1',
            'updated_by' =>'1',
            'deleted_by' =>''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '16',
            'table_name' => 'discount',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '17',
            'table_name' => 'locations',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '18',
            'table_name' => 'discount_log',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '19',
            'table_name' => 'config_log',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '20',
            'table_name' => 'shift_category',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '21',
            'table_name' => 'shift_user',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '22',
            'table_name' => 'shift_setmenu',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);

        DB::table('syncs_tables')->insert([
            'id'         => '23',
            'table_name' => 'continent',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '24',
            'table_name' => 'locations',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '25',
            'table_name' => 'remark',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
        DB::table('syncs_tables')->insert([
            'id'         => '26',
            'table_name' => 'item_remark',
            'version'    => '1',
            'active'     => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'deleted_by' => ''
        ]);
    }
}
