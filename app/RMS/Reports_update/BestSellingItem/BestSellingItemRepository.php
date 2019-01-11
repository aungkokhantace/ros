<?php
namespace App\RMS\Reports_update\BestSellingItem;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\MemberType\MemberType;
use Illuminate\Support\Facades\DB;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\Status\StatusConstance;
class BestSellingItemRepository implements BestSellingItemRepositoryInterface
{
	public function bestItem($from_date =null ,$to_date=null,$number=null,$from_amount =null,$to_amount =null){
		
        $order_paid_status           = StatusConstance::ORDER_PAID_STATUS;
        $kitchen_cancel              = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        $customer_cancel             = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
        $from 						 = date('Y-m-d',strtotime($from_date));
        $to 						 = date('Y-m-d',strtotime($to_date));	
		 $query  		=Orderdetail::query();
		 $query	 		= $query->leftjoin('items','items.id','=','order_details.item_id')
		    					->leftjoin('order', 'order.id', '=', 'order_details.order_id')
		 						->leftjoin('order_day','order_day.id','=','order.day_id')
		 						->select('items.name as name','order_details.amount',DB::raw('(SUM(order_details.quantity)*(order_details.discount_amount)) as discount_amount'),DB::raw('SUM(order_details.quantity) as total'),
                				DB::raw('(SUM(order_details.amount_with_discount)) as price'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as total_amt'), DB::raw('SUM(order_details.amount_with_discount) as net_price'))
                				->where('order_day.start_date','>=',$from)
                				->where('order_day.start_date','<=',$to)
                				->where('order.status','=',$order_paid_status)
                				->whereNull('order.deleted_at')
                				->whereNotIn('order_details.status_id',[$kitchen_cancel,$customer_cancel])
                				->whereNotNull('order_details.item_id')
                				->groupBy('order_details.item_id')
                				->orderBy('total','desc');
                				// ->orderBy('name','desc');
             // dd($from_amount);
          if($from_amount != ""){
          	// var_dump($from_amount);
          	// die();
          	// dd($from_amount);
          	$query 				= $query->having('total_amt','>=',$from_amount);
          }
          if($to_amount 	!=""){
          
          	$query 				= $query->having('total_amt','<=',$to_amount);
          }
        if($number 		 	!= ""){
        	$query 				= $query->take($number);

        }
        $order 					= $query->get();
        // dd($order);
        return $order;
		
	}	
}