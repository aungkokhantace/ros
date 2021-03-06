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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\RMS\User\UserRepository;
use App\RMS\Utility;

class MakeAPIController extends ApiGuardController
{

    public function login()
    {
        $temp     = Input::all();
        
        $username = $temp['username'];
        $password = $temp['password'];
        $key      = $temp['site_activation_key'];
        $site_activation_key = Config::all();

        $activate_key = 0;
        foreach($site_activation_key as $k){
           $activate_key = $k->site_activation_key;
        }

        if($key == $activate_key){
            $validation = Auth::guard('Cashier')->attempt([
                'user_name' => $username,
                'password' => $password,
            ]);
            if ($validation) {
                if (Auth::guard('Cashier')->check()) {
                    $id = Auth::guard('Cashier')->user()->id;
                    $cur = Carbon::now();
                    $userRepo = new UserRepository();
                    $userRepo->changeDisableToEnable($id, $cur);
                    $role = User::find($id);
                    
                    $r = $role->roles->name;
                    if ($r == "Waiter") {
                        $output = array("message" => "Success","waiter_id"=>$id);
                        return Response::json($output);
                    } else {
                        $output = array("message" => "Fail");
                        return Response::json($output);
                    }
                } else {
                    $output = array("message" => "Fail");
                    return Response::json($output);
                }
            } else {
                $output = array("message" => "Fail");
                return Response::json($output);
            }
        }else{
            $output = array("message" => "Unauthorized");
            return Response::json($output);
        }
        
    }

    public function create_voucher()
    {
        $temp       = Input::all();
        $ordersRaw  = $temp['orderID'];
        $orders     = json_decode($ordersRaw);
        
        $dt         = Carbon::now();
        foreach($orders as $order) {

            $user_id                = $order->user_id;
            $take_id                = $order->take_id;
            $order_id               = $order->order_id;
            $total_extra_price      = $order->extra_price;
            $total_discount_amount  = $order->discount_amount;
            $total_price            = $order->total_price;
            $service_amount         = $order->service_amount;
            $tax_amount             = $order->tax_amount;
            $all_total_amount       = $order->net_price;
            $order_tables           = $order->order_table;
            $order_rooms            = $order->order_room;
            $order_details          = $order->order_detail;

        }

        $order                          = new Order();
        $order->id                      = $order_id;
        $order->user_id                 = $user_id;
        $order->take_id                 = $take_id;
        $order->order_time              = $dt->toDateTimeString();
        $order->total_extra_price       = $total_extra_price;
        $order->total_discount_amount   = $total_discount_amount;
        $order->total_price             = $total_price;
        $order->service_amount          = $service_amount;
        $order->tax_amount              = $tax_amount;
        $order->all_total_amount        = $all_total_amount;

        $order->save();

        if(isset($order_tables)){
            foreach($order_tables as $table){
                $temp           = new OrderTable();
                $temp->order_id = $order_id;
                $temp->table_id = $table->table_id;
                $temp->save();
            }
        }

        if(isset($order_rooms)){
            foreach($order_rooms as $room){
                $temp           = new OrderRoom();
                $temp->order_id = $order_id;
                $temp->room_id  = $room->room_id;
                $temp->save();
            }
        }
        
        foreach ($order_details as $order_detail) {
            $temp = new Orderdetail();
            $temp->order_id             = $order_id;
            $temp->item_id              = $order_detail->item_id;
            $temp->order_detail_id      = $order_detail->order_detail_id;
            $temp->setmenu_id               = $order_detail->set_id;
            $temp->quantity             = $order_detail->quantity;
            $temp->order_type_id        = $order_detail->order_type_id;
            $temp->discount_amount      = $order_detail->discount_amount;
            $temp->exception            = $order_detail->exception;
            $temp->promotion_id         = $order_detail->promotion_id;
            $temp->amount               = $order_detail->price;
            $temp->amount_with_discount = $order_detail->amount;
            $temp->order_time           = $dt->toDateTimeString();
            $temp->status_id            = $order_detail->status;
            $temp->save();
            
            $set_item = $order_detail->set_item;
            foreach($set_item as $item){
                $set = new OrderSetMenuDetail();
                $set->order_detail_id = $temp->id;
                $set->setmenu_id      = $item->set_menu_id;
                $set->item_id         = $item->item_id;
                $set->order_type_id   = $temp->order_type_id;
                $set->exception       = $temp->exception;
                $set->order_time      = $dt->toDateTimeString();
                $set->status_id       = $temp->status_id;
                $set->quantity        = "1";
                $set->save();
            }

            $extra = $order_detail->extra;
            foreach ($extra as $e) {
                $extra = new OrderExtra();
                $extra->order_detail_id = $temp->id;
                $extra->extra_id = $e->extra_id;
                $extra->quantity = $e->quantity;
                $extra->amount = $e->amount;
                $extra->save();
            }


        }

        $output = array("message" => "Success");
        return Response::json($output);
    }

