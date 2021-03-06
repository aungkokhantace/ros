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

class OrderRepository implements OrderRepositoryInterface
{
    public function getVoucher(){
        $orders = Orderdetail::
        leftjoin('order','order_details.order_id','=','order.id')
        ->leftjoin('order_type','order_type.id','=','order_details.order_type_id')
        ->leftjoin('items','items.id','=','order_details.item_id')
        ->leftjoin('set_menu','set_menu.id','=','order_details.setmenu_id')
        ->leftjoin('category','category.id','=','items.category_id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->select('order.take_id','order_details.order_id','order_type.type as order_type','set_menu.set_menus_name','items.name','order_details.order_time','order_details.item_id','order_details.setmenu_id','order_details.status_id as order_status','order_details.exception','order_details.id as order_details_id','order_details.order_duration')
        ->where(function($query){
            $query->where('order_details.status_id','=',1)->orwhere('order_details.status_id','=',2)
            ->orwhere('order_details.status_id','=',3)->orwhere('order_details.status_id','=',4);
           
        })->get();
       
        return $orders;
    }

    public function getInvoice($id){
        $orders = Orderdetail::
        leftjoin('order','order_details.order_id','=','order.id')
        ->leftjoin('order_type','order_type.id','=','order_details.order_type_id')
        ->leftjoin('items','items.id','=','order_details.item_id')
        ->leftjoin('order_setmenu_detail','order_setmenu_detail.order_detail_id','=','order_details.id')
        ->leftjoin('category','category.id','=','items.category_id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->select('order.take_id','order_details.order_id','order_type.type as order_type','items.name','order_details.order_time','order_details.quantity','order_details.item_id','order_details.setmenu_id','order_details.status_id as order_status','order_details.exception','order_details.id as order_details_id','order_details.order_duration','order_details.remark')
        ->where(function($query){
            $query->where('order_details.status_id','=',1)->orwhere('order_details.status_id','=',2);
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
        $extras = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')->select('order_extra.order_detail_id','order_extra.extra_id','order_extra.quantity','order_extra.amount','add_on.food_name')->get();

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
    
    
}