<?php
namespace App\RMS\CategorySaleSummary;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\MemberType\MemberType;
use Illuminate\Support\Facades\DB;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;

class CategorySaleSummaryRepository implements CategorySaleSummaryRepositoryInterface
{
	public function getStartDate(){
        $start_date=DB::table('order')->select(DB::raw('min(order_time) as min'))->first();
        return $start_date;

    }

    public function getEndDate(){
        $end_date=DB::table('order')->select(DB::raw('max(order_time) as max'))->first();
        return $end_date;
    }

    public function getChildCategory(){
        $category = DB::select("SELECT * FROM category where id not in (select parent_id from category)");
        return $category;
    }


    public function DailyDetailReport(){
        $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
            ->select('category.name as category_name',DB::raw('SUM((order_details.quantity)*(order_details.amount)-(order_details.discount_amount)) as total'),DB::raw('DAY(order.order_time) as day'),DB::raw('(order.order_time) as date'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereNotNull('order_details.item_id')
            ->groupBy('day','category_name')
            ->orderBy('date','desc')
            ->get();

        return $orders;
    }
    public function saleSummaryDailyDetailExport($start, $end){
        $orders = Orderdetail::
        leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
            ->select(DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),'category.name as CategoryName',DB::raw('SUM((order_details.quantity)*(order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereBetween('order.order_time', [$start->min, $end->max])
            ->whereNotNull('order_details.item_id')
            ->groupBy(DB::raw('DAY(order.order_time)'),'CategoryName')
            ->orderBy('order.order_time','desc')
            ->get();

        return $orders;
    }

    public function getDetailReportWithDate($start_date, $end_date,$child){

        $start_date = $start_date.' 00:00:00';
        $end_date   = $end_date.' 23:00:00';
        $cat        = $child;

        $orders = Orderdetail::
        leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')

            ->select('order_details.*','users.user_name','category.name as category_name',DB::raw('SUM(order_details.amount_with_discount) as total'),DB::raw('(order.order_time) as date'),DB::raw('DAY(order.order_time) as day'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereBetween('order.order_time', [$start_date, $end_date])
            ->whereNotNull('order_details.item_id')
            ->where('category.id','=',$cat)
            ->groupBy('day','category_name')
            ->orderBy('order.order_time','desc')
            ->get();

        return $orders;
    }

    public function saleSummaryDailyDetailExportWithDate($start_date, $end_date,$child){
        $orders = Orderdetail::
        leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')

            ->select(DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),'category.name as CategoryName',DB::raw('SUM(order_details.amount_with_discount) as TotalAmount'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereBetween('order.order_time', [$start_date, $end_date])
            ->whereNotNull('order_details.item_id')
            ->where('category.id','=',$child)
            ->groupBy(DB::raw('DAY(order.order_time)'),'CategoryName')
            ->orderBy('order.order_time','desc')
            ->get();

        return $orders;
    }

   
    public function MonthlyDetailReport(){
        
         $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
                       
            ->select('order_details.*',
                'users.user_name','category.name as category_name',DB::raw('SUM(order_details.amount_with_discount) as total'),DB::raw('(order.order_time) as date'),DB::raw('Month(order.order_time) as month'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereNotNull('order_details.item_id')
            ->groupBy('month','category_name')
            ->orderBy('date','desc')
            ->get();
    
        return $orders;
    }

    public function YearlyDetailReport(){
        $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
                       
            ->select('order_details.*',
                'users.user_name','category.name as category_name',DB::raw('SUM(order_details.amount_with_discount) as total'),DB::raw('(order.order_time) as date'),DB::raw('YEAR(order.order_time) as year'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereNotNull('order_details.item_id')
            ->groupBy('year','category_name')
            ->orderBy('date','desc')
            ->get();    

        return $orders;
    }

    public function saleSummaryMonthlyDetailExport($start, $end){
        $orders = Orderdetail::
        leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
            ->select(DB::raw('MONTH(order.order_time) as Month'),DB::raw('YEAR(order.order_time) as Year'),'category.name as CategoryName',DB::raw('SUM(order_details.amount_with_discount) as TotalAmount'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereBetween('order.order_time', [$start->min, $end->max])
            ->whereNotNull('order_details.item_id')
            ->groupBy(DB::raw('MONTH(order.order_time)'),'CategoryName')
            ->orderBy('order.order_time','desc')
            ->get();

        return $orders;
    }

    public function saleSummaryYearlyDetailExport($start, $end){
        $orders = Orderdetail::
        leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
            ->select(DB::raw('YEAR(order.order_time) as Year'),'category.name as CategoryName',DB::raw('SUM(order_details.amount_with_discount) as TotalAmount'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereBetween('order.order_time', [$start->min, $end->max])
            ->whereNotNull('order_details.item_id')
            ->groupBy(DB::raw('YEAR(order.order_time)'),'CategoryName')
            ->orderBy('order.order_time','desc')
            ->get();

        return $orders;
    }

    public function getYearlyDetailReportWithDate($year,$child){
        $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
                       
            ->select('users.user_name','category.name as category_name',DB::raw('SUM(order_details.amount_with_discount) as total'),DB::raw('(order.order_time) as date'),DB::raw('YEAR(order.order_time) as year'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->where(DB::raw('YEAR(order.order_time)'),$year)
            ->whereNotNull('order_details.item_id')
            ->where('category.id','=',$child)
            ->groupBy('year','category_name')
            ->orderBy('order.order_time','desc')
            ->get();     

        return $orders;
    }

    public function getMonthlyDetailReportWithDate($from_month, $to_month,$child){
        $orders = Orderdetail::
        leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
            ->select(DB::raw('MONTH(order.order_time) as Month'),DB::raw('YEAR(order.order_time) as Year'),'category.name as CategoryName',DB::raw('SUM(order_details.amount_with_discount) as TotalAmount'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereBetween('order.order_time', [$from_month, $to_month])
            ->whereNotNull('order_details.item_id')
            ->where('category.id','=',$child)
            ->groupBy(DB::raw('MONTH(order.order_time)'),'CategoryName')
            ->orderBy('order.order_time','desc')
            ->get();

        return $orders;
    }

    

    public function saleSummaryMonthlyDetailExportWithDate($from_date, $to_date,$child){
        $orders = Orderdetail::
        leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
            ->select(DB::raw('MONTH(order.order_time) as Month'),DB::raw('YEAR(order.order_time) as Year'),'category.name as CategoryName',DB::raw('SUM(order_details.amount_with_discount) as TotalAmount'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->whereBetween('order.order_time', [$from_date, $to_date])
            ->whereNotNull('order_details.item_id')
            ->where('category.id','=',$child)
            ->groupBy(DB::raw('MONTH(order.order_time)'),'CategoryName')
            ->orderBy('order.order_time','desc')
            ->get();

        return $orders;
    }

    public function saleSummaryYearlyDetailExportWithDate($year,$child){
        $orders = Orderdetail::
        leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('items','items.id','=','order_details.item_id')
            ->leftjoin('category','category.id','=','items.category_id')
            ->select(DB::raw('YEAR(order.order_time) as Year'),'category.name as CategoryName',DB::raw('SUM(order_details.amount_with_discount) as TotalAmount'))
            ->where('order_details.status_id',5)
            ->where('order_details.setmenu_id',0) // to remove set_menu from category sale_summary report
            ->where('order_details.deleted_at',NULL)
            ->where(DB::raw('YEAR(order.order_time)'), $year)
            ->whereNotNull('order_details.item_id')
            ->where('category.id','=',$child)
            ->groupBy(DB::raw('YEAR(order.order_time)'),'CategoryName')
            ->orderBy('order.order_time','desc')
            ->get();

        return $orders;
    }

}
