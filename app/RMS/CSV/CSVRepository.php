<?php
/**
 * Created by PhpStorm.
 * User: UNiQUE
 * Date: 3/24/2016
 * Time: 2:30 PM
 */

namespace App\RMS\CSV;

use App\RMS\Utility;

use Illuminate\Support\Facades\Input;
use League\Flysystem\Util;
use App\RMS\ReturnMessage;
use App\RMS\CSV\CSVRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CSVRepository implements CSVRepositoryInterface
{
	public function create_add_on($data,$restaurant_id,$branch_id) {		
        $returnedObj 				      = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        

        try {
            $food_name          = $data[0];
            $category_id        = $data[1];
            $description        = $data[2];
            $image            	= $data[3];          
            $price             	= $data[4];
            $status 			= 1;           
            $stoke 				= $data[5];
            $restaurant 		= $restaurant_id;
            $branch 			= $branch_id;

            $insert_val         = "'" . $food_name .
                                  "','" . $category_id .
                                  "','" . $description . 
                                  "','" . $image .
                                  "','" . $price .
                                  "','" . $status .                                   
                                  "','" . $currentUser . 
                                  "','" . $currentUser . 
                                  "','" . $today .
                                  "','" . $today .
                                  "','" . $stoke. 
                                  "','" . $restaurant.
                                  "','" . $branch ."'";
                                   // "','".$stoke. "'";
                                  // dd($insert_val);
            $expAry            = explode(',',$insert_val);
            
            DB::insert("INSERT INTO add_on (food_name,category_id,description,image,price,status,created_by,updated_by,created_at,updated_at,stock_code,restaurant_id,branch_id) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            dd($e);
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a import csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
    public function create_category($data,$restaurant_id,$branch_id) {		
        $returnedObj 				      = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        

        try {
            $name         	  = $data[0];
            $parent_id        = $data[1];
            $kitchen_id       = $data[2];
            $image            = $data[3];          
            $status           = 1;           
            $stock_code 	  = $data[4];       
            $group_id 		  = $data[5];
           	$level 			  = $data[6];
            $insert_val         = "'" . $name .
                                  "','" . $parent_id .
                                  "','" . $kitchen_id . 
                                  "','" . $image .
                                  "','" . $status .
                                  
                                  "','" . $currentUser .
                                  "','" . $currentUser .
                                  "','" . $today .
                                  "','" . $today .
                                  "','" . $stock_code .                                   
                                  "','" . $restaurant_id . 
                                  "','" . $branch_id . 
                                  "','" . $group_id .
                                  "','" . $level ."'";
                                   // "','".$stoke. "'";
                                  // dd($insert_val);
            $expAry            = explode(',',$insert_val);
            
            DB::insert("INSERT INTO category (name,parent_id,kitchen_id,image,status,created_by,updated_by,created_at,updated_at,stock_code,restaurant_id,branch_id,group_id,level) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            dd($e);
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a import csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

       public function create_item($data,$restaurant_id,$branch_id) {		
        $returnedObj 				      = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        

        try {
            $name         		= $data[0];
            $image        		= $data[1];
            $price       		= $data[2];             
            $category_id        = $data[3];          
            $standard_cooking_time= $data[4];       
            $stock_code 		  = $data[5];
           	$continent_id 		  = $data[6];
           	$group_id 			  = $data[7];
           	$isdefault 			  = $data[8];
           	$has_continent 		  = $data[9];
           	$status            	  = 1;        



            $insert_val         = "'" . $name .
                                  "','" . $image .                                 
                                  "','" . $price .
                                  "','" . $status .
                                  "','" . $category_id . 
                                  "','" . $standard_cooking_time .                                  
                                  "','" . $currentUser .
                                  "','" . $currentUser .
                                  "','" . $today .
                                  "','" . $today .
                                  "','" . $stock_code .                                   
                                  "','" . $restaurant_id . 
                                  "','" . $branch_id . 
                                  "','" . $continent_id .
                                  "','" . $group_id .
                                  "','" . $isdefault .
                                  "','" . $has_continent ."'";
                                   // "','".$stoke. "'";
                                  // dd($insert_val);
            $expAry            = explode(',',$insert_val);
            
            DB::insert("INSERT INTO items (name,image,price,status,category_id,standard_cooking_time,created_by,updated_by,created_at,updated_at,stock_code,restaurant_id,branch_id,continent_id,group_id,isdefault,has_continent) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            dd($e);
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a import csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function create_menu($data,$restaurant_id,$branch_id) {		
        $returnedObj 				      = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        

        try {
            $name         		= $data[0];
            $price       		= $data[1];    
            $image        		= $data[2];                
           
            $stock_code 		= $data[3];
           
           	$status            	= 1;        



            $insert_val         = "'" . $name .
            					  "','" . $price .
            					  "','" . $image . 
                                  "','" . $status .
                                                                  
                                  "','" . $currentUser .
                                  "','" . $currentUser .
                                  "','" . $today .
                                  "','" . $today .
                                  "','" . $stock_code .                                   
                                  "','" . $restaurant_id . 
                                  "','" . $branch_id ."'";
                                   // "','".$stoke. "'";
                                  // dd($insert_val);
            $expAry            = explode(',',$insert_val);
            
            DB::insert("INSERT INTO set_menu (set_menus_name,set_menus_price,image,status,created_by,updated_by,created_at,updated_at,stock_code,restaurant_id,branch_id) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            dd($e);
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a import csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
   
   
   

}