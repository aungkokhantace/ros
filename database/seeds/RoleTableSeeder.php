<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{

    public function run()
    {

        DB::table('roles')->insert([
            'id'          => '1',
            'name'        => 'Super Admin',
            'description' => 'Super Admin',
            'created_by'  => '1'
        ]);
        DB::table('roles')->insert([
            'id'          => '2',
            'name'        => 'Cashier',
            'description' => 'Cashier',
            'created_by'  => '1'
        ]);
        DB::table('roles')->insert([
            'id'          => '3',
            'name'        => 'Waiter',
            'description' => 'Waiter',
            'created_by'  => '1'
        ]);
        DB::table('roles')->insert([
            'id'          => '4',
            'name'        => 'Kitchen',
            'description' => 'Kitchen',
            'created_by'  => '1'
        ]);
    }
}
