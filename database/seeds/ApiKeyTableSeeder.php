<?php

use Illuminate\Database\Seeder;

class ApiKeyTableSeeder extends Seeder
{
   
    public function run()
    {
        $existingPermissions = DB::select('SELECT id FROM api_keys');

        $permissions = array(

            ['id' => '1','key' => '330e8bf40c1091b036ae336393a12188','level'  => '10','ignore_limits'  =>'1'],
        );


        if(isset($existingPermissions) && count($existingPermissions)>0){

            $newPermissions = array();

            foreach ($permissions as $defaultPermission) {

                $existFlag = 0;
                foreach($existingPermissions as $existPermission) {

                    if($defaultPermission['id'] == $existPermission->id) {
                        $existFlag++;
                        break;
                    }
                }
                if($existFlag == 0) {
                    array_push($newPermissions, $defaultPermission);
                }

            }

            if(count($newPermissions)>0){
                DB::table('api_keys')->insert($newPermissions);
            }
        }
        else{
            DB::table('api_keys')->insert($permissions);
        }

        echo "\n";
        echo "*****************************************************";
        echo "\n";
        echo "** Finished Running Default Core Permission Seeder **";
        echo "\n";
        echo "*****************************************************";
        echo "\n";
    }
}