    public function add_new_to_voucher(){
        $temp       = Input::all();
        $ordersRaw  = $temp['orderID'];
        $orders     = json_decode($ordersRaw);
        
        $dt         = Carbon::now();
        foreach($orders as $order) {
            $order_id       = $order->order_id;
            $total_price    = $order->total_price;
            $service_amount = $order->service_amount;
            $tax_amount     = $order->tax_amount;
            $net_price      = $order->net_price;
            $order_details  = $order->order_detail;
        }
        
        $order                      = Order::find($order_id);
        $order->total_price         = $total_price;
        $order->service_amount      = $service_amount;
        $order->tax_amount          = $tax_amount;
        $order->all_total_amount    = $net_price;
        $order->save();

        foreach ($order_details as $order_detail) {
            $order_detail_id = $order_detail->order_detail_id;
            $order = Orderdetail::where('order_detail_id',$order_detail_id)->first();
            if($order == null){
                 $temp = new Orderdetail();

            $temp->order_id             = $order_id;
            $temp->item_id              = $order_detail->item_id;
            $temp->order_detail_id      = $order_detail->order_detail_id;
            $temp->setmenu_id           = $order_detail->set_id;
            $temp->quantity             = $order_detail->quantity;
            $temp->order_type_id        = $order_detail->order_type_id;
            $temp->discount_amount      = $order_detail->discount_amount;
            $temp->exception            = $order_detail->exception;
            $temp->promotion_id         = $order_detail->promotion_id;
            $temp->amount               = $order_detail->price;
            $temp->amount_with_discount = $order_detail->amount;
            $temp->order_time           = $dt->toDateTimeString();
            $temp->status_id            = $order_detail->status;
            $temp->save();
            
            $set_item = $order_detail->set_item;
            foreach($set_item as $item){
                $set = new OrderSetMenuDetail();
                $set->order_detail_id = $temp->id;
                $set->setmenu_id      = $item->set_menu_id;
                $set->item_id         = $item->item_id;
                $set->order_type_id   = $temp->order_type_id;
                $set->exception       = $temp->exception;
                $set->order_time      = $dt->toDateTimeString();
                $set->status_id       = $temp->status_id;
                $set->quantity        = "1";
                $set->save();
            }
            
            $extra = $order_detail->extra;
            foreach ($extra as $e) {
                $extra = new OrderExtra();
                $extra->order_detail_id = $temp->id;
                $extra->extra_id = $e->extra_id;
                $extra->quantity = $e->quantity;
                $extra->amount = $e->amount;
                $extra->save();
            }
            }
           
        }

        $output = array("message" => "Success");
        return Response::json($output);
    }


    public function cancel(){
        $status = Input::all();
        
        $order = Orderdetaill::select('status','message')->where('status','=', 6)->get();
        $output = array("order" => $order);
        return Response::json($output);
    }
    public function kitchen_cancel(){
        $kitchen_cancel = DB::select("SELECT id,order_id,status_id,message FROM order_details WHERE status_id = 6");
        $output = array("kitchen_cancel" => $kitchen_cancel);
        return Response::json($output);
    }

