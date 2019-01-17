<?php
namespace App\RMS\Reports_update\BestSellingSet;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\MemberType\MemberType;
use Illuminate\Support\Facades\DB;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\Status\StatusConstance;
class BestSellingSetRepository implements BestSellingSetRepositoryInterface
{
	public function bestItem($from_date =null ,$to_date=null,$number=null,$from_amount =null,$to_amount =null){
		
        $order_paid_status           = StatusConstance::ORDER_PAID_STATUS;
        $kitchen_cancel              = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        $customer_cancel             = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
        $from 						           = date('Y-m-d',strtotime($from_date));
        $to 						             = date('Y-m-d',strtotime($to_date));	
		 $query  		=Orderdetail::query();
		 $query	 		= $query->join('items','items.id','=','order_details.item_id')
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
                        ->where('order_details.item_id','!=',0)
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
        if($number 		 	!= "" && $number !=' '){
        	$query 				= $query->take($number);

        }
        $order 					= $query->get();
        // dd($order);
        return $order;
		
	}	

  public function best_set($from_date,$to_date,$number=null,$from_amount=null,$to_amount=null){
    $order_paid_status           = StatusConstance::ORDER_PAID_STATUS;
    $kitchen_cancel              = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
    $customer_cancel             = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
    $from                        = date('Y-m-d',strtotime($from_date));
    $to                          = date('Y-m-d',strtotime($to_date));

    $query                       = Orderdetail::query();
    $query                       = $query->join('set_menu', 'set_menu.id', '=', 'order_details.setmenu_id')
                                ->join('order', 'order.id', '=', 'order_details.order_id')
                                ->join('status','status.id','=','order_details.status_id')
                                ->join('order_day','order.day_id','=','order_day.id')
                               ->select('set_menu.set_menus_name as Name',DB::raw('SUM(order_details.quantity) as Quantity'),'order_details.amount as Price',DB::raw('SUM(order_details.amount_with_discount) as TotalAmount'))
                                ->where('order_day.start_date','>=',$from)
                                ->where('order_day.start_date','<=',$to)                                
                                ->where('order_details.setmenu_id','!=',0)
                                ->where('order.status','=',$order_paid_status)
                                ->where('order.deleted_at',NULL)
                                ->whereNotIn('order_details.status_id',[$kitchen_cancel,$customer_cancel])
                                ->whereNotNull('order_details.setmenu_id');
    if($from_amount != ""){           
        $query        = $query->where('order_details.amount_with_discount','>=',$from_amount);
      }
    if($to_amount   !=""){
    
      $query        = $query->where('order_details.amount_with_discount','<=',$to_amount);
    }

    $query          = $query->groupBy('order_details.setmenu_id')
                            ->orderBy('Quantity','desc');
    if($number      != "" && $number !=' '){
      $query        = $query->take($number);

    }
    $set_item        = $query->get();
    return $set_item;                           


  }
}