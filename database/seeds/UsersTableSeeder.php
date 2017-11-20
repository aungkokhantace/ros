<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            'user_name' => 'admin',//Super Admin
            'staff_id'  => '1',
            'password'  => bcrypt('admin123'),
            'role_id'   => '1',
            'kitchen_id'=> '',
            'status' => '1'
        ]);

        DB::table('users')->insert([
            'user_name' => 'manager',//Manager
            'staff_id'  => '2',
            'password'  => bcrypt('admin123'),
            'role_id'   => '2',
            'kitchen_id'=> '',
            'status' => '1'
        ]);

        DB::table('users')->insert([
            'user_name' => 'cashier',//Cashier
            'staff_id'  => '3',
            'password'  => bcrypt('admin123'),
            'role_id'   => '4',
            'kitchen_id'=> '',
            'status' => '1'
        ]);

        DB::table('users')->insert([
            'user_name' => 'kitchen',//Cashier
            'staff_id'  => '4',
            'password'  => bcrypt('admin123'),
            'role_id'   => '6',
            'kitchen_id'=> '1',
            'status' => '1'
        ]);
    }
}
