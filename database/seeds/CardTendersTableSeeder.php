<?php

use Illuminate\Database\Seeder;

class CardTendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('card_tenders')->delete();
        
        DB::table('card_tenders')->insert([
            'id' =>'1',
            'code' => 'CASH',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('card_tenders')->insert([
            'id' =>'2',
            'code' => 'MPU',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('card_tenders')->insert([
            'id' =>'3',
            'code' => 'VISA',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('card_tenders')->insert([
            'id' =>'4',
            'code' => 'CREDIT',
            'status' => '1',
            'created_by' => '1',
        ]);
    }
}