    public function table_status(){
        $tempObj            = Input::all();
        $tableRaw           = $tempObj['table'];
        $tables             = json_decode($tableRaw);

        foreach($tables as $t){
            $table_id           = $t->table_id;
            $status             = $t->status;
            $booking_id         = $t->booking_id;

            if($booking_id == 'null'){
                $table              = Table::find($table_id);
                $table->status      = $status;
                $table->save();
            }else{
                $table              = Table::find($table_id);
                $table->status      = $status;
                $table->save();
                
                $booking_table      = BookingTable::where('booking_id','=',$booking_id)->get();
                foreach($booking_table as $table){
                    if($table->table_id == $t->table_id){
                        $bookingTable               = BookingTable::find($table->id);
                        $bookingTable               = Utility::addDeletedBy($bookingTable);
                        $bookingTable->deleted_at   = date('Y-m-d H:m:i');
                        $bookingTable->save();
                    }
                }

                $b_table = BookingTable::where('booking_id','=',$booking_id)->where('deleted_at','=',null)->count();
                if($b_table == 0){
                    $booking            = Booking::find($booking_id);
                    $booking            = Utility::addDeletedBy($booking);
                    $booking->deleted_at= date('Y-m-d H:m:i');
                    $booking->save();
                }
            }
        }
        
        $output             = array("message" => "Success");
        return Response::json($output);
    }

    public function room_status(){
        $temp               = Input::all();
        $roomRaw            = $temp['room'];
        $rooms              = json_decode($roomRaw);
            $room_id            = $rooms->room_id;
            $status             = $rooms->status;
            $booking_id         = $rooms->booking_id;
            if($booking_id == 'null'){
                $room              = Room::find($room_id);
                $room->status      = $status;
                $room->save();
            }else{
                $room              = Room::find($room_id);
                $room->status      = $status;
                $room->save();
                $booking_room      = BookingRoom::where('booking_id','=',$booking_id)->get();
                foreach($booking_room as $room){
                    if($room->room_id == $r->room_id){
                        $bookingRoom               = BookingRoom::find($table->id);
                        $bookingRoom               = Utility::addDeletedBy($bookingRoom);
                        $bookingRoom->deleted_at   = date('Y-m-d H:m:i');
                        $bookingRoom->save();
                    }
                }
                $booking            = Booking::find($booking_id);
                $booking            = Utility::addDeletedBy($booking);
                $booking->deleted_at= date('Y-m-d H:m:i');
                $booking->save();    
            }

        $output             = array("message" => "Success");
        return Response::json($output);
    }

    public function table_transfer(){
        $temp               = Input::all();
        // $tempRaw            = $temp['table_transfer'];
        // $order_id           = $temp['order_id'];
        // $tableObj           = json_decode($tempRaw);

        $order_id           = $temp['order_id'];
        $transfer_from_table_id = $temp['transfer_from_table_id'];
        $transfer_to_table_id = $temp['transfer_to_table_id'];

        $from_table         = Table::find($transfer_from_table_id);
        $from_table->status = 0;
        $from_table->save();
        $to_table           = Table::find($transfer_to_table_id);
        $to_table->status   = 1;
        $to_table->save();


        $order_table        = OrderTable::where('order_id',$order_id)->where('table_id',$transfer_from_table_id)->first();

        $order_table->table_id = $transfer_to_table_id;
        $order_table->save();

        $output             = array("message" => "Success");
        return Response::json($output);
    }

    public function room_transfer(){
        $temp                   = Input::all();
        // $tempRaw            = $temp['room_transfer'];
        // $order_id           = $temp['order_id'];
        // $roomObj            = json_decode($tempRaw);

        $order_id               = $temp['order_id'];
        $transfer_from_room_id  = $temp['transfer_from_room_id'];
        $transfer_to_room_id    = $temp['transfer_to_room_id'];       
       
        $from_room              = Room::find($transfer_from_room_id);
        $from_room->status      = 0;
        $from_room->save();

        $to_room                = Room::find($transfer_to_room_id);
        $to_room->status        = 1;
        $to_room->save();

        /*
        $order_room             = OrderRoom::where('order_id','=',$order_id)->where('room_id','=',$transfer_from_room_id)->first();
        $order_room->order_id   = $order_id;
        $order_room->room_id    = $transfer_to_room_id;
        $order_room->save();*/

        OrderRoom::where('order_id','=',$order_id)
                    ->where('room_id','=',$transfer_from_room_id)
                    ->update(['room_id'=> $transfer_to_room_id]);

        $output                 = array("message" => "Success");
        return Response::json($output);
    }

    public function member_update(){
        $temp                   = Input::all();
        $voucher_no             = $temp['voucher_no'];
        $member_id              = $temp['member_id'];
        $member_discount_amount = $temp['discount_amount'];
        $pay_amount             = $temp['pay_amount'];
        $refund                 = $temp['refund'];
        $total_price            = $temp['total_amount'];
        $service_amount         = $temp['service_amount'];
        $tax_amount             = $temp['tax_amount'];
        $all_total_amount       = $temp['all_total_amount'];
        $foc_amount             = isset($temp['foc_amount'])?$temp['foc_amount']:0;
        $foc_description        = isset($temp['foc_description'])?$temp['foc_description']:null;

        if($member_id == 'null'){
            $order                      = Order::where('id','=',$voucher_no)->first();
            $order->member_id           = 'null';
            $order->member_discount     = 0;
            $order->status              = 1;
            $order->payment_amount      = $pay_amount;
            $order->refund              = $refund;
            $order->total_price_foc     = $total_price;
            $order->service_amount      = $service_amount;
            $order->tax_amount          = $tax_amount;
            $order->all_total_amount    = $all_total_amount;
            $order->foc_amount          = $foc_amount;
            $order->foc_description     = $foc_description;
            $order->save();

        }
        else{
            $member_discount = Member::where('id', '=', $member_id)->first();
            $member_type_id = MemberType::where('id', '=', $member_discount->member_type_id)->first();
            $order                          = Order::where('id', '=', $voucher_no)->first();
            
            $order->member_id               = $member_id;
            $order->member_discount         = $member_type_id->discount_amount;
            $order->member_discount_amount  = $member_discount_amount;
            $order->status                  = 1;
            $order->payment_amount          = $pay_amount;
            $order->refund                  = $refund;
            $order->total_price_foc         = $total_price;
            $order->service_amount          = $service_amount;
            $order->tax_amount              = $tax_amount;
            $order->all_total_amount        = $all_total_amount;
            $order->foc_amount              = $foc_amount;
            $order->foc_description         = $foc_description;
            $order->save();
        }
        $order_detail     = Orderdetail::where('order_id','=',$voucher_no)->get();
        foreach($order_detail as $detail){
            if($detail->status_id == 6 || $detail->status_id == 7){
                $detail->deleted_at = date('Y-m-d H:m:i');
                $detail->save();
            }else{
                $detail->status_id = 5;
                $detail->save();
            }

        }
        $order_table      = OrderTable::where('order_id','=',$voucher_no)->get();
        foreach($order_table as $table){
            $t = Table::where('id','=',$table->table_id)->first();
            $t->status = 0;
            $t->save();
        }

        $order_room = OrderRoom::where('order_id','=',$voucher_no)->get();
        foreach($order_room as $room){
            $r = Room::where('id','=',$room->room_id)->first();
            $r->status = 0;
            $r->save();
        }
        $output           = array("message"=>"Success");
        return Response::json($output);
        /*
        if($member_id == 'null'){

            $order                      = Order::where('id','=',$voucher_no)->first();
            $order->member_id           = 'null';
            $order->member_discount     = 'null';
            $order->status              = 1;
            $order->payment_amount      = $pay_amount;
            $order->refund              = $refund;
            $order->total_price         = $total_price;
            $order->service_amount      = $service_amount;
            $order->tax_amount          = $tax_amount;
            $order->all_total_amount    = $all_total_amount;
            $order->foc_amount          = $foc_amount;
            $order->foc_description     = $foc_description;
            $order->save();

            $order_detail     = Orderdetail::where('order_id','=',$voucher_no)->get();
            foreach($order_detail as $detail){
                if($detail->status_id == 6 || $detail->status_id == 7){
                    $detail->deleted_at = date('Y-m-d H:m:i');
                    $detail->save();
                }else{
                    $detail->status_id = 5;
                    $detail->save();
                }
                
            }

            $order_table      = OrderTable::where('order_id','=',$voucher_no)->get();
            foreach($order_table as $table){
                $t = Table::where('id','=',$table->table_id)->first();
                $t->status = 0;
                $t->save();
            }    

            $order_room = OrderRoom::where('order_id','=',$voucher_no)->get();
            foreach($order_room as $room){
                $r = Room::where('id','=',$room->room_id)->first();
                $r->status = 0;
                $r->save();
            }    
            
        }else {
            $order = Order::where('id', '=', $voucher_no)->first();
            $member_discount = Member::where('id', '=', $member_id)->first();
            $member_type_id = MemberType::where('id', '=', $member_discount->member_type_id)->first();
            $discount_amount = ($order->total_price * $member_type_id->discount_amount) / 100;
            $order->member_id = $member_id;
            $order->member_discount = $member_type_id->discount_amount;
            $order->member_discount_amount = $discount_amount;

            $total = $order->total_price - $discount_amount;
            $t_amount = ($total * 10) / 100;
            $s_amount = ($total * 10) / 100;

            $order->tax_amount = ($total * 10) / 100;
            $order->service_amount = ($total * 10) / 100;

            $order->all_total_amount = $total + $t_amount + $s_amount;
            $order->status = 1;
            $order->payment_amount = $pay_amount;
            $order->refund = $refund;
            $order->foc_amount = $foc_amount;
            $order->foc_description = $foc_description;
            $order->save();

            $order_detail = Orderdetail::where('order_id', '=', $voucher_no)->get();
            foreach ($order_detail as $detail) {
                $detail->status_id = 5;
                $detail->save();
            }

            $order_table = OrderTable::where('order_id', '=', $voucher_no)->get();
            foreach ($order_table as $table) {
                $t = Table::where('id', '=', $table->table_id)->first();
                $t->status = 0;
                $t->save();
            }

            $order_room = OrderRoom::where('order_id', '=', $voucher_no)->get();
            foreach ($order_room as $room) {
                $r = Room::where('id', '=', $room->room_id)->first();
                $r->status = 0;
                $r->save();
            }

        }*/

    }

    public function order_status(){

        $orderRaw      = Orderdetail::leftjoin('order','order.id','=','order_details.order_id')
            ->select('order.id as voucher_no')
            ->where('order_details.status_id','=',3)->orwhere('order_details.status_id','=',2)->orwhere('order_details.status_id','=',6)
            ->groupBy('order_details.order_id')
            ->get()->toArray();

        $voucherArray = array();
        if(isset($orderRaw) && count($orderRaw)>0){
            foreach($orderRaw as $orderObj){
                array_push($voucherArray,$orderObj['voucher_no']);
            }
        }

        $orders     = Order::leftjoin('order_tables','order.id','=','order_tables.order_id')
            ->leftjoin('tables','tables.id','=','order_tables.table_id')
            ->leftjoin('order_room','order.id','=','order_room.order_id')
            ->leftjoin('rooms','rooms.id','=','order_room.room_id')
            ->select('order.id as voucher_no','tables.table_no as table_name','rooms.room_name')
            ->whereIn('order.id',$voucherArray)
            ->get()->toArray();

        // $orderDetails      = Orderdetail::leftjoin('order','order.id','=','order_details.order_id')
        //     ->leftjoin('items','items.id','=','order_details.item_id')
        //     ->leftjoin('order_setmenu_detail','order_setmenu_detail.order_detail_id','=','order_details.id')
        //     ->leftjoin('set_menu','set_menu.id','=','order_setmenu_detail.setmenu_id')
        //     ->leftjoin('order_type','order_type.id','=','order_details.order_type_id')
        //     ->select('items.name as item_name','set_menu.set_menus_name','order_details.id','order_details.order_id','order_details.order_detail_id','order_type.type as order_type','order_details.status_id as status','order_details.cooking_time','order_details.message','order_setmenu_detail.item_id as set_item_id','order_details.cancel_status')
        //     ->where('order_details.status_id','=',3)
        //     //->orwhere('order_details.status_id','=',2)
        //     ->orwhere('order_details.status_id','=',6)
        //     ->orwhere('order_setmenu_detail.status_id','=',3)
        //     //->orwhere('order_setmenu_detail.status_id','=',2)
        //     ->orwhere('order_setmenu_detail.status_id','=',6)
        //     ->where('order_details.cancel_status',NULL)
        //     ->where('order_details.waiter_status',NULL)
        //     ->orwhere('order_setmenu_detail.cancel_status',NULL)
        //     ->where('order_setmenu_detail.waiter_status',NULL)            
        //     ->get()->toArray(); 

        $getOrderDetails     = DB::select("SELECT i.name as item_name,sm.set_menus_name,od.id,od.order_id,od.order_detail_id,ot.type as order_type, od.status_id as status,od.cooking_time,od.message,osd.item_id as set_item_id,od.cancel_status FROM order_details as od  LEFT JOIN items as i ON i.id = od.item_id LEFT JOIN order_setmenu_detail as osd ON osd.order_detail_id = od.id LEFT JOIN set_menu as sm ON sm.id = osd.setmenu_id LEFT JOIN order_type as ot ON ot.id = od.order_type_id WHERE od.status_id = 3 OR od.status_id = 6 OR osd.status_id = 3 OR osd.status_id = 6 AND od.cancel_status = NULL OR od.waiter_status = NULL OR osd.cancel_status = NULL OR osd.waiter_status = NULL  ");
        $orderDetails = array();
        foreach($getOrderDetails as $order){

            if($order->cancel_status != 'Yes'){
                array_push($orderDetails,$order);
            }
        }

        $result = array();
        if(isset($orders) && count($orders)>0) {
            foreach ($orders as $orderKey => $orderArr) {

                $result[$orderKey] = $orderArr;
            }
        }

        foreach($result as $key => $orderArr2) {

            $tempOrderDetailArray = array();
            $keyOrderIndex = $orderArr2['voucher_no'];

            foreach($orderDetails as $orderDetail) {
                $orderDetailVoucherId = $orderDetail->order_id;
                if($keyOrderIndex == $orderDetailVoucherId){
                    
                    array_push($tempOrderDetailArray,$orderDetail);
                }
            
            }
            $result[$key]['product_list'] = $tempOrderDetailArray;
        }
        $list = array();
        foreach($result as $r){
            if($r['product_list'] != NULL){
                array_push($list,$r);
            }
        }
        $tempArray = array();

        $tempArray['order_status'] = $list;
        return Response::json($tempArray);
    }


    public function take(){
        $temp               = Input::all();
        $tempRaw            = $temp['take'];
        $take               = json_decode($tempRaw);
        $waiter_id          = $take->waiter_id;
        $order_detail_ids   = $take->order_detail_id;
        
        foreach($order_detail_ids as $order_detail_id){

            if($order_detail_id->set_id == "null"){
                $order_details                  = Orderdetail::where('id',$order_detail_id->detail_id)->first();

                $order_details->status_id       = 4;
                $order_details->waiter_id       = $waiter_id;
                $order_details->waiter_status   = "take";
                $order_details->save();
            }else{
    
                $order_setmenu_detail = OrderSetMenuDetail::where('order_detail_id','=',$order_detail_id->detail_id)
                ->where('setmenu_id','=',$order_detail_id->set_id)
                ->where('item_id','=',$order_detail_id->set_item_id)->first();   

                $order_setmenu_detail->status_id = 4;
                $order_setmenu_detail->waiter_id = $waiter_id;
                $order_setmenu_detail->waiter_status = "take";
                $order_setmenu_detail->save();
                //if all item from set menu is taken by waiter, then change status_id in order_detail.
                $order_setmenu_without_status   = DB::table('order_setmenu_detail')
                    ->where('order_detail_id',$order_detail_id->detail_id)
                    ->where('setmenu_id',$order_detail_id->set_id)
                    ->get();
                $count_without_status           = count($order_setmenu_without_status);

                $order_setmenu_with_status      = DB::table('order_setmenu_detail')
                    ->where('order_detail_id',$order_detail_id->detail_id)
                    ->where('setmenu_id',$order_detail_id->set_id)
                    ->where('status_id','=',4)
                    ->get();
                $count_with_status              = count($order_setmenu_with_status);

                if($count_with_status == $count_without_status){
                    DB::statement('update order_details set status_id =4 where id=?',[$order_detail_id->detail_id]);
                }

            }
        }
        
        $output             = array("message" => "Success");
        return Response::json($output);
    }

