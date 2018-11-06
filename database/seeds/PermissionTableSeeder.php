<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('permissions')->delete();

        //For Super Admin Permission
        DB::table('permissions')->insert([
            'id' =>'1',
            'role_id' => '1',
            'module_id' => '1',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'2',
            'role_id' => '1',
            'module_id' => '2',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'3',
            'role_id' => '1',
            'module_id' => '3',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '4',
            'role_id' => '1',
            'module_id' => '4',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '5',
            'role_id' => '1',
            'module_id' => '5',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '6',
            'role_id' => '1',
            'module_id' => '6',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '7',
            'role_id' => '1',
            'module_id' => '7',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '8',
            'role_id' => '1',
            'module_id' => '8',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '9',
            'role_id' => '1',
            'module_id' => '9',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '10',
            'role_id' => '1',
            'module_id' => '10',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '11',
            'role_id' => '1',
            'module_id' => '11',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '12',
            'role_id' => '1',
            'module_id' => '12',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '13',
            'role_id' =>'1',
            'module_id' => '13',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '14',
            'role_id' =>'1',
            'module_id' => '14',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '15',
            'role_id' =>'1',
            'module_id' => '15',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '16',
            'role_id' =>'1',
            'module_id' => '16',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '17',
            'role_id' =>'1',
            'module_id' => '17',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'18',
            'role_id' =>'1',
            'module_id' => '18',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '19',
            'role_id' =>'1',
            'module_id' => '19',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'20',
            'role_id' =>'1',
            'module_id' => '20',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'21',
            'role_id' =>'1',
            'module_id'=>'21',
            'created_by'=>'1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'22',
            'role_id'=>'1',
            'module_id'=>'22',
            'created_by'=>'1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'23',
            'role_id'=>'1',
            'module_id'=>'23',
            'created_by'=>'1',
        ]);

        DB::table('permissions')->insert([
            'id'=>'24',
            'role_id'=>'1',
            'module_id'=>'24',
            'created_by'=>'1',
        ]);
        /*End Super Admin */

        //For Manager Permission
        DB::table('permissions')->insert([
            'id' =>'25',
            'role_id' => '2',
            'module_id' => '1',
            'created_by' => '',
        ]);
        DB::table('permissions')->insert([
            'id'=>'26',
            'role_id' => '2',
            'module_id' => '2',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'27',
            'role_id' => '2',
            'module_id' => '3',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '28',
            'role_id' => '2',
            'module_id' => '4',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '29',
            'role_id' => '2',
            'module_id' => '5',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '30',
            'role_id' => '2',
            'module_id' => '6',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '31',
            'role_id' => '2',
            'module_id' => '7',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '32',
            'role_id' => '2',
            'module_id' => '8',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '33',
            'role_id' => '2',
            'module_id' => '9',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '34',
            'role_id' => '2',
            'module_id' => '10',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '35',
            'role_id' => '2',
            'module_id' => '11',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '36',
            'role_id' => '2',
            'module_id' => '12',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '37',
            'role_id' =>'2',
            'module_id' => '13',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '38',
            'role_id' =>'2',
            'module_id' => '14',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '39',
            'role_id' =>'2',
            'module_id' => '15',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '40',
            'role_id' =>'2',
            'module_id' => '16',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '41',
            'role_id' =>'2',
            'module_id' => '17',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'42',
            'role_id' =>'2',
            'module_id' => '18',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '43',
            'role_id' =>'2',
            'module_id' => '19',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'44',
            'role_id' =>'2',
            'module_id' => '20',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'45',
            'role_id' =>'2',
            'module_id'=>'21',
            'created_by'=>'1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'46',
            'role_id'=>'2',
            'module_id'=>'22',
            'created_by'=>'1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'47',
            'role_id'=>'2',
            'module_id'=>'23',
            'created_by'=>'1',
        ]);

        DB::table('permissions')->insert([
            'id'=>'48',
            'role_id'=>'2',
            'module_id'=>'24',
            'created_by'=>'1',
        ]);
        /*End Manager Admin */


        //For Supervisor Permission
        DB::table('permissions')->insert([
            'id' =>'49',
            'role_id' => '3',
            'module_id' => '1',
            'created_by' => '',
        ]);
        DB::table('permissions')->insert([
            'id'=>'50',
            'role_id' => '3',
            'module_id' => '2',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'51',
            'role_id' => '2',
            'module_id' => '3',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '52',
            'role_id' => '2',
            'module_id' => '4',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '53',
            'role_id' => '2',
            'module_id' => '5',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '54',
            'role_id' => '2',
            'module_id' => '6',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '55',
            'role_id' => '2',
            'module_id' => '7',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '56',
            'role_id' => '2',
            'module_id' => '8',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '57',
            'role_id' => '2',
            'module_id' => '9',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '58',
            'role_id' => '2',
            'module_id' => '10',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '59',
            'role_id' => '2',
            'module_id' => '11',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '60',
            'role_id' => '2',
            'module_id' => '12',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '61',
            'role_id' =>'3',
            'module_id' => '13',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '62',
            'role_id' =>'3',
            'module_id' => '14',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '63',
            'role_id' =>'3',
            'module_id' => '15',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '64',
            'role_id' =>'3',
            'module_id' => '16',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '65',
            'role_id' =>'3',
            'module_id' => '17',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'66',
            'role_id' =>'3',
            'module_id' => '18',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' => '67',
            'role_id' =>'3',
            'module_id' => '19',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'68',
            'role_id' =>'3',
            'module_id' => '20',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'69',
            'role_id' =>'3',
            'module_id'=>'21',
            'created_by'=>'1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'70',
            'role_id'=>'2',
            'module_id'=>'22',
            'created_by'=>'1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'71',
            'role_id'=>'2',
            'module_id'=>'23',
            'created_by'=>'1',
        ]);

        DB::table('permissions')->insert([
            'id'=>'72',
            'role_id'=>'2',
            'module_id'=>'24',
            'created_by'=>'1',
        ]);
        /*End Manager Admin */


        //For Cashier Permission

        DB::table('permissions')->insert([
            'id'=>'73',
            'role_id'=>'4',
            'module_id'=>'1',
            'created_by'=>'1',
        ]);
        DB::table('permissions')->insert([
            'id'=>'74',
            'role_id' =>'4',
            'module_id' => '4',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'75',
            'role_id' => '4',
            'module_id' => '5',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'76',
            'role_id' => '4',
            'module_id' => '8',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'77',
            'role_id' => '4',
            'module_id' => '14',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'78',
            'role_id' => '4',
            'module_id' => '15',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'79',
            'role_id' => '4',
            'module_id' => '17',
            'created_by' => '1',
        ]);
        DB::table('permissions')->insert([
            'id' =>'80',
            'role_id' => '4',
            'module_id' => '24',
            'created_by' => '1',
        ]);
        /*End Cashier Admin */

        /*For Kitchen */
        DB::table('permissions')->insert([
            'id' =>'81',
            'role_id' => '6',
            'module_id' => '18',
            'created_by' => '1',
        ]);
        /*End Kitchen */

        /*For Make Order Module */
        DB::table('permissions')->insert([
            'id' =>'82',
            'role_id' => '1',
            'module_id' => '25',
            'created_by' => '1',
        ]);

        DB::table('permissions')->insert([
            'id' =>'83',
            'role_id' => '2',
            'module_id' => '25',
            'created_by' => '1',
        ]);

        DB::table('permissions')->insert([
            'id' =>'84',
            'role_id' => '3',
            'module_id' => '25',
            'created_by' => '1',
        ]);

        DB::table('permissions')->insert([
            'id' =>'85',
            'role_id' => '4',
            'module_id' => '25',
            'created_by' => '1',
        ]);
        //csv
        DB::table('permissions')->insert([
            'id' =>'86',
            'role_id' => '1',
            'module_id' => '26',
            'created_by' => '1',
        ]);
    }
}
