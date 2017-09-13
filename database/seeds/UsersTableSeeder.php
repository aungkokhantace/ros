<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            'user_name' => 'admin',
            'staff_id'  => '1',
            'password'  => bcrypt('admin123'),
            'role_id'   => '1',
            'kitchen_id'=> '',
            'status' => '1'
    
        ]);
    }
}
