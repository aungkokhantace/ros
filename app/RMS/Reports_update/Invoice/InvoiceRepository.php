<?php
namespace App\RMS\Reports_update\Invoice;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\Table\Table;
use App\RMS\Room\Room;
use App\RMS\Transactiontender\Postender;
use App\RMS\Transactiontender\Transactiontender;
use App\RMS\Utility;
use App\Status\StatusConstance;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use App\RMS\Category\Category;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\Payment\Payment;
use App\RMS\Item\Continent;
use App\RMS\ReturnMessage;
use App\RMS\Config\Config;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getorder($id)
    {
        /* modify in here */
        $orders         = Order::select('id as order_id','service_amount','tax_amount','order_time','member_discount','member_discount_amount','member_id','total_extra_price','over_all_discount','room_charge','status','sub_total','total_price as NetAmount','all_total_amount as Amount','payment_amount as cash_receive','refund as change')
                        ->where('id',$id)
                        ->first();
       
        return $orders;
    }

    public function getaddon($id){
        $status         = StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
        $order_details = Orderdetail::where('order_id','=', $id)->where('deleted_at','=',NULL)->get();    
        $addon = array();
        foreach($order_details as $order){
            // dd($order->id,$order->order_detail_id,$id);
            $tempAddon = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')
                        ->select('order_extra.*','add_on.food_name')
                        ->where('order_extra.order_detail_id','=',$order->order_detail_id)
                        ->where('order_extra.status','=',$status)
                        ->where('order_extra.deleted_at','=',NULL)
                        ->get()->toArray();

            array_push($addon, $tempAddon);            
            
        }        
        return $addon;
    }

    public function getaddonAmount($id){
        $status         = StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
        $order_details = Orderdetail::where('order_id','=', $id)->where('deleted_at','=',NULL)->get();
        $addon = array();
        foreach($order_details as $order){
            $tempAddon = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')->select('order_extra.*',DB::raw('SUM(order_extra.amount) as amount'),'add_on.food_name')->where('order_extra.order_detail_id','=',$order->id)->where('order_extra.status','=',$status)->where('order_extra.deleted_at','=',NULL)->groupBy('order_extra.order_detail_id')->get()->toArray();
            array_push($addon, $tempAddon);
            
        }
        
        return $addon;
    }

    public function getContinent() {
        $continent  = Continent::select('id','name')->get();
        return $continent;
    }

    public function getdetail($id){
        $order_kitchen_cancel_status    = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        $order_customer_cancel_status   = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;

        $order_details                  = Orderdetail::leftjoin('order','order_details.order_id','=','order.id')
        ->leftjoin('items','items.id','=','order_details.item_id')
        ->leftjoin('set_menu','set_menu.id','=','order_details.setmenu_id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->select('items.name as item_name','items.has_continent','items.continent_id','set_menu.set_menus_name as set_name','order_details.quantity',
                'order_details.discount_amount','order_details.amount','order_details.id as order_detail_id',
                'users.user_name','order.id','order_details.amount_with_discount','order.over_all_discount as Discount','tax_amount as Tax','order.service_amount as Service','order.room_charge as Room','order.sub_total','order.total_price as NetAmount','all_total_amount as Amount','order.payment_amount as rename ','order.refund as change')
        ->where('order_id','=',$id)
        ->whereNotIn('status_id',[$order_kitchen_cancel_status,$order_customer_cancel_status])->get();
        return $order_details;
        
    }                                     

     public function orderTable($id){
        $tables = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
        ->select('order_tables.table_id','order_tables.order_id','tables.table_no')->where('order_tables.order_id','=',$id)->get();

        return $tables;
    }

      public function orderRoom($id){
        $rooms = OrderRoom::leftjoin('rooms','rooms.id','=','order_room.room_id')
        ->select('order_room.room_id','order_room.order_id','rooms.room_name')->where('order_room.order_id','=',$id)->get();
      
        return $rooms;
    }

    public function cashier($id){
        $cashier = Order::where('id','=',$id)->first();

        return $cashier;
    }

    public function config(){
        $config     = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        return $config;
    }

   

     
}