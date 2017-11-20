<?php
namespace App\RMS\Sale;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\MemberType\MemberType;
use Illuminate\Support\Facades\DB;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\Status\StatusConstance;

class SaleRepository implements SaleRepositoryInterface
{
	public function saleReport()
    {
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::leftjoin('order_details','order_details.order_id','=','order.id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->select('order.id as invoice_id','order.order_time','order.all_total_amount as Amount','order.payment_amount as Payment','order.refund as Refund',
        'order.service_amount as Service','order.tax_amount as Tax','order.total_discount_amount as Discount','order.foc_amount as Foc'
        ,'users.user_name',DB::raw('SUM(order_details.quantity) as Quantity'))
        ->where('order.status','=',$order_paid_status)
        ->where('order_details.deleted_at',NULL)
        ->groupBy('order.id')
        ->orderBy('order.order_time','desc')
        ->get();    

        return $orders;
    }

    public function saleExcelReport(){
        
        $orders = Order::leftjoin('order_details','order_details.order_id','=','order.id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->select('order.id as InvoiceID', DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y") as Date'), 'users.user_name as Cashier',DB::raw('SUM(order_details.quantity) as Quantity'), 'order.all_total_amount as Amount','order.payment_amount as Payment','order.refund as Refund',
        'order.service_amount as Service','order.tax_amount as Tax','order.total_discount_amount as Discount','order.foc_amount as Foc')
        ->where('order.status','=','2')
        ->where('order_details.deleted_at',NULL)
        ->groupBy('order.id')
        ->orderBy('order.order_time','desc')
        ->get();    

        return $orders;
    }
    

    public function saleExcelDetailReport($from,$to)
    {
        
        $orders = Order::leftjoin('order_details','order_details.order_id','=','order.id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->select('order.id as InvoiceID',DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y") as Date'), 'users.user_name as Cashier',DB::raw('SUM(order_details.quantity) as Quantity'),'order.all_total_amount as Amount','order.payment_amount as Payment','order.refund as Refund',
        'order.service_amount as Service','order.tax_amount as Tax','order.total_discount_amount as Discount','order.foc_amount as Foc')
        ->where('order.status','=','2')
        ->where('order_details.deleted_at',NULL)
        ->whereBetween('order.order_time',[$from,$to])
        ->groupBy('order.id')
        ->orderBy('order.order_time','desc')
        ->get();    
        return $orders;
    }

}
