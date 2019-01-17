<?php
namespace App\RMS\Order;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Category\Category;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\OrderSetMenuDetail\OrderSetMenuDetail;
use App\RMS\Kitchen\Kitchen;
use App\RMS\Utility;
use App\RMS\ReturnMessage;
use App\Status\StatusConstance;

class OrderRepository implements OrderRepositoryInterface
{
    public function getVoucher(){
        //Status Lists
        $order_status                      = StatusConstance::ORDER_CREATE_STATUS;
        $order_detail_cooking_status       = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $order_detail_cooked_status        = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        $order_detail_cooking_done_status  = StatusConstance::ORDER_DETAIL_COOKING_DONE_STATUS;
        $order_detail_delievered_status    = StatusConstance::ORDER_DETAIL_DELIEVERED_STATUS;

        $orders = Orderdetail::
        leftjoin('order','order_details.order_id','=','order.id')
        ->leftjoin('order_type','order_type.id','=','order_details.order_type_id')
        ->leftjoin('items','items.id','=','order_details.item_id')
        ->leftjoin('set_menu','set_menu.id','=','order_details.setmenu_id')
        ->leftjoin('category','category.id','=','items.category_id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->select('order.take_id','order.status','order_details.order_id','order_type.type as order_type','set_menu.set_menus_name','items.name','order_details.order_time','order_details.item_id','order_details.setmenu_id','order_details.status_id as order_status','order_details.exception','order_details.id as order_details_id','order_details.order_duration')
        ->where(function($query) use
        ($order_status,$order_detail_cooking_status,$order_detail_cooked_status,$order_detail_cooking_done_status,$order_detail_delievered_status) {
            $query->where('order.status', '=',$order_status)->where('order_details.status_id','=',$order_detail_cooking_status)->orwhere('order_details.status_id','=',$order_detail_cooked_status)
            ->orwhere('order_details.status_id','=',$order_detail_cooking_done_status)
            ->orwhere('order_details.status_id','=',$order_detail_delievered_status);

        })
        ->orderBy('order.created_at', 'desc')
        ->get();

        return $orders;
    }

    public function getInvoice($id){
        $order_detail_cooking_status       = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $order_detail_cooked_status        = StatusConstance::ORDER_DETAIL_COOKED_STATUS;

        $orders = Orderdetail::
        leftjoin('order','order_details.order_id','=','order.id')
        ->leftjoin('order_type','order_type.id','=','order_details.order_type_id')
        ->leftjoin('items','items.id','=','order_details.item_id')
        ->leftjoin('order_setmenu_detail','order_setmenu_detail.order_detail_id','=','order_details.id')
        ->leftjoin('category','category.id','=','items.category_id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->select('order.take_id','order_details.order_id','order_type.type as order_type','items.name','order_details.order_time','order_details.quantity','order_details.item_id','order_details.setmenu_id','order_details.status_id as order_status','order_details.exception','order_details.id as order_details_id','order_details.order_duration','order_details.remark')
        ->where(function($query) use ($order_detail_cooking_status,$order_detail_cooked_status) {
            $query->where('order_details.status_id','=',$order_detail_cooking_status)->orwhere('order_details.status_id','=',$order_detail_cooked_status);
        })
        ->where(function($query) use($id){
            $query->where('category.kitchen_id','=',$id);
            })->get();
       //dd($orders);
        return $orders;
    }



    public function orderTable(){
        $tables = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
        ->select('order_tables.table_id','order_tables.order_id','tables.table_no')->get();

        return $tables;
    }

    public function orderRoom(){
        $rooms = OrderRoom::leftjoin('rooms','rooms.id','=','order_room.room_id')
        ->select('order_room.room_id','order_room.order_id','rooms.room_name')->get();

        return $rooms;
    }

    public function orderExtra(){
        $status 			= StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
        $extras = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')->select('order_extra.order_detail_id','order_extra.extra_id','order_extra.quantity','order_extra.amount','add_on.food_name')
        ->where('order_extra.status','=',$status)
        ->whereNull('order_extra.deleted_at')
        ->get();

        return $extras;
    }

    public function getFoodListDetail($order_id,$order_status){
        $orders = Orderdetail::
        leftjoin('order','order_details.order_id','=','order.id')
        ->leftjoin('order_type','order_type.id','=','order_details.order_type_id')
        ->leftjoin('items','items.id','=','order_details.item_id')
        ->leftjoin('set_menu','set_menu.id','=','order_details.setmenu_id')

        ->select('order.take_id','order_details.order_id','order_type.type as order_type','set_menu.set_menus_name','items.name','order_type.type as order_type','order_details.item_id','order_details.setmenu_id')
        ->where('order_details.order_id',$order_id)
        ->where('order_details.status_id',$order_status)
        ->get();
        return $orders;
    }

    public function getOrderById($id){
        $orders = DB::table('order')->where('id',$id)->first();
        return $orders;
    }
    public function save($Order){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $Order->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getwillpayOrder(){
        $result  = DB::table('order')->where('will_pay',1)->where('status',1)->get();
        return $result;
    }

    public function getOrderTable($order_id){
        $result = DB::table('order_tables')->where('order_id',$order_id)->join('tables','order_tables.table_id','=','tables.id')->select('tables.table_no')->get();
        return $result;
    }

    public function getOrderRoom($order_id){
        $result = DB::table('order_room')->where('order_id',$order_id)->join('rooms','order_room.room_id','=','rooms.id')->select('rooms.room_name')->get();
        return $result;
    }

    public function getOrderTableWithLocation()
    {
        return DB::table('order_tables')
            ->join('tables','order_tables.table_id','=','tables.id')
            ->join('locations', 'tables.location_id', '=', 'locations.id')
            ->select('order_tables.table_id','order_tables.order_id','tables.table_no', 'locations.location_type')
            ->get();
    }

}
