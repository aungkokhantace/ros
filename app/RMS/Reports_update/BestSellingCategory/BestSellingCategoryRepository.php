<?php
namespace App\RMS\Reports_update\BestSellingCategory;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\MemberType\MemberType;
use Illuminate\Support\Facades\DB;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\Status\StatusConstance;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/18/2016
 * Time: 9:35 AM
 */
class BestSellingCategoryRepository implements BestSellingCategoryRepositoryInterface
{
  public function BestSetCategory($from_date,$to_date,$number=null){
  	$order_paid_status           = StatusConstance::ORDER_PAID_STATUS;
    $kitchen_cancel              = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
    $customer_cancel             = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
    $from 						 = date('Y-m-d',strtotime($from_date));
    $to 						 = date('Y-m-d',strtotime($to_date));	

  	$query 						= Category::query();
  	$query 						= $query->join('items', 'category.id', '=', 'items.category_id')
	            				->join('order_details', 'items.id', '=', 'order_details.item_id')
	            				->join('order', 'order_details.order_id', '=', 'order.id')
	            				->join('order_day','order_day.id','=','order.day_id')
	            				->select(
	            				'order_details.order_detail_id',
				                'category.id as category_id',
				                'category.name as category_name',
				                'items.name as item_name',
				                'order_details.quantity as quantity',
				                'order_details.amount_with_discount as amount',
				                'category.parent_id',
				                'order_details.item_id as iem_id'

				            	)
	            				->where('order_day.start_date','>=',$from)
	            				->where('order_day.start_date','<=',$to)
	            				->where('order.status','=',$order_paid_status)
	            				->whereNull('order.deleted_at')
	            				->whereNotIn('order_details.status_id',[$kitchen_cancel,$customer_cancel]);
	            				
                	// 			->groupBy('category.id');
   $orders 						= $query->get();
   return $orders;
   // dd($orders);
  }
   public function getParentCategory($parent_id)
    {
        return DB::table('category')
            ->where('id', '=', $parent_id)
            ->select('id','name','parent_id')
            ->first();
    }

    public function BestSetCategory_test($from_date,$to_date,$number=null){
  	$order_paid_status           = StatusConstance::ORDER_PAID_STATUS;
    $kitchen_cancel              = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
    $customer_cancel             = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
    $from 						 = date('Y-m-d',strtotime($from_date));
    $to 						 = date('Y-m-d',strtotime($to_date)); 	

    $category 						= DB::table('category as e')
    								->leftjoin('category as m','m.id','=','e.parent_id')
    								->leftjoin('items','items.category_id','=','e.id')
    								->leftjoin('order_details','order_details.item_id','=','items.id')
    								->leftjoin('order','order.id','=','order_details.order_id')
    								->leftjoin('order_day','order_day.id','=','order.day_id')
    								->select(DB::raw("CONCAT(e.parent_id,e.name) AS Category"),
    										DB::raw("CONCAT(m.parent_id,m.name) as ParentCategory"),
    										DB::raw('SUM(order_details.quantity) as Quantity'),
    										DB::raw('SUM(order_details.amount_with_discount) as total'))
    								// ->where('order_day.start_date','>=',$from)
    								// ->where('order_day.start_date','<=',$to)
    								// ->where('order.status','=',$order_paid_status)
	           //  					->whereNull('order.deleted_at')
	           //  					->whereNotIn('order_details.status_id',[$kitchen_cancel,$customer_cancel])
    								->groupBy('e.id')->get();
    return $category;
    // dd($category);

  }

  public function BestSetbyCategory($cate_id,$from_date,$to_date){
  	$order_paid_status           = StatusConstance::ORDER_PAID_STATUS;
    $kitchen_cancel              = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
    $customer_cancel             = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
    $from 						           = date('Y-m-d',strtotime($from_date));
    $to 						             = date('Y-m-d',strtotime($to_date));	

  	$query 						= Category::query();
  	$query 						= $query->join('items', 'category.id', '=', 'items.category_id')
	            				->join('order_details', 'items.id', '=', 'order_details.item_id')
	            				->join('order', 'order_details.order_id', '=', 'order.id')
	            				->join('order_day','order_day.id','=','order.day_id')
	            				->select(
	            				'order_details.order_detail_id',
				                'category.id as category_id',
				                'category.name as category_name',
				                'items.name as item_name',
				                'order_details.quantity as quantity',
				                'order_details.amount_with_discount as amount',
				                'category.parent_id',
				                'order_details.item_id as iem_id'

				            	)
				            	->where('category.id','=',$cate_id);	            				
   $orders 						= $query->get();
   return $orders;

  }

  public function getParentCat(){
  	$category 					= Category::where('parent_id','==','0')->select('id','name','parent_id')->get();
  	return $category;
  }
    
    
}