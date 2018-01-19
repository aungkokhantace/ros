<?php
namespace App\RMS\SaleSummary;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\MemberType\MemberType;
use Illuminate\Support\Facades\DB;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;

class SaleSummaryRepository implements SaleSummaryRepositoryInterface
{
	public function saleSummary()
    {
        $orders = Order::select(DB::raw('DATE(order.order_time)as Day'),
        DB::raw('Month(order.order_time)as Month'),DB::raw('SUM(order.all_total_amount) as Amount'))
        ->groupBy(DB::raw('DAY(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',2)
        ->get();
        
        return $orders;
    }
    public function MonthlySaleSummary(){
        $orders = Order::select(DB::raw('MONTH(order.order_time)as Month'),
        DB::raw('YEAR(order.order_time)as Year'),DB::raw('SUM(order.all_total_amount) as Amount'))
        ->groupBy(DB::raw('MONTH(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',2)
        ->get();

        return $orders;
    }
    public function YearlySaleSummary(){
        $orders = Order::select(
        DB::raw('YEAR(order.order_time)as Year'),DB::raw('SUM(order.all_total_amount) as Amount'))
        ->groupBy(DB::raw('YEAR(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',2)
        ->get();

        return $orders;
    }

    public function dailySale($d,$m){
        $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->select('order.id as Invoice_id',DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),
                'users.user_name as Staff',DB::raw('SUM(order_details.quantity) as Quantity'),'order.all_total_amount as Amount')
            ->where(DB::raw('MONTH(order.order_time)'),'=',$m)
            ->where(DB::raw('Date(order.order_time)'),'=',$d)
            ->where('order.status',2)
            ->where('order_details.deleted_at',NULL)
            ->groupBy('order_details.order_id')
            ->orderBy('invoice_id')
            ->get();

        return $orders;
    }

    public function searchDailySummary($from_date,$to_date){
        $orders = Order::select(DB::raw('DATE(order.order_time)as Day'),
            DB::raw('Month(order.order_time)as Month'),DB::raw('SUM(order.all_total_amount) as Amount'))
            ->groupBy(DB::raw('DAY(order.order_time)'))
            ->whereDate('order.order_time','>=',$from_date)
            ->whereDate('order.order_time','<=',$to_date)
            ->where('order.status','=',2)
            ->get();
        return $orders;
    }

    public function searchMonthlySummary($from_date,$to_date){
        $orders = Order::select(DB::raw('MONTH(order.order_time)as Month'),
        DB::raw('YEAR(order.order_time)as Year'),DB::raw("SUM(order.all_total_amount)as Amount"))->groupBy(DB::raw('MONTH(order.order_time)'))->whereBetween('order.order_time', [$from_date,$to_date])
        ->where('order.status','=','2')->get();
        return $orders;
    }    
    public function sale($year,$month) //checked
    {
        $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->select('order.id as Invoice_id',DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),
                'users.user_name as Staff',DB::raw('SUM(order_details.quantity) as Quantity'),'order.all_total_amount as Amount')
            ->where(DB::raw('MONTH(order.order_time)'),'=',$month)
            ->whereYear('order.order_time','=',$year)
            ->where('order.status',2)
            ->where('order_details.deleted_at',NULL)
            ->groupBy('order_details.order_id')
            ->orderBy('invoice_id')
            ->get();

        return $orders;
    }

    public function yearlysale($year) //checked
    {
        $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->select('order.id as Invoice_id',DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),
                'users.user_name as Staff',DB::raw('SUM(order_details.quantity) as Quantity'),'order.all_total_amount as Amount')
            ->whereYear('order.order_time','=',$year)
            ->where('order.status',2)
            ->where('order_details.deleted_at',NULL)
            ->groupBy('order_details.order_id')
            ->orderBy('invoice_id')
            ->get();

        return $orders;
    }
}	

