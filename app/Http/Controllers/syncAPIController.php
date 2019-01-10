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
use App\Status\StatusConstance;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\RMS\User\UserRepository;
use App\RMS\Utility;
use App\Http\Controllers\inventory\inventoryController;

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
            $category = DB::select("SELECT id,name,status,parent_id,kitchen_id,image FROM category WHERE status = '1' AND deleted_at IS NULL");
            $set_menu = DB::select("SELECT id,set_menus_name,set_menus_price,status FROM set_menu WHERE status = '1' AND deleted_at IS NULL");
            $set_item = DB::select("SELECT id,set_menu_id,item_id FROM set_item WHERE deleted_at IS NULL");

            $output = array("category" => $category,"set_menu"=>$set_menu,"set_item"=>$set_item);
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
            $addon = DB::select("SELECT id,food_name,category_id,image,price,status,mobile_image FROM add_on WHERE status = '1' AND deleted_at IS NULL");

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
            $inventory = new inventoryController();
            $items = DB::select("SELECT id,name,image,price,status,category_id,continent_id,group_id,isdefault,has_continent,standard_cooking_time,is_ready_food,stock_code FROM items WHERE status = '1' AND deleted_at IS NULL");
            $remainitems = $inventory->getremainbalance();
            $remainAry = array();
           
            foreach($items as $item){
             $remarks  = DB::table('item_remark')->join('remark','remark.id','=','item_remark.remark_id')->select('remark.name','remark.id as remark_id','item_remark.item_id')->where('item_id',$item->id)->get();
             //add selected->false to all remark
             foreach($remarks as $remark)
             {
                $remark->selected = false;
             }
              
              $item->remark = $remarks;
              $item->remark_extra = '';
                if(isset($remainitems) && count($remainitems)>0){
                    foreach($remainitems as $remain){
                        if($item->stock_code == $remain->StockNo){
                        $item->remaining_quantity = $remain->CurrentBalance;
                        break;
                        }else{
                        $item->remaining_quantity = '0';
                        }
                   }
                }else{
                    $item->remaining_quantity = '0';
                }
                    
              if($item->is_ready_food == '1'){
                $item->is_ready_food  = true;
              }else{
                 $item->is_ready_food = false;
              }

            }
            $output = array("items" => $items);
            return Response::json($output);
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);
        }
    }

    public function continent()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();

        $activate_key = 0;
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        if($key == $activate_key){
            $continent  = DB::select("SELECT id,name FROM continent WHERE deleted_at IS NULL ");
            $output     = array("continents" => $continent);
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
            $set_menu = DB::select("SELECT id,set_menus_name,set_menus_price,image,status,mobile_image FROM set_menu WHERE status = '1' AND deleted_at IS NULL");
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
            $set_item = DB::select("SELECT id,set_menu_id,item_id FROM set_item WHERE deleted_at IS NULL");
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
            $config = DB::select("SELECT tax,service,booking_warning_time,booking_waiting_time,booking_service_time,room_charge,restaurant_name,logo,mobile_logo,email,website,phone,address,message,remark,mobile_image FROM config");

        $output = array("config" => $config);
        return Response::json($output);
        }else{
             $output = array("Message" => "Unauthorized");
            return Response::json($output);
        }

    }

    public function table()
    {

        $temp           = Input::all();
        $key            = $temp['site_activation_key'];
        $location_id    = $temp['location_id'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
  

        if($key == $activate_key){
           
            $cur_date      = date('Y-m-d');
            $default_status         = StatusConstance::BOOKING_DEFAULT_STATUS;
            $warning_status         = StatusConstance::BOOKING_WARNING_STATUS;
            $waiting_status         = StatusConstance::BOOKING_WAITING_STATUS;
            $active_status          = StatusConstance::TABLE_ACTIVE_STATUS;
            $array          = array($default_status,$warning_status,$waiting_status);
            //Get tables and Status From Booking Table
            $booking        = Booking::leftjoin('booking_table','booking.id','=','booking_table.booking_id')
                              ->select('booking.status as status','booking_table.table_id as table_id')
                              ->where('booking_date','=',$cur_date)
                              ->whereIn('booking.status',$array)
                              ->get();
            $tables = DB::table('tables')->where('location_id',$location_id)->where('active',$active_status)->whereNull('deleted_at')->select('tables.id','tables.table_no','tables.status')->get();
            
            // $tables = DB::select("SELECT id,table_no,status FROM tables WHERE active = '$active_status' , WHERE location_id = '$location_id' AND deleted_at IS NULL");
            $table_arr  = array();
            foreach($tables as $key => $table) {

                $table_id       = $table->id;
                $table_no       = $table->table_no;
                $status         = $table->status;

                $table_arr[$key]['id']          = $table->id;
                $table_arr[$key]['table_no']    = $table->table_no;
                $table_arr[$key]['status']      = $table->status;
                /*
                $booking_table_arr  = array();
                foreach($booking as $book) {
                    $booking_table_id       = $book->table_id;
                    $booking_table_status   = $book->status;
                    $booking_table_arr[$booking_table_id] = $booking_table_status;
                }

                //If Array Key Exit in table id
                if (array_key_exists($table_id, $booking_table_arr)) {
                    $table_arr[$key]['status']      = $booking_table_arr[$table_id];
                } else {
                    $table_arr[$key]['status']      = $table->status;
                }
                */
            }
            $output = array("table" => $table_arr);
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
             $cur_date      = date('Y-m-d');
            $default_status         = StatusConstance::BOOKING_DEFAULT_STATUS;
            $warning_status         = StatusConstance::BOOKING_WARNING_STATUS;
            $waiting_status         = StatusConstance::BOOKING_WAITING_STATUS;
            $active_status          = StatusConstance::ROOM_ACTIVE_STATUS;
            $array          = array($default_status,$warning_status,$waiting_status);
            //Get tables and Status From Booking Table
            $booking        = Booking::leftjoin('booking_room','booking.id','=','booking_room.booking_id')
                              ->select('booking.status as status','booking_room.room_id as room_id')
                              ->whereIn('booking.status',$array)
                              ->get();
            $rooms = DB::select("SELECT id,room_name,status FROM rooms WHERE active = '$active_status' AND deleted_at IS NULL");
            $room_arr  = array();

            foreach($rooms as $key => $room) {

                $room_id        = $room->id;
                $room_name      = $room->room_name;
                $status         = $room->status;

                $room_arr[$key]['id']          = $room_id;
                $room_arr[$key]['room_name']   = $room_name;
                $room_arr[$key]['status']      = $status;
                /*
                $booking_room_arr  = array();
                foreach($booking as $book) {
                    $booking_room_id       = $book->room_id;
                    $booking_room_status   = $book->status;
                    $booking_room_arr[$booking_room_id] = $booking_room_status;
                }

                //If Array Key Exit in table id
                if (array_key_exists($room_id, $booking_room_arr)) {
                    $room_arr[$key]['status']      = $booking_room_arr[$room_id];
                } else {
                    $room_arr[$key]['status']      = $room->status;
                }
                */
            }

            $output = array("room" => $room_arr);
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
            $discount = DB::select("SELECT amount,type,item_id FROM discount WHERE DATE_FORMAT(start_date, '%Y-%m-%d') <= '$cur_date' AND DATE_FORMAT(end_date, '%Y-%m-%d') >= '$cur_date' AND deleted_at IS NULL");
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
                $booking = DB::select("SELECT id,customer_name,from_time,to_time FROM booking WHERE booking_date = '$today' AND deleted_at is null ");
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
                            //Get Table Capicity
                            $capacityObj  = Table::find($t->table_id);
                            $capacity     = $capacityObj->capacity;
                            $t->capicity  = $capacity;
                            $returnObj[$key]->booking_table[] = $t;
                        }

                    }

                    $bookingRoomArray = array();
                    foreach($room as $booking_room => $r){
                        if($booking_id == $r->booking_id){
                            //Get Room Capicity
                            $capacityObj    = Room::find($r->room_id);
                            $capacity       = $capacityObj->capacity;
                            $r->capicity  = $capacity;
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


    public function booking_table()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $date       = Carbon::today();
            $today      = $date->toDateString();

            $datetime   = Carbon::now();
            $timeStr    = $datetime->toTimeString();
            $booking    = BookingTable::leftjoin('booking','booking_table.booking_id','=','booking.id')
                        ->leftjoin('tables','booking_table.table_id','=','tables.id')
                        ->select('tables.table_no','booking.booking_date','booking.customer_name','booking.capacity','booking.from_time','booking.deleted_at')
                        ->where('booking.booking_date','>=',$today)
                        ->where('booking.from_time','>',$timeStr)
                        ->whereNull('booking.deleted_at')
                        ->get();

            $returnObj  = array();
            $tempArr    = array();
            if(isset($booking)){
                foreach ($booking as $key => $obj) {
                    $tempArr['table_no']     = $obj->table_no;
                    $tempArr['booking_date'] = $obj->booking_date;
                    $tempArr['booking_time'] = $obj->from_time;
                    $tempArr['customer_name']= $obj->customer_name;
                    $tempArr['capacity']     = $obj->capacity;
                    array_push($returnObj, $tempArr);
                }
            }
                //dd($returnObj);
            $output = array("booking" => $returnObj);
            return Response::json($output);
        } else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);
        }


    }

    public function booking_room()
    {
        $temp = Input::all();
        $key  = $temp['site_activation_key'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $date       = Carbon::today();
            $today      = $date->toDateString();

            $datetime   = Carbon::now();
            $timeStr    = $datetime->toTimeString();
            $booking    = BookingRoom::leftjoin('booking','booking_room.booking_id','=','booking.id')
                        ->leftjoin('rooms','booking_room.room_id','=','rooms.id')
                        ->select('rooms.room_name','booking.booking_date','booking.customer_name','booking.capacity','booking.from_time','booking.deleted_at')
                        ->where('booking.booking_date','>=',$today)
                        ->where('booking.from_time','>',$timeStr)
                        ->whereNull('booking.deleted_at')
                        ->get();

            $returnObj  = array();
            $tempArr    = array();
            if(isset($booking)){
                foreach ($booking as $key => $obj) {
                    $tempArr['room_name']    = $obj->room_name;
                    $tempArr['booking_date'] = $obj->booking_date;
                    $tempArr['booking_time'] = $obj->from_time;
                    $tempArr['customer_name']= $obj->customer_name;
                    $tempArr['capacity']     = $obj->capacity;
                    array_push($returnObj, $tempArr);
                }
            }
                //dd($returnObj);
            $output = array("booking" => $returnObj);
            return Response::json($output);
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
                if($sync->table_name == "category" || $sync->table_name == "items" || $sync->table_name == "set_menu" || $sync->table_name == "set_item" || $sync->table_name =="discount" || $sync->table_name == "members" || $sync->table_name == "add_on" || $sync->table_name == "rooms" || $sync->table_name == "tables" || $sync->table_name == "booking" || $sync->table_nam == "config" || $sync->table_name == "promotions" || $sync->table_name == "promotion_items" || $sync->table_name == "config" || $sync->table_name == "continent" || $sync->table_name == "shift_category" || $sync->table_name == "shift_setmenu" || $sync->table_name == "locations"){

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
                        $category = DB::select(" SELECT id,name,status,parent_id,kitchen_id,image FROM category WHERE status='1' AND deleted_at IS NULL");
                        $category_count     = count($category);
                        if ($category_count > 0) {
                             $returnArr['category'] = $category;
                        } else {
                            $returnArr['category'] = Null;
                        }
                    }
                }

                if ($sync->table_name == "items") {
                    if ($sync->version > $temp['items']) {
                        $inventory = new inventoryController();
                        $items = DB::select("SELECT id,name,image,price,status,category_id,continent_id,group_id,isdefault,has_continent,standard_cooking_time,is_ready_food,stock_code FROM items WHERE status = '1' AND deleted_at IS NULL");
                        $remainitems = $inventory->getremainbalance();
                        
                        foreach($items as $item){
                            
                         $remarks  = DB::table('item_remark')->join('remark','remark.id','=','item_remark.remark_id')->select('remark.name','remark.id as remark_id','item_remark.item_id')->where('item_id',$item->id)->get();
                         //add selected->false to all remark
                         foreach($remarks as $remark)
                         {
                            $remark->selected = false;
                         }
                          
                          $item->remark = $remarks;
                          $item->remark_extra = '';
                          
                        if(isset($remainitems) && count($remainitems)>0){
                            foreach($remainitems as $remain){
                                if($item->stock_code == $remain->StockNo){
                                $item->remaining_quantity = $remain->CurrentBalance;
                                break;
                                }else{
                                $item->remaining_quantity = '0';
                                }
                           }
                        }else{
                            $item->remaining_quantity = '0';
                        }
                          
                          if($item->is_ready_food == '1'){
                            $item->is_ready_food  = true;
                          }else{
                             $item->is_ready_food = false;
                          }

                         }
                       
                        $item_count     = count($items);
                        if ($item_count > 0) {
                             $returnArr['items'] = $items;

                             
                        } else {
                            $returnArr['items'] = Null;
                          
                        }

                    }
                }

                if ($sync->table_name == "add_on") {
                    if ($sync->version > $temp['add_on']) {
                        $addon = DB::select("SELECT id,food_name,category_id,price,status,image FROM add_on WHERE status='1' AND deleted_at IS NULL");
                        $addon_count     = count($addon);
                        if ($addon_count > 0) {
                             $returnArr['addon'] = $addon;
                        } else {
                            $returnArr['addon'] = Null;
                        }
                    }
                }

                if ($sync->table_name == "members") {
                    if ($sync->version > $temp['members']) {
                        $member              = DB::select("SELECT members.id,members.member_card_no,member_type.discount_amount FROM members LEFT JOIN member_type ON members.member_type_id = member_type.id");
                        $member_count     = count($member);
                        if ($member_count > 0) {
                             $returnArr['member'] = $member;
                        } else {
                            $returnArr['member'] = Null;
                        }
                    }
                }

                    if ($sync->table_name == "set_menu") {
                    if ($sync->version > $temp['set_menu']) {
                        $set_menu = DB::select("SELECT id,set_menus_name,set_menus_price,status,image FROM set_menu  WHERE status='1' AND deleted_at IS NULL");
                        $set_menu_count     = count($set_menu);
                        if ($set_menu_count > 0) {
                             $returnArr['set_menu'] = $set_menu;
                        } else {
                            $returnArr['set_menu'] = Null;
                        }
                    }
                }

                if($sync->table_name == "set_item"){
                    if($sync->version > $temp['set_item']){
                        $set_item = DB::select("SELECT id,set_menu_id,item_id FROM set_item WHERE deleted_at IS NULL");
                        $set_item_count     = count($set_item);
                        if ($set_item_count > 0) {
                             $returnArr['set_item'] = $set_item;
                        } else {
                            $returnArr['set_item'] = Null;
                        }
                    }
                }

                if($sync->table_name == "locations"){

                    if($sync->version > $temp['locations']){

                        $locations = DB::select("SELECT id,location_type FROM locations WHERE deleted_at IS NULL");
                       
                        $location_count     = count($locations);
                        if ($location_count > 0) {
                             $returnArr['locations'] = $locations;
                        } else {
                        
                            $returnArr['locations'] = Null;
                        }
                    }
                }

                if ($sync->table_name == "rooms") {
                    if ($sync->version > $temp['rooms']) {
                        $room = DB::select("SELECT id,room_name,status FROM rooms WHERE deleted_at IS NULL");
                        $room_count     = count($room);
                        if ($room_count > 0) {
                             $returnArr['room'] = $room;
                        } else {
                            $returnArr['room'] = Null;
                        }
                    }
                }

                if ($sync->table_name == "remark") {
                    if ($sync->version > $temp['remark']) {
                        $remark = DB::select("SELECT id,name,remark_code,status FROM remark WHERE deleted_at IS NULL");
                        $remark_count     = count($remark);
                        if ($remark_count > 0) {
                             $returnArr['remark'] = $remark;
                        } else {
                            $returnArr['remark'] = Null;
                        }
                    }
                }

                if ($sync->table_name == "item_remark") {
                    if ($sync->version > $temp['item_remark']) {
                        $item_remark = DB::select("SELECT item_id,remark_id  FROM item_remark WHERE deleted_at IS NULL");
                        $item_remark_count     = count($item_remark);
                        if ($item_remark_count > 0) {
                             $returnArr['item_remark'] = $item_remark;
                        } else {
                            $returnArr['item_remark'] = Null;
                        }
                    }
                }

                if ($sync->table_name == "tables") {
                    if ($sync->version > $temp['tables']) {
                        $table = DB::select("SELECT id,table_no,location_id,status FROM tables WHERE deleted_at IS NULL");
                        $table_count     = count($table);
                        if ($table_count > 0) {
                             $returnArr['table'] = $table;
                        } else {
                            $returnArr['table'] = Null;
                        }
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
                        $config = DB::select("SELECT tax,service,booking_warning_time,room_charge,booking_waiting_time,booking_service_time,restaurant_name,logo,mobile_logo,email,
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
                    if ($syncs[$key]->version > $temp['discount']) {
                        $discount = DB::select("SELECT id,name,amount,type,start_date,end_date,item_id FROM discount WHERE DATE_FORMAT(start_date, '%Y-%m-%d') <= '$cur_date' AND DATE_FORMAT(end_date, '%Y-%m-%d') >= '$cur_date'");
                        $discount_count     = count($discount);
                        if ($discount_count > 0) {
                             $returnArr['discount'] = $discount;
                        } else {
                            $returnArr['discount'] = Null;
                        }
                    }
                }

                if ($sync->table_name == "continent") {
                    if ($syncs[$key]->version > $temp['continent']) {
                        $continent = DB::select("SELECT id,name,description FROM continent WHERE deleted_at IS NULL");
                        $continent_count     = count($continent);
                        if ($continent_count > 0) {
                             $returnArr['continent'] = $continent;
                        } else {
                            $returnArr['continent'] = Null;
                        }
                        $returnArr['continent'] = $continent;
                    }
                }

                if ($sync->table_name == "shift_category") {
                    if ($sync->version > $temp['shift_category']) {
                        $shift_category = DB::select("SELECT id,shift_id,category_id FROM shift_category WHERE status = 1 AND deleted_at IS NULL");
                        $shift_cat_count    = count($shift_category);
                        if ($shift_cat_count > 0) {
                            $returnArr['shift_category'] = $shift_category;
                        } else {
                            $returnArr['shift_category'] = Null;
                        }
                    } else {
                        $returnArr['shift_category']     = array();
                    }
                }

                if ($sync->table_name == "shift_setmenu") {
                    if ($sync->version > $temp['shift_setmenu']) {
                        $shift_setmenu = DB::select("SELECT id,shift_id,setmenu_id FROM shift_setmenu WHERE status = 1 AND deleted_at IS NULL");
                        if (count($shift_setmenu) > 0) {
                            $returnArr['shift_setmenu'] = $shift_setmenu;
                        } else {
                            $returnArr['shift_setmenu'] = Null;
                        }
                    } else {
                        $returnArr['shift_setmenu']     = array();
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
            if (!array_key_exists('continent', $returnArr)) {
                $returnArr['continent'] = array();
            }
            if (!array_key_exists('shift_category', $returnArr)) {
                $returnArr['shift_category'] = array();
            }
            if (!array_key_exists('shift_setmenu', $returnArr)) {
                $returnArr['shift_setmenu'] = array();
            }
            if (!array_key_exists('locations', $returnArr)) {
                $returnArr['locations'] = array();
            }
             return Response::json($returnArr);
        }else{
            //$output = array("Message" => "Unauthorized");
            $output['SyncsTable'] = "";
            $output['Message']="Unauthorized";
            return Response::json($output);
        }
    }

    public function tablelist(){
        $temp                   = Input::all();
        $key                    = $temp['site_activation_key'];
        $site_activation_key    = Config::all();
        $activate_key           = 0;
        $today                  = Carbon::now();
        $cur_date               = Carbon::parse($today)->format('Y-m-d');
        $returnObj              = array();
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key)
        {

           $location_id = $temp['location_id'];
           $tables = DB::table('tables')->where('location_id',$location_id)->whereNull('deleted_at')->select('tables.id','tables.table_no','tables.area','tables.capacity')->get();

           if(count($tables)>0)
           {
             $returnObj = $tables;
           }else
           {
             $returnObj = null;
           }

           return Response::json($returnObj);

        }else{

            $returnObj['tables'] = "";
            $returnObj['Message']="Unauthorized";
            return Response::json($returnObj);
        }
    }

}
