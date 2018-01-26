<?php

use Illuminate\Database\Seeder;

class PosTendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pos_tenders')->insert([
            'id' =>'1',
            'code' => 'CASH',
            'name' => 'CASH',
            'description' => 'EXACT CASH',
            'card_type' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'2',
            'code' => 'CASH50',
            'name' => 'CASH50',
            'description' => 'CASH 50 mmk',
            'amount' => '50',
            'card_type' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'3',
            'code' => 'CASH100',
            'name' => 'CASH100',
            'description' => 'CASH 100 mmk',
            'amount' => '100',
            'card_type' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'4',
            'code' => 'CASH200',
            'name' => 'CASH200',
            'description' => 'CASH 200 mmk',
            'amount' => '200',
            'card_type' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'5',
            'code' => 'CASH500',
            'name' => 'CASH500',
            'description' => 'CASH 500 mmk',
            'amount' => '500',
            'card_type' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'6',
            'code' => 'CASH1000',
            'name' => 'CASH1000',
            'description' => 'CASH 1000 mmk',
            'amount' => '1000',
            'card_type' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'7',
            'code' => 'CASH5000',
            'name' => 'CASH5000',
            'description' => 'CASH 5000 mmk',
            'amount' => '5000',
            'card_type' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'8',
            'code' => 'CASH10000',
            'name' => 'CASH10000',
            'description' => 'CASH 10000 mmk',
            'amount' => '10000',
            'card_type' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'9',
            'code' => 'MPU_AGD',
            'name' => 'MPU_AGD',
            'description' => 'MPU (AGD)',
            'card_type' => '2',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'10',
            'code' => 'MPU_AYEYARWADY',
            'name' => 'MPU AYEYARWADY',
            'description' => 'MPU (AYEYARWADY)',
            'card_type' => '2',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'11',
            'code' => 'MPU_KBZ',
            'name' => 'MPU_KBZ',
            'description' => 'MPU (KBZ)',
            'card_type' => '2',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'12',
            'code' => 'MPU_UAB',
            'name' => 'MPU_UAB',
            'description' => 'MPU (UAB)',
            'card_type' => '2',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'13',
            'code' => 'MPU_CHD',
            'name' => 'MPU_CHD',
            'description' => 'MPU (CHD)',
            'card_type' => '2',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'14',
            'code' => 'MPU_MYANMAR_ECONOMIC',
            'name' => 'MPU_MYANMAR_ECONOMIC',
            'description' => 'MPU (MYANMAR ECONOMIC)',
            'card_type' => '2',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'15',
            'code' => 'MPU_MOB',
            'name' => 'MPU_MOB',
            'description' => 'MPU (MOB)',
            'card_type' => '2',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'16',
            'code' => 'VISA_KBZ',
            'name' => 'VISA_KBZ',
            'description' => 'VISA (KBZ)',
            'card_type' => '3',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'17',
            'code' => 'VISA_CB',
            'name' => 'VISA_CB',
            'description' => 'VISA (CB)',
            'card_type' => '3',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'18',
            'code' => 'VISA_MAB',
            'name' => 'VISA_MAB',
            'description' => 'VISA (MAB)',
            'card_type' => '3',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'19',
            'code' => 'CREDIT_CB',
            'name' => 'CREDIT_CB',
            'description' => 'CREDIT (CB)',
            'card_type' => '4',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'20',
            'code' => 'CREDIT_KBZ',
            'name' => 'CREDIT_KBZ',
            'description' => 'CREDIT (KBZ)',
            'card_type' => '4',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'21',
            'code' => 'CREDIT_UAB',
            'name' => 'CREDIT_UAB',
            'description' => 'CREDIT (UAB)',
            'card_type' => '4',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'22',
            'code' => 'CREDIT_AYEYARWADY',
            'name' => 'CREDIT_AYEYARWADY',
            'description' => 'CREDIT (AYEYARWADY)',
            'card_type' => '4',
            'status' => '1',
            'created_by' => '1',
        ]);

        DB::table('pos_tenders')->insert([
            'id' =>'23',
            'code' => 'CREDIT_MOB',
            'name' => 'CREDIT_MOB',
            'description' => 'CREDIT (MOB)',
            'card_type' => '4',
            'status' => '1',
            'created_by' => '1',
        ]);
    }
}
