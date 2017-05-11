<?php
namespace App\RMS\Invoice;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Category\Category;
use App\RMS\OrderExtra\OrderExtra;

class InvoiceRepository implements InvoiceRepositoryInterface
{

	public function getinvoice( )
	{
		
		$orders = DB::select("select `id`, `total_price`,`member_discount`,`service_amount`,`tax_amount`,`all_total_amount`, `created_at`,`payment_amount`
		from `order` where `deleted_at` is null order by `order_time` desc");
		
		return $orders;
	}

	public function getorder($id)
	{
		$orders = Order::select('id as order_id','service_amount','tax_amount','order_time','member_discount','member_discount_amount','member_id','total_price','total_extra_price','all_total_amount','payment_amount','total_discount_amount','refund','total_price_foc')->where('id',$id)->first();
		
		return $orders;
	}

	public function getdetail($id){
		$order_details = Orderdetail::leftjoin('order','order_details.order_id','=','order.id')
		->leftjoin('items','items.id','=','order_details.item_id')
		->leftjoin('order_extra','order_extra.order_detail_id','=','order_details.id')
		->leftjoin('set_menu','set_menu.id','=','order_details.setmenu_id')
		->leftjoin('users','users.id','=','order.user_id')
		->select('items.name as item_name','set_menu.set_menus_name as set_name','order_details.quantity','order_details.discount_amount','order_details.amount','order_details.id as order_detail_id','order_extra.amount as order_extra','users.user_name','order.id',
			'order_details.amount_with_discount')->where('order_id','=',$id)
		->whereNotIn('status_id',[6,7])->get();
		return $order_details;
		
	}

	public function cashier($id){
		$cashier = Order::where('id','=',$id)->first();

		return $cashier;
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

	public function getaddon($id){
		$order_details = Orderdetail::where('order_id','=', $id)->where('deleted_at','=',NULL)->get();
		$addon = array();
		foreach($order_details as $order){
			$tempAddon = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')->select('order_extra.*','add_on.food_name')->where('order_extra.order_detail_id','=',$order->id)->where('order_extra.deleted_at','=',NULL)->get()->toArray();
			array_push($addon, $tempAddon);
			
		}
		
		return $addon;
	}

	public function getaddonAmount($id){
		$order_details = Orderdetail::where('order_id','=', $id)->where('deleted_at','=',NULL)->get();
		$addon = array();
		foreach($order_details as $order){
			$tempAddon = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')->select('order_extra.*',DB::raw('SUM(order_extra.amount) as amount'),'add_on.food_name')->where('order_extra.order_detail_id','=',$order->id)->where('order_extra.deleted_at','=',NULL)->groupBy('order_extra.order_detail_id')->get()->toArray();
			array_push($addon, $tempAddon);
			
		}
		
		return $addon;
	}

	public function addpaid($id) {
		DB::table('order')
				->where('id',$id)
				->update(['status'=>5,'payment_amount']);
	}
	

}