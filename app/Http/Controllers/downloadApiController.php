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
use App\RMS\MemberType\MemberType;
use App\RMS\Kitchen\Kitchen;
use App\RMS\Booking\Booking;
use App\RMS\Favourite\Favourite;
use App\RMS\SyncsTable\SyncsTable;
use App\RMS\Promotion\Promotion;
use App\RMS\PromotionItem\PromotionItem;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\OrderSetMenuDetail\OrderSetMenuDetail;
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

class downloadAPIController extends ApiGuardController
{	

	public function download_voucher(){
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

        $result = array();

        if($key == $activate_key){
        	$voucher = DB::select('SELECT id,take_id,order_time,total_extra_price,total_discount_amount,total_price ,all_total_amount,status FROM `order` WHERE status = 1');
        	$result   = $voucher;
        
        	$tables = DB::select('SELECT order_id,table_id FROM order_tables');
        	$rooms  = DB::select('SELECT order_id,room_id FROM order_room');

        	if(isset($voucher)){
        		// foreach($voucher as $key => $v){
        		// 	$order_table = array();
        		// 	$order_room  = array();

	        	// 	foreach($tables as $table){
	        	// 		if($v->id == $table->order_id){
	        	// 			array_push($order_table,$table);
	        	// 		}
	        	// 	}
	        	// 	foreach($rooms as $room){
	        	// 		if($v->id == $room->order_id){
	        	// 			array_push($order_room, $room);
	        	// 		}
	        	// 	}
	        	// 	 $result[$key]->order_table = $order_table;
	        	// 	 $result[$key]->order_room  = $order_room;
        		// }
        		
        	$output = array("Data" => $result);
            return Response::json($output); 
        	}
        }
	}

	public function download_voucher_detail(){
		$temp	= Input::all();
		$key                    = $temp['site_activation_key'];
		$order_id				= $temp['order_id'];
		$site_activation_key    = Config::all();
		$activate_key           = 0;
		//Order Extra Status
		$extra_status 			= StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
		foreach($site_activation_key as $k){
			$activate_key = $k->site_activation_key;
		}

		if($key == $activate_key){
			$order_raw			= DB::select("SELECT os.*,u.user_name FROM `order` os,`users` u WHERE os.id = '$order_id' AND os.user_id = u.id AND os.deleted_at IS NULL");
			$order_detail_raw 	= DB::select("SELECT * FROM `order_details` WHERE order_id = '$order_id' AND deleted_at IS NULL");
			$order_setmenu_raw	= DB::select("SELECT * FROM `order_setmenu_detail` WHERE deleted_at IS NULL");
			$order_extra_raw	= DB::select("SELECT extra_id,order_detail_id,quantity,amount FROM `order_extra` WHERE status = '$extra_status' AND deleted_at IS NULL");
			$order_table_raw	= DB::select("SELECT order_id,table_id FROM `order_tables` WHERE order_id = '$order_id' AND deleted_at IS NULL");
			$order_room_raw		= DB::select("SELECT order_id,room_id FROM `order_room` WHERE order_id = '$order_id' AND deleted_at IS NULL");
			$set_menu_arr		= array();
			$extra_arr			= array();
			$detail_arr			= array();
			$table_arr			= array();
			$room_arr			= array();
			if(isset($order_detail_raw) && count($order_detail_raw) > 0){
				foreach($order_detail_raw as $order_detail){
					//merge setmenu to order_detail
					if(isset($order_setmenu_raw) && count($order_setmenu_raw) > 0) {
						foreach ($order_setmenu_raw as $order_setmenu) {
							if ($order_detail->id == $order_setmenu->order_detail_id) {
								array_push($set_menu_arr, $order_setmenu);
							}
						}
					}
					$order_detail->order_setmenu = $set_menu_arr;
					unset($set_menu_arr);
					$set_menu_arr = array();

					//merge order_extra to order_detail
					if(isset($order_extra_raw) && count($order_extra_raw) > 0) {
						foreach ($order_extra_raw as $order_extra) {
							if ($order_detail->id == $order_extra->order_detail_id) {
								array_push($extra_arr, $order_extra);
							}
						}
					}
					$order_detail->order_extra = $extra_arr;
					unset($extra_arr);
					$extra_arr = array();

					//merge order_table to order_detail
					if(isset($order_table_raw) && count($order_table_raw) > 0){
						foreach($order_table_raw as $order_table){
							if($order_detail->order_id ==$order_table->order_id){
								array_push($table_arr,$order_table);
							}
						}
					}
					$order_detail->order_table = $table_arr;
					unset($table_arr);
					$table_arr = array();

					//merge order_room to order_detail
					if(isset($order_room_raw) && count($order_room_raw) > 0){
						foreach($order_room_raw as $order_room){
							if($order_detail->order_id == $order_room->order_id){
								array_push($room_arr,$order_room);
							}
						}
					}
					$order_detail->order_room = $room_arr;
					unset($room_arr);
					$room_arr = array();

					//For Android to know old item
					$order_detail->state 	= 'old';
				}
			}
			if(isset($order_raw) && count($order_raw) > 0){
				foreach($order_raw as $order){
					foreach($order_detail_raw as $detail){
						if($order->id == $detail->order_id){
							array_push($detail_arr,$detail);
						}
					}
					$order->order_detail = $detail_arr;
				}
			}

			$output = array("Data" => $order_raw);
			return Response::json($output);
		}
	}

	public function order_table(){
		$temp = Input::all();
        $key  = $temp['site_activation_key'];
        $table_id = $temp['table_id'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        
        if($key == $activate_key){
        	$order_table = OrderTable::leftjoin('order','order.id','=','order_tables.order_id')->select('order_tables.table_id','order_tables.order_id')->where('order.status','=',1)->where('order_tables.table_id','=',$table_id)->first();
        	if($order_table == null){
        		$output = array("order_id" => "NULL");
            	return Response::json($output);
        	}else{
        		$id = $order_table->order_id;
            	$output = array("order_id" => $id);
            	return Response::json($output);
        	}
           
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);   
        } 
	}

	public function order_room(){
		$temp = Input::all();
        $key  = $temp['site_activation_key'];
        $room_id = $temp['room_id'];
        $site_activation_key = Config::all();
        $activate_key = 0;

        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }
        
        if($key == $activate_key){
            $room_table = OrderRoom::leftjoin('order','order.id','=','order_room.order_id')->select('order_room.room_id','order_room.order_id')->where('order.status','=',1)->where('order_room.room_id','=',$room_id)->first();
            if($room_table == null){
            	$output = array("room_table" => "NULL");
            	return Response::json($output);
            }else{
            	$id =$room_table->order_id;
            	$output = array("room_table" => $id);
            	return Response::json($output);
            }
           
        }else{
            $output = array("Message" => "Unauthorized");
            return Response::json($output);   
        } 
	}

	public function order_table_with_order_id(){
		$temp 					= Input::all();
		$key  					= $temp['site_activation_key'];
		$order_id 				= $temp['order_id'];
		$site_activation_key 	= Config::all();
		$activate_key 			= 0;
		foreach($site_activation_key as $k){
			$activate_key = $k->site_activation_key;
		}

		if($key == $activate_key){
			$table = DB::select("SELECT id,table_id,order_id FROM order_tables WHERE order_id = '$order_id'");
			$output = array("order_table" => $table);
			return Response::json($output);
		}else{
			$output = array("Message" => "Unauthorized");
			return Response::json($output);
		}
	}

	public function order_room_with_order_id(){
		$temp 					= Input::all();
		$key 					= $temp['site_activation_key'];
		$order_id 				= $temp['order_id'];
		$site_activation_key 	= Config::all();
		$activate_key 			= 0;
		foreach($site_activation_key as $k){
			$activate_key = $k->site_activation_key;
		}
		if($key == $activate_key){
			$room = DB::select("SELECT id,room_id,order_id FROM order_room WHERE order_id = '$order_id' ");
			$output = array("order_room" => $room);
			return Response::json($output);
		}else{
			$output = array("Message"=>"Unauthorized");
			return Response::json($output);
		}
	}

	
     	
}

