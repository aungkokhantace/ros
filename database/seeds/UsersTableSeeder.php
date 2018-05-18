<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert([
            'id'         => '1',
            'user_name' => 'admin',//Super Admin
            'staff_id'  => '1',
            'password'  => bcrypt('admin123'),
            'role_id'   => '1',
            'status' => '1'
        ]);

        DB::table('users')->insert([
            'id'         => '2',
            'user_name' => 'manager',//Manager
            'staff_id'  => '2',
            'password'  => bcrypt('admin123'),
            'role_id'   => '2',
            'status' => '1'
        ]);

        DB::table('users')->insert([
            'id'         => '3',
            'user_name' => 'cashier',//Cashier
            'staff_id'  => '3',
            'password'  => bcrypt('admin123'),
            'role_id'   => '4',
            'status' => '1'
        ]);
    }
}