    public function check_cancel_status(){
        $temp            = Input::all();
        $tempRaw         = $temp['cancel'];
        $cancel          = json_decode($tempRaw);
        //$voucher_no      = $cancel->voucher_no;
        $order_detail_id = $cancel->order_detail_id;

        $order_detail = Orderdetail::where('order_detail_id',$order_detail_id)->first();
        if($order_detail->status_id == 6){
             $order_detail->cancel_status = "true";
             $order_detail->save();
             $output = array("message" => "Success");
             return Response::json($output);
        }else{
            $output = array("message" => "Fail");
            return Response::json($output);
        }
    }
    
    public function customer_cancel(){
        $tempObj            = Input::all();
        $orderRaw           = $tempObj['customer_cancel'];
        $order              = json_decode($orderRaw);
        $order_detail_id    = $order->order_detail_id;
        $id                 = $order->order_id;
        $total_price        = $order->total_amount;
        $service_amount     = $order->service_amount;
        $tax_amount         = $order->tax_amount;
        $all_total_amount   = $order->net_amount;

        $orderObj           = Orderdetail::where('order_detail_id','=',$order_detail_id)
            ->where('order_id','=',$id)->first();
        
            if($orderObj->status_id == 2){
                $output = array("message" => "Fail To Cancel");
            }
            else{
                $Obj                    = Order::where('id','=',$id)->first();
                $Obj->total_price       = $total_price;
                $Obj->service_amount    = $service_amount;
                $Obj->tax_amount        = $tax_amount;
                $Obj->all_total_amount  = $all_total_amount;
                $Obj->save();
                
                $orderObj->status_id    = 7;
                $orderObj->remark       = "Cancel By Custmer";
                $orderObj->save();

                $output = array("message"=>"Success");
            }
        
        
        return Response::json($output);
    }

    public function post_kitchen_cancel(){
        $tempObj            = Input::all();
        $orderRaw           = $tempObj['kitchen_cancel'];
        $details            = json_decode($orderRaw);

        foreach($details as $detail)
        {
        $orderObj           = Orderdetail::where('order_detail_id','=',$detail->detail_id)->first();
        
        if($orderObj->status_id == 6){
            $Obj                = Orderdetail::where('id','=',$orderObj->id)->first();
            $Obj->cancel_status = 'Yes';
            $Obj->save();

            $output = array("message"=>"Success");
        }else{

            $output = array("message"=>"Failed");
        }
        }
        
        return Response::json($output);
    }

}

