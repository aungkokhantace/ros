<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\User;
use App\RMS\Role\Role;
use App\RMS\Category\Category;
use App\RMS\Addon\Addon;
use App\RMS\Item\Item;
use App\RMS\SetMenu\SetMenu;
use App\RMS\SetItem\SetItem;
use App\RMS\Config\Config;
use App\RMS\Table\Table;
use App\RMS\Room\Room;
use App\RMS\Discount\DiscountModel;
use App\RMS\Member\Member;
use App\RMS\Kitchen\Kitchen;
use App\RMS\Booking\Booking;
use App\RMS\Favourite\Favourite;
use App\RMS\SyncsTable\SyncsTable;
use App\RMS\Promotion\Promotion;
use App\RMS\PromotionItem\PromotionItem;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\BookingTable\BookingTable;
use App\RMS\BookingRoom\BookingRoom;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\RMS\User\UserRepository;
use App\RMS\Utility;

class syncAPIController extends ApiGuardController
{

    public function user()
    {

        $temp = Input::all();
        $key  = $temp['site_activation_key'];

        $site_activation_key = Config::all();

        $activate_key = 0;
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        if($key == $activate_key ){
            $user = DB::select("SELECT staff_id, user_name FROM users");
            $output = array("user" => $user);
            return Response::json($output);
        }
        else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);  
        }
        
    }

    public function category()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();

        $activate_key = 0;
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
       
        if($key == $activate_key){
            $category = DB::select("SELECT id,name,status,parent_id,kitchen_id,mobile_image FROM category WHERE status = '1' ");
        
            $output = array("category" => $category);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);  
        }
        
    }

    public function addon()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();

        $activate_key = 0;
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        
        if($key == $activate_key){
            $addon = DB::select("SELECT id,food_name,category_id,image,price,status,mobile_image FROM add_on WHERE status = '1'");
       
            $output = array("addon" => $addon);
            return Response::json($output);
        }else{
             $output = array("Message" => "Unauthorized");
            return Response::json($output);  
        }
        
    }

    public function item()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();

        $activate_key = 0;
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        if($key == $activate_key){
            $item = DB::select("SELECT id,name,image,price,status,category_id,mobile_image FROM items WHERE status = '1' ");
            $output = array("items" => $item);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);       
        }
    }
    
    public function set_menu()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        
        if($key == $activate_key){
            $set_menu = DB::select("SELECT id,set_menus_name,set_menus_price,image,status,mobile_image FROM set_menu");
            $output = array("set_menu" => $set_menu);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);  
        }
    }

    public function set_item()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        
        if($key == $activate_key){
            $set_item = DB::select("SELECT id,set_menu_id,item_id FROM set_item");
            $output = array("set_item" => $set_item);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);  
        }
    }
   
    public function config()
    {   
        
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
       
        if($key == $activate_key){
            $config = DB::select("SELECT tax,service,booking_warning_time,booking_waiting_time,booking_service_time,restaurant_name,logo,mobile_logo,email,website,phone,address,message,remark,mobile_image FROM config");
        
        $output = array("config" => $config);
        return Response::json($output);
        }else{
             $output = array("Message" => "Unauthorized");
            return Response::json($output);    
        }
        
    }

    public function table()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        
        if($key == $activate_key){
            $table = DB::select("SELECT id,table_no,status FROM tables");
            $output = array("table" => $table);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);   
        } 
    }

    public function room()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $room = DB::select("SELECT id,room_name,status FROM rooms");
            $output = array("room" => $room);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);   
        }
    }

    public function member()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $member = DB::select("SELECT id,member_type_id FROM members");
            $output = array("member" => $member);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output); 
        }
        
    }

    public function promotion()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $promotion = DB::select("SELECT * FROM promotions");
            $output = array("promotion" => $promotion);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output); 
        }
        
    }

    public function promotionItem()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $promotion_item = DB::select("SELECT * FROM promotion_items");
            $output = array("promotion_item" => $promotion_item);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output); 
        }
        
    }

    public function discount()
    {
        $temp                   =   Input::all();
        $key                    = $temp['site_activation_key'];
        $site_activation_key    = Config::all();
        $activate_key = 0;

        $today                  = Carbon::now();
        $cur_date               = Carbon::parse($today)->format('Y-m-d');

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $discount = DB::select("SELECT amount,type,item_id FROM discount WHERE $cur_date >= start_date AND $cur_date <= end_date");
            $output = array("discount" => $discount);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output); 
        }
        
    }

    public function booking()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $date  = Carbon::today();
                $today = $date->toDateString();
                $booking = DB::select("SELECT id,customer_name,from_time FROM booking WHERE booking_date = '$today' AND deleted_at is null ");
                //print_r($booking);exit();
                
                $table  = DB::select("SELECT booking_id,table_id FROM booking_table"); 
                $room   = DB::select("SELECT booking_id,room_id FROM booking_room");

                $returnObj = array();
                
                if(isset($booking)){
                    foreach($booking as $key => $obj){            
                    $booking_id = $obj->id;

                    $returnObj[] = $obj;             
                    foreach($table as $booking_table => $t){                
                        if($booking_id == $t->booking_id){
                           $returnObj[$key]->booking_table[] = $t;
                        }

                    }

                    $bookingRoomArray = array();
                    foreach($room as $booking_room => $r){                
                        if($booking_id == $r->booking_id){
                            array_push( $bookingRoomArray, $r);

                        }
                    }

                    $returnObj[$key]->booking_room = $bookingRoomArray;

                    if(!array_key_exists('booking_table', $returnObj[$key])){
                        $returnObj[$key]->booking_table = array();
                    }

                    if(!array_key_exists('booking_room', $returnObj[$key])){
                        $returnObj[$key]->booking_room = array();
                    }
                }

                //dd($returnObj);
                $output = array("booking" => $returnObj);
                return Response::json($output);
            }else{
                $outputarray = array();
                $output = array("booking" => $outputarray);
                return Response::json($output);
            }
        } else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output); 
        }
        
        
    }

    public function getSyncsTable()
    { 
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $syncs = SyncsTable::select('id', 'table_name', 'version')->get();
            $returnObj = array();
            foreach($syncs as $sync){
                if($sync->table_name == "category" || $sync->table_name == "items" || $sync->table_name == "set_menu" || $sync->table_name == "set_item" || $sync->table_name =="discount" || $sync->table_name == "members" || $sync->table_name == "add_on" || $sync->table_name == "rooms" || $sync->table_name == "tables" || $sync->table_name == "booking" || $sync->table_nam == "config" || $sync->table_name == "promotions" || $sync->table_name == "promotion_items" || $sync->table_name == "config"){

                    $returnObj[] = $sync;
                }
            }
            $output = array("syncs_table" => $returnObj);
            return Response::json($output);
        }else{
            //$output['syncs_table'] = array("Message" => "Unauthorized");
            $output['syncs_table'] = [];
            $output['Message'] = "Unauthorized";
            return Response::json($output); 
        }
        
    }

    public function sync_table()
    {
        $returnArr              = array();
        $temp                   = Input::all();

        $key                    = $temp['site_activation_key'];
        $site_activation_key    = Config::all();
        $activate_key           = 0;
        $today                  = Carbon::now();
        $cur_date               = Carbon::parse($today)->format('Y-m-d');
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key)
        {
            $syncs = DB::select("SELECT table_name,version FROM syncs_tables");

            foreach ($syncs as $key => $sync) 
            {
                if ($sync->table_name == "category") {
                    if ($syncs[$key]->version > $temp['category']) {
                        $category = DB::select(" SELECT id,name,status,parent_id,kitchen_id,mobile_image FROM category WHERE status='1'");

                        $returnArr['category'] = $category;

                    }
                }

                if ($sync->table_name == "items") {
                    if ($sync->version > $temp['items']) {
                        $item = DB::select("SELECT id,name,price,status,category_id,mobile_image FROM items WHERE status='1'");
                       
                        $returnArr['items'] = $item;
                    }
                }

                if ($sync->table_name == "add_on") {
                    if ($sync->version > $temp['add_on']) {
                        $addon = DB::select("SELECT id,food_name,category_id,price,status,mobile_image FROM add_on WHERE status='1'");
                        
                        $returnArr['addon'] = $addon;
                    }
                }

                if ($sync->table_name == "members") {
                    if ($sync->version > $temp['members']) {
                        $member              = DB::select("SELECT members.id,members.member_card_no,member_type.discount_amount FROM members LEFT JOIN member_type ON members.member_type_id = member_type.id");

                        $returnArr['member'] = $member;
                    }
                }
           
                if ($sync->table_name == "set_menu") {
                    if ($sync->version > $temp['set_menu']) {
                        $set_menu = DB::select("SELECT id,set_menus_name,set_menus_price,status,mobile_image FROM set_menu  WHERE status='1'");
                        $returnArr['set_menu'] = $set_menu;
                    }
                }

                if($sync->table_name == "set_item"){
                    if($sync->version > $temp['set_item']){
                        $set_item = DB::select("SELECT id,set_menu_id,item_id FROM set_item");
                        $returnArr['set_item'] = $set_item;
                    }
                }

                if ($sync->table_name == "rooms") {
                    if ($sync->version > $temp['rooms']) {
                        $room = DB::select("SELECT id,room_name,status FROM rooms");
                        $returnArr['room'] = $room;
                    }
                }

                if ($sync->table_name == "tables") {
                    if ($sync->version > $temp['tables']) {
                        $table = DB::select("SELECT id,table_no,status FROM tables");
                        $returnArr['table'] = $table;
                    }
                }

                 if ($sync->table_name == "booking") {
                    if ($sync->version > $temp['booking']) {
                       
                        $date  = Carbon::today();
                        $today = $date->toDateString();
                        $booking = DB::select("SELECT id,customer_name,from_time FROM booking WHERE booking_date = '$today' AND deleted_at is null ");
                        //print_r($booking);exit();
            
                        $table  = DB::select("SELECT booking_id,table_id FROM booking_table"); 
                        $room   = DB::select("SELECT booking_id,room_id FROM booking_room");

                        $returnObj = array();
                        if(isset($booking)){
                           foreach($booking as $key => $obj){
                                $booking_id = $obj->id;

                                $returnObj[] = $obj;
                                 
                                foreach($table as $booking_table => $t){
                                    if($booking_id == $t->booking_id){
                                       $returnObj[$key]->booking_table[] = $t;
                                    }
                                }
                                $bookingRoomArray = array();
                                foreach($room as $booking_room => $r){                
                                    if($booking_id == $r->booking_id){
                                        array_push( $bookingRoomArray, $r);

                                    }
                                }
                                    $returnObj[$key]->booking_room = $bookingRoomArray;

                                        if(!array_key_exists('booking_table', $returnObj[$key])){
                                            $returnObj[$key]->booking_table = array();
                                        }

                                        if(!array_key_exists('booking_room', $returnObj[$key])){
                                            $returnObj[$key]->booking_room = array();
                                        }      
                            }

                            $returnArr['booking'] = $returnObj;      
                        } else{
                            $returnArr['booking'] = array();    
                        }   
                        
                    }
                }

                if ($sync->table_name == "config") {
                    if ($sync->version > $temp['config']) {
                        $config = DB::select("SELECT tax,service,booking_warning_time,booking_waiting_time,booking_service_time,restaurant_name,logo,mobile_logo,email,
                            website,phone,address,message,remark,mobile_image FROM config");
                        $returnArr['config'] = $config;
                    }
                }

                if ($sync->table_name == "promotions") {
                    if ($sync->version > $temp['promotions']) {
                        $promotion = DB::select("SELECT id,promotion_type,from_date,to_date,from_time,to_time,sell_item_qty,present_item,present_item_qty FROM promotions");
                        $returnArr['promotion'] = $promotion;
                    }
                }

                if ($sync->table_name == "promotion_items") {
                    if ($sync->version > $temp['promotion_items']) {
                        $promotion_item = DB::select("SELECT promotion_id,item_id FROM promotion_items");
                        $returnArr['promotion_item'] = $promotion_item;
                    }
                }

                if ($sync->table_name == "discount") {
                    if ($syncs[$key]->version > $temp['discount'] && $syncs[$key]->version < $temp['discount']) {
                        $discount = DB::select("SELECT id,name,amount,type,start_date,end_date,item_id FROM discount WHERE $cur_date >= start_date AND $cur_date <= end_date");
                        $returnArr['discount'] = $discount;
                    }
                }
            }
            
            if (!array_key_exists('category', $returnArr)) {
            $returnArr['category'] = array();
            }
            if (!array_key_exists('items', $returnArr)) {
                $returnArr['items'] = array();
            }
            if (!array_key_exists('addon', $returnArr)) {
                $returnArr['addon'] = array();
            }
            if (!array_key_exists('set_menu', $returnArr)) {
                $returnArr['set_menu'] = array();
            }
            if (!array_key_exists('set_item', $returnArr)) {
                $returnArr['set_item'] = array();
            }
            
            if (!array_key_exists('room', $returnArr)) {
                $returnArr['room'] = array();
            }
            if (!array_key_exists('table', $returnArr)) {
                $returnArr['table'] = array();
            }
            if (!array_key_exists('promotion', $returnArr)) {
                $returnArr['promotion'] = array();
            }
            if (!array_key_exists('promotion_item', $returnArr)) {
                $returnArr['promotion_item'] = array();
            }
            
            if (!array_key_exists('member', $returnArr)) {
                $returnArr['member'] = array();
            }
            
            if (!array_key_exists('config', $returnArr)) {
                $returnArr['config'] = array();
            }
            if (!array_key_exists('booking', $returnArr)) {
                $returnArr['booking'] = array();
            }
            if (!array_key_exists('discount', $returnArr)) {
                $returnArr['discount'] = array();
            }
             return Response::json($returnArr);
        }else{
            //$output = array("Message" => "Unauthorized");
            $output['SyncsTable'] = "";
            $output['Message']="Unauthorized";
            return Response::json($output);
        }   
    }

}        


      

            
            
           
            
           
           
            
            
           
            
    
    



