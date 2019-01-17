<?php
namespace App\RMS\SaleSummary;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\MemberType\MemberType;
use Illuminate\Support\Facades\DB;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\Status\StatusConstance;
use App\RMS\DayStart\DayStart;


class SaleSummaryRepository implements SaleSummaryRepositoryInterface
{
	public function saleSummary()
    {
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('DATE(order.order_time)as Day'),
        DB::raw('Month(order.order_time)as Month'),
        DB::raw(
        '
        SUM(order.total_discount_amount) as DiscountAmount,
        SUM(order.tax_amount) as TaxAmount,
        SUM(order.service_amount) as ServiceAmount,
        SUM(order.foc_amount) as FocAmount,
        SUM(order.room_charge) as RoomAmount,
        SUM(order.total_extra_price) as ExtraAmount,
        SUM(order.total_price) as PriceAmount,
        SUM(order.all_total_amount) as Amount
        '))
        ->groupBy(DB::raw('DAY(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',$order_paid_status)
        ->get();
        
        return $orders;
    }

    public function DaySaleSummaryExport()
    {
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('DATE(order.order_time)as Day'),
        DB::raw(
        '
        SUM(order.total_discount_amount) as DiscountAmount,
        SUM(order.tax_amount) as TaxAmount,
        SUM(order.service_amount) as ServiceAmount,
        SUM(order.foc_amount) as FocAmount,
        SUM(order.room_charge) as RoomAmount,
        SUM(order.total_extra_price) as ExtraAmount,
        SUM(order.total_price) as PriceAmount,
        SUM(order.all_total_amount) as TotalAmount
        '))
        ->groupBy(DB::raw('DAY(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',$order_paid_status)
        ->get();
        
        return $orders;
    }

    public function MonthlySaleSummary(){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('MONTH(order.order_time)as Month'),
        DB::raw('YEAR(order.order_time)as Year'),
        DB::raw('
        SUM(order.total_discount_amount) as DiscountAmount,
        SUM(order.tax_amount) as TaxAmount,
        SUM(order.service_amount) as ServiceAmount,
        SUM(order.foc_amount) as FocAmount,
        SUM(order.room_charge) as RoomAmount,
        SUM(order.total_extra_price) as ExtraAmount,
        SUM(order.total_price) as PriceAmount,
        SUM(order.all_total_amount) as Amount
        '))
        ->groupBy(DB::raw('MONTH(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',$order_paid_status)
        ->get();

        return $orders;
    }

    public function MonthlySaleSummaryExport(){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('YEAR(order.order_time)as Year'),
        DB::raw('MONTH(order.order_time)as Month'),
        DB::raw('
        SUM(order.total_discount_amount) as DiscountAmount,
        SUM(order.tax_amount) as TaxAmount,
        SUM(order.service_amount) as ServiceAmount,
        SUM(order.foc_amount) as FocAmount,
        SUM(order.room_charge) as RoomAmount,
        SUM(order.total_extra_price) as ExtraAmount,
        SUM(order.total_price) as PriceAmount,
        SUM(order.all_total_amount) as TotalAmount
        '))
        ->groupBy(DB::raw('MONTH(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',$order_paid_status)
        ->get();

        return $orders;
    }

    public function YearlySaleSummary(){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(
        DB::raw('YEAR(order.order_time)as Year'),
        DB::raw('
        SUM(order.total_extra_price) as ExtraAmount,
        SUM(order.total_discount_amount) as DiscountAmount,
        SUM(order.total_price) as PriceAmount,
        SUM(order.room_charge) as RoomAmount,
        SUM(order.service_amount) as ServiceAmount,
        SUM(order.tax_amount) as TaxAmount,
        SUM(order.foc_amount) as FocAmount,
        SUM(order.all_total_amount) as Amount,
        SUM(order.payment_amount) as PayAmount
        '))
        ->groupBy(DB::raw('YEAR(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',$order_paid_status)
        ->get();

        return $orders;
    }

    public function YearlySaleSummaryExport(){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(
        DB::raw('YEAR(order.order_time)as Year'),
        DB::raw('
        SUM(order.total_discount_amount) as DiscountAmount,
        SUM(order.tax_amount) as TaxAmount,
        SUM(order.service_amount) as ServiceAmount,
        SUM(order.foc_amount) as FocAmount,
        SUM(order.room_charge) as RoomAmount,
        SUM(order.total_extra_price) as ExtraAmount,
        SUM(order.total_price) as PriceAmount,
        SUM(order.all_total_amount) as Amount
        '))
        ->groupBy(DB::raw('YEAR(order.order_time)'))
        ->whereYear('order.order_time','=',date('Y'))
        ->where('order.status','=',$order_paid_status)
        ->get();

        return $orders;
    }

    public function dailySale($d,$m){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->select('order.id as Invoice_id',DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),
                'users.user_name as Staff',DB::raw('SUM(order_details.quantity) as Quantity'),
                'order.total_discount_amount as Discount',
                'order.tax_amount as Tax',
                'order.service_amount as Service',
                'order.foc_amount as Foc',
                'order.room_charge as Room',
                'order.total_extra_price as Extra',
                'order.all_total_amount as Amount'
                )
            ->where(DB::raw('MONTH(order.order_time)'),'=',$m)
            ->where(DB::raw('Date(order.order_time)'),'=',$d)
            ->where('order.status',$order_paid_status)
            ->where('order_details.deleted_at',NULL)
            ->groupBy('order_details.order_id')
            ->orderBy('invoice_id')
            ->get();

        return $orders;
    }

    public function searchDailySummary($from_date,$to_date){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('DATE(order.order_time)as Day'),
            DB::raw('Month(order.order_time)as Month'),
            DB::raw('
            SUM(order.total_discount_amount) as DiscountAmount,
            SUM(order.tax_amount) as TaxAmount,
            SUM(order.service_amount) as ServiceAmount,
            SUM(order.foc_amount) as FocAmount,
            SUM(order.room_charge) as RoomAmount,
            SUM(order.total_extra_price) as ExtraAmount,
            SUM(order.total_price) as PriceAmount,
            SUM(order.all_total_amount) as Amount
        '))
            ->groupBy(DB::raw('DAY(order.order_time)'))
            ->whereDate('order.order_time','>=',$from_date)
            ->whereDate('order.order_time','<=',$to_date)
            ->where('order.status','=',$order_paid_status)
            ->get();
        return $orders;
    }

    public function DaySearchDailySummaryExport($from_date,$to_date){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('DATE(order.order_time)as Day'),
            DB::raw('
            SUM(order.total_discount_amount) as DiscountAmount,
            SUM(order.tax_amount) as TaxAmount,
            SUM(order.service_amount) as ServiceAmount,
            SUM(order.foc_amount) as FocAmount,
            SUM(order.room_charge) as RoomAmount,
            SUM(order.total_extra_price) as ExtraAmount,
            SUM(order.total_price) as PriceAmount,
            SUM(order.all_total_amount) as Amount
        '))
            ->groupBy(DB::raw('DAY(order.order_time)'))
            ->whereDate('order.order_time','>=',$from_date)
            ->whereDate('order.order_time','<=',$to_date)
            ->where('order.status','=',$order_paid_status)
            ->get();
        return $orders;
    }

    public function searchMonthlySummary($from_date,$to_date){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('MONTH(order.order_time)as Month'),
        DB::raw('YEAR(order.order_time)as Year'),
        DB::raw("
        SUM(order.total_extra_price) as ExtraAmount,
        SUM(order.total_discount_amount) as DiscountAmount,
        SUM(order.total_price) as PriceAmount,
        SUM(order.room_charge) as RoomAmount,
        SUM(order.service_amount) as ServiceAmount,
        SUM(order.tax_amount) as TaxAmount,
        SUM(order.foc_amount) as FocAmount,
        SUM(order.all_total_amount) as Amount,
        SUM(order.payment_amount) as PayAmount
        "))
        ->groupBy(DB::raw('MONTH(order.order_time)'))
        ->whereBetween('order.order_time', [$from_date,$to_date])
        ->where('order.status','=',$order_paid_status)->get();
        return $orders;
    }  

    public function searchMonthlySummaryExport($from_date,$to_date){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('YEAR(order.order_time)as Year'),
        DB::raw('MONTH(order.order_time)as Month'),
        DB::raw("
        SUM(order.total_discount_amount) as DiscountAmount,
        SUM(order.tax_amount) as TaxAmount,
        SUM(order.service_amount) as ServiceAmount,
        SUM(order.foc_amount) as FocAmount,
        SUM(order.room_charge) as RoomAmount,
        SUM(order.total_extra_price) as ExtraAmount,
        SUM(order.total_price) as PriceAmount,
        SUM(order.all_total_amount) as Amount
        "))
        ->groupBy(DB::raw('MONTH(order.order_time)'))
        ->whereBetween('order.order_time', [$from_date,$to_date])
        ->where('order.status','=',$order_paid_status)->get();
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
        $status     = StatusConstance::ORDER_PAID_STATUS;
        $orders = Orderdetail::
            leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->select('order.id as Invoice_id',
            DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),
                'users.user_name as Staff',
                DB::raw('SUM(order_details.quantity) as Quantity'),
                'order.total_discount_amount as DiscountAmount',
                'order.tax_amount as TaxAmount',
                'order.service_amount as ServiceAmount',
                'order.foc_amount as FocAmount',
                'order.room_charge as RoomCharge',
                'order.total_extra_price as Extra',
                'order.all_total_amount as Amount'
                )
            ->whereYear('order.order_time','=',$year)
            ->where('order.status',$status)
            ->where('order_details.deleted_at',NULL)
            ->groupBy('order_details.order_id')
            ->orderBy('invoice_id')
            ->get();

        return $orders;
    }

    public function sale_summary($type = null, $from = null, $to = null)
    {
       
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;

        $query                  = Order::query();
        $query                  = $query->join('order_day','order.day_id','=','order_day.id');
        $query                  = $query->select(DB::raw('SUM(order.over_all_discount) as DiscountAmount,
                                                         SUM(order.tax_amount) as TaxAmount,
                                                        SUM(order.service_amount) as ServiceAmount,
                                                        SUM(order.room_charge) as RoomAmount,
                                                        SUM(order.total_extra_price) as ExtraAmount,
                                                        SUM(order.sub_total) as SubTotal,
                                                        SUM(order.total_price) as NetAmount,
                                                        SUM(order.all_total_amount) as TotalAmount,
                                                        Date(order.order_time) as Day, 
                                                        Date(order_day.start_date) as ShiftDate' ));                             
        
        if($type == "Yearly"){  
            $tempfrom       = date('Y', strtotime('01-01-'.$from));     
            $query          = $query ->groupBy(DB::raw('Year(order_day.start_date)'))       
                                    ->where(DB::raw('Year(order_day.start_date)'),$from) ;                       
        }
        else if($type == "Monthly"){ 
             $tempfrom         = date("Y-m-d", strtotime('01-'.$from));
             $tempto           = date("Y-m-d", strtotime('31-'.$to));
             $query            = $query->groupBy(DB::raw('Month(order_day.start_date)'))
                                  ->whereDate('order_day.start_date','>=',$tempfrom)
                                  ->whereDate('order_day.start_date','<=',$tempto);
                               
        }
        else if($type == "Daily"){
             $tempfrom      = date("Y-m-d", strtotime($from));
             $tempto        = date("Y-m-d", strtotime($to));       


             $query         = $query-> groupBy(DB::raw('Date(order_day.start_date)'))
                                  ->whereDate('order_day.start_date','>=',$tempfrom)
                                  ->whereDate('order_day.start_date','<=',$tempto);
        }
        $orders             = $query->where('order.status',$order_paid_status)->get();   
       
        return $orders;

    }

     public function sale_summary_detail($date,$type){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $query                  = Orderdetail::query();
        $query                  = $query->join('order','order.id','=','order_details.order_id')
                                    ->join('users','users.id','=','order.user_id')
                                    ->join('order_day','order.day_id','=','order_day.id')
                                    ->select('order.id as invoice_id',DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),
                                        'users.user_name as Staff',DB::raw('SUM(order_details.quantity) as Quantity'),
                                        'order.over_all_discount as Discount',
                                        'order.tax_amount as Tax',
                                        'order.service_amount as Service',
                                        'order.room_charge as Room',                                                   
                                        'order.total_extra_price as Extra',
                                        'order.sub_total as SubTotal', 
                                        'order.total_price as NetAmount',                                        
                                        'order.all_total_amount as Amount'
                                    );
        if($type == "Yearly"){
            $query               = $query->where(DB::raw('Year(order_day.start_date)'),$date); 
        }
        if($type == "Monthly"){
            $temp_month          = date('m', strtotime($date.'-01'));
            $temp_year           = date('Y', strtotime($date.'-01'));
            $query               = $query->where(DB::raw('Month(order_day.start_date)'),$temp_month) 
                                    ->where(DB::raw('Year(order_day.start_date)'),$temp_year); 
        }
        if($type == "Daily"){
            $query               = $query->where(DB::raw('Date(order_day.start_date)'),$date); 
        }
        $orders                  = $query->where('order.status',$order_paid_status)
                                    ->whereNull('order_details.deleted_at')
                                    ->groupBy('order_details.order_id')
                                    ->orderBy('order_day.start_date','ASC')
                                    ->get();  
        return $orders;
    }

     public function sale_summary_detail_sort($date,$type,$sort){
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $query                  = Orderdetail::query();
        $query                  = $query->join('order','order.id','=','order_details.order_id')
                                    ->join('order_day','order.day_id','=','order_day.id')
                                    ->join('users','users.id','=','order.user_id')
                                    ->select('order.id as invoice_id',DB::raw('DATE_FORMAT(order.order_time,"%d-%m-%Y")as Date'),
                                        'users.user_name as Staff',
                                        DB::raw('SUM(order_details.quantity) as Quantity'),
                                        'order.over_all_discount as Discount',
                                        'order.tax_amount as Tax',
                                        'order.service_amount as Service',
                                        'order.room_charge as Room',                                                   
                                        'order.total_extra_price as Extra',
                                        'order.sub_total as SubTotal', 
                                        'order.total_price as NetAmount',                                        
                                        'order.all_total_amount as Amount'
                                    );                                   
        if($type == "Yearly"){
            $query               = $query->where(DB::raw('Year(order.order_time)'),$date); 
        }
        if($type == "Monthly"){
            $temp_month          = date('m', strtotime($date.'-01'));
            $temp_year           = date('Y', strtotime($date.'-01'));
            $query               = $query->where(DB::raw('Month(order_day.start_date)'),$temp_month) 
                                    ->where(DB::raw('Year(order_day.start_date)'),$temp_year); 
        }
        if($type == "Daily"){
            $query               = $query->where(DB::raw('Date(order_day.start_date)'),$date); 
        }

        $query                  = $query->where('order.status',$order_paid_status)
                                    ->whereNull('order_details.deleted_at')
                                    ->groupBy('order_details.order_id');

         if($sort               == "date_asc")
         {

        $query                  = $query->orderBy('order_day.start_date','ASC');
        // $posts = Post::orderBy('id', 'DESC')->get();
         }
         elseif ($sort          == "date_desc") {         
         $query                  = $query->orderBy('order_day.start_date','DESC');
         }
         elseif ($sort          == "amount_asc") {           
             $query             = $query->orderBy('Amount','ASC');
         }
         else{
            /* amount_desc */
             $query             = $query->orderBy('Amount','DESC');
         }  
         $orders                = $query->get();        
        return $orders;
    }
    public function get_last_order_day(){
        $order_day              = DayStart::max('start_date');
       return $order_day;
    }
}	

