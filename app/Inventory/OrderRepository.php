<?php
namespace App\inventory;
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
use App\Inventory\OrderRepositoryInterface;
use App\Status\StatusConstance;

class OrderRepository implements OrderRepositoryInterface
{
    
    public function getOrderById($id){
        $orders = DB::table('order')->where('order.id',$id)->join('users','order.user_id','=','users.id')->select('order.*','users.staff_id as staff_id')->first();
        return $orders;
    }


    public function getOrderDetail($order_id){
        $order_details = DB::table('order_details')->where('order_id',$order_id)->join('items','order_details.item_id','=','items.id')->select('items.stock_code as StockId','order_details.quantity as Quantity','order_details.amount as SellingPrice','order_details.discount_amount as Discount')->get();
        return $order_details;
    }
    
    
}