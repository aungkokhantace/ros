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
        $waiter_id    			= $temp['waiter_id'];
        $filter 				= $temp['filter'];

       
        $site_activation_key    = Config::all();
        $activate_key           = 0;
        $today                  = Carbon::now();
        $cur_date               = Carbon::parse($today)->format('Y-m-d');
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        $result = array();

        if($key == $activate_key){
        	// $voucher = DB::select('SELECT id,user_id,take_id,order_time,total_extra_price,total_discount_amount,total_price ,all_total_amount,status FROM `order` WHERE status = 1 AND user_id = "$waiter_id" ');
        	if($filter == 'Now'){
        		$voucher  = DB::table('order')->where('status',1)->where('user_id',$waiter_id)->select('order.id','order.user_id','order.order_time','order.total_extra_price','order.total_discount_amount','order.total_price','order.all_total_amount','order.status')->get();
        		if(count($voucher) > 0){
		        		foreach($voucher as $voucher_check){
		        			$order_id = $voucher_check->id;
		        			$rooms = DB::table('order_room')->join('rooms','order_room.room_id','=','rooms.id')->where('order_id',$order_id)->first();
		        			
							$tables = DB::table('order_tables')->join('tables','order_tables.table_id','=','tables.id')->where('order_id',$order_id)->get();
							$tab = '';
							foreach($tables as $table){
								$tab .=  $table->table_no .',';
							}
							
		        			if(isset($rooms) && count($rooms)>0){
		        				$voucher_check->isRoom = 'true';
		        				$voucher_check->roomOrTable = $rooms->room_name;
		        			}elseif(isset($tables) && count($tables)>0){
		        				$voucher_check->isRoom = 'false';
		        				$voucher_check->roomOrTable = $tab;
		        			}else{
		        				$voucher_check->isRoom = 'false';
		        				$voucher_check->roomOrTable = "Take Away";
		        			}
		        		}
		        	}

        	}
        	elseif($filter == 'OtherWaiter'){
        		
        		$voucher  = DB::table('order')->where('status',1)->whereNotIn('user_id',[$waiter_id])->select('order.id','order.user_id','order.order_time','order.total_extra_price','order.total_discount_amount','order.total_price','order.all_total_amount','order.status')->get();
        	        if(count($voucher) > 0){
		        		foreach($voucher as $voucher_check){
		        			$order_id = $voucher_check->id;
		        			$rooms = DB::table('order_room')->join('rooms','order_room.room_id','=','rooms.id')->where('order_id',$order_id)->first();
		        			
		        			$tables = DB::table('order_tables')->join('tables','order_tables.table_id','=','tables.id')->where('order_id',$order_id)->get();
							$tab = '';
							foreach($tables as $table){
								$tab .=  $table->table_no .',';
							}
							
		        			if(isset($rooms) && count($rooms)>0){
		        				$voucher_check->isRoom = 'true';
		        				$voucher_check->roomOrTable = $rooms->room_name;
		        			}elseif(isset($tables) && count($tables)>0){
		        				$voucher_check->isRoom = 'false';
		        				$voucher_check->roomOrTable = $tab;
		        			}else{
		        				$voucher_check->isRoom = 'false';
		        				$voucher_check->roomOrTable = "Take Away";
		        			}
		        		}
		        	}

        	}else{

        		$voucher  = DB::table('order')->where('status',1)->select('order.id','order.user_id','order.order_time','order.total_extra_price','order.total_discount_amount','order.total_price','order.all_total_amount','order.status')->get();
        		if(count($voucher) > 0){
		        		foreach($voucher as $voucher_check){
		        			$order_id = $voucher_check->id;
		        			$rooms = DB::table('order_room')->join('rooms','order_room.room_id','=','rooms.id')->where('order_id',$order_id)->first();
		        			
		        			$tables = DB::table('order_tables')->join('tables','order_tables.table_id','=','tables.id')->where('order_id',$order_id)->get();
							$tab = '';
							foreach($tables as $table){
								$tab .=  $table->table_no .',';
							}
							
		        			if(isset($rooms) && count($rooms)>0){
		        				$voucher_check->isRoom = 'true';
		        				$voucher_check->roomOrTable = $rooms->room_name;
		        			}elseif(isset($tables) && count($tables)>0){
		        				$voucher_check->isRoom = 'false';
		        				$voucher_check->roomOrTable = $tab;
		        			}else{
		        				$voucher_check->isRoom = 'false';
		        				$voucher_check->roomOrTable = "Take Away";
		        			}
		        		}
		        	}
        	}
        	
        	
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
			// $order_extra_raw	= DB::select("SELECT extra_id,order_detail_id,quantity,amount FROM `order_extra` WHERE status = '$extra_status' AND deleted_at IS NULL");
			
			
			
			$order_table_raw	= DB::select("SELECT order_id,table_id FROM `order_tables` WHERE order_id = '$order_id' AND deleted_at IS NULL");
			$order_room_raw		= DB::select("SELECT order_id,room_id FROM `order_room` WHERE order_id = '$order_id' AND deleted_at IS NULL");
			
			
			$set_menu_arr		= array();
			$extra_arr			= array();
			$detail_arr			= array();
			$table_arr			= array();
			$room_arr			= array();
			$remark_arr         = array();
			
			if(isset($order_detail_raw) && count($order_detail_raw) > 0){
				
				foreach($order_detail_raw as $order_detail){
					$order_extra_raw    = OrderExtra::select('extra_id','order_detail_id','quantity','amount','status')->where('order_detail_id',$order_detail->order_detail_id)->get();
					$extra_ary = array();
					foreach($order_extra_raw as $ex){
						array_push($extra_ary,$ex->extra_id);
					}
					//merge setmenu to order_detail
					if(isset($order_setmenu_raw) && count($order_setmenu_raw) > 0) {
						foreach ($order_setmenu_raw as $order_setmenu) {
							if ($order_detail->id == $order_setmenu->order_detail_id) {
								array_push($set_menu_arr, $order_setmenu);
							}
						}
					}

					if($order_detail->remark_extra == null){
						$order_detail->remark_extra = "";
					}
					
					
					$order_detail->order_setmenu = $set_menu_arr;
					
					unset($set_menu_arr);
					$set_menu_arr = array();

					$category_id = Item::where('id',$order_detail->item_id)->value('category_id');
					
					$add_ons = Addon::where('category_id',$category_id)->get();
					
					// if(isset($order_extra_raw) && count($order_extra_raw) > 0) {

						$ex_ary = array();
						
						foreach($add_ons as $addon){
							$extra_mq = DB::table('order_extra')->where('extra_id',$addon->id)->where('order_detail_id',$order_detail->order_detail_id)->first();

							if(in_array($addon->id,$extra_ary)){
								$ex_de['extra_id'] = $addon->id;
								$ex_de['order_detail_id'] = $order_detail->order_detail_id;
								$ex_de['quantity'] = $extra_mq->quantity;
								$ex_de['amount'] = $extra_mq->amount;
								$ex_de['status'] = 1;
							}else{
								$ex_de['extra_id'] = $addon->id;
								$ex_de['order_detail_id'] = $order_detail->order_detail_id;
								$ex_de['quantity'] = '0';
								$ex_de['amount'] = 0.0;
								$ex_de['status'] = 0;
							}
							array_push($ex_ary,$ex_de);
							
						}
							
							array_push($extra_arr,$ex_ary);
					// }
					
					
					$order_detail->order_extra = $extra_arr[0];
					
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
              
					$order_remark_raw   = DB::table('order_detail_remark')->where('order_detail_id',$order_detail->order_detail_id)->whereNull('deleted_at')->get();
					$remarks = DB::table('item_remark')->join('remark','item_remark.remark_id','=','remark.id')->select('remark.name','item_remark.item_id as item_id','item_remark.remark_id')->where('item_remark.item_id',$order_detail->item_id)->get();

				   if(isset($remarks) && count($remarks)>0){
						$exist_remark_array = array();
						foreach($order_remark_raw as $remark_raw){
							array_push($exist_remark_array,$remark_raw->remark_id);
						}

						foreach($remarks as $remark){
							
							if(in_array($remark->remark_id,$exist_remark_array)){
								$remark->selected = true;
							}else{
								$remark->selected = false;
							}
							
						}
						
						
					}
					$order_detail->remark = $remarks;
					

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

