<?php

use Illuminate\Database\Seeder;

class moduleTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('modules')->delete();
        
        DB::table('modules')->insert([
            'id' =>'1',
            'module' => 'Dashboard',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id'=>'2',
            'module' => 'Staff',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' =>'3',
            'module' => 'Staff Type',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '4',
            'module' => 'Category',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '5',
            'module' => 'Item',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '6',
            'module' => 'Add On',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '7',
            'module' => 'Discount',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '8',
            'module' => 'Set Menu',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '9',
            'module' => 'Member Type',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '10',
            'module' => 'Member',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '11',
            'module' => 'Table',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '12',
            'module' => 'Room',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '13',
            'module' =>'Booking',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '14',
            'module' =>'General Setting',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '15',
            'module' =>'Report',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '16',
            'module' =>'Promotions',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => '17',
            'module' =>'Order List',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id'=>'18',
            'module' =>'Kitchen',
            'view' => 'cashier',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id'=>'19',
            'module'=>'Profile',
            'view' => 'cashier',
            'created_by'=>'1',
        ]);
        DB::table('modules')->insert([
            'id' => '20',
            'module' =>'Table View',
            'view' => 'kitchen',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id' =>'21',
            'module' =>'Product View',
            'view' => 'kitchen',
            'created_by' => '1',
        ]);
        DB::table('modules')->insert([
            'id'=>'22',
            'module'=>'Kitchen Profile',
            'view'=>'kitchen',
            'created_by'=>'1',
        ]);
        DB::table('modules')->insert([
            'id'=>'23',
            'module'=>'Log',
            'view'=>'cashier',
            'created_by'=>'1',
        ]);
        DB::table('modules')->insert([
            'id'=>'24',
            'module'=>'Shift',
            'view'=>'cashier',
            'created_by'=>'1',
        ]);

        DB::table('modules')->insert([
            'id'=>'25',
            'module'=>'Order',
            'view'=>'cashier',
            'created_by'=>'1',
        ]);

        DB::table('modules')->insert([
            'id'=>'26',
            'module'=>'Remark',
            'view'=>'cashier',
            'created_by'=>'1',
        ]);

        DB::table('modules')->insert([
            'id'=>'27',
            'module'=>'Best Selling Item Report',
            'view'=>'cashier',
            'created_by'=>'1',
        ]);

         DB::table('modules')->insert([
            'id'=>'28',
            'module'=>'Best Selling Category Report',
            'view'=>'cashier',
            'created_by'=>'1',
        ]);

        DB::table('modules')->insert([
            'id'=>'29',
            'module'=>'Best Selling Set Menu Report',
            'view'=>'cashier',
            'created_by'=>'1',
        ]);

         DB::table('modules')->insert([
            'id'=>'30',
            'module'=>'Table  Report',
            'view'=>'cashier',
            'created_by'=>'1',
        ]);
    }
}
