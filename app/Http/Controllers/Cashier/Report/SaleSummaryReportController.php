<?php

namespace App\Http\Controllers\Cashier\Report;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\RMS\SaleSummary\SaleSummaryRepositoryInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\Item\Item;
use App\Status\StatusConstance;

use Illuminate\Support\Facades\Input;
//use Input;
use Excel;
use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;

class SaleSummaryReportController extends Controller
{
    private $orderRepository;

    public function __construct(SaleSummaryRepositoryInterface $saleSummaryRepository)
    {
        $this->reportRepository = $saleSummaryRepository;
    }


    public function saleSummary()
    {
        $orders = $this->reportRepository->saleSummary();
    
        return view('cashier.report.SaleSummaryReport')->with('orders',$orders);

    }

    public function saleSummaryExport()
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->saleSummary();
    
        Excel::create('SaleReport', function($excel)use($orders) {
            $excel->sheet('Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_extra=0;
                $sum_price=0;
                $sum_room=0;
                $sum_payment=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_extra      += $order->ExtraAmount;
                    $sum_price      += $order->PriceAmount;
                    $sum_room       += $order->RoomAmount;
                    $sum_payment    += $order->PayAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                }
                $sheet->appendRow(array(
                        '',
                        'Total',
                        $sum_extra,
                        $sum_discount,
                        $sum_price,
                        $sum_room,
                        $sum_service,
                        $sum_tax,
                        $sum_foc,
                        $sum_amount,
                        $sum_payment
                        ));

                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });

            });
        })->download('xls');
        ob_flush();
        return Redirect();
    }

    public function saleSummaryReportWithCheck($checked_value)
    {
        if(isset($checked_value)){
            if($checked_value == "daily"){
                $orders = $this->reportRepository->saleSummary();

                return view('cashier.report.SaleSummaryReport')->with('orders',$orders)->with('checked',$checked_value);
            }
            else if($checked_value == "monthly"){
                $orders = $this->reportRepository->MonthlySaleSummary();
                
                 return view('cashier.report.MonthlySaleSummaryReport')->with('orders',$orders)->with('checked',$checked_value);

            }
            else{
                $orders = $this->reportRepository->YearlySaleSummary();
                // dd($orders);
                return view('cashier.report.YearlySaleSummaryReport')->with('orders',$orders)->with('checked',$checked_value);
            }
        }
        else{
            $orders = $this->OrdeRepository->saleSummary();

            return view('cashier.report.SaleSummaryReport')->with('orders',$orders)->with('checked',$checked);
        }
         
    }

    public function monthlySaleSummaryExport()
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->MonthlySaleSummary();
        Excel::create('SaleReport', function($excel)use($orders) {
            $excel->sheet('Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_extra=0;
                $sum_price=0;
                $sum_room=0;
                $sum_payment=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_extra      += $order->ExtraAmount;
                    $sum_price      += $order->PriceAmount;
                    $sum_room       += $order->RoomAmount;
                    $sum_payment    += $order->PayAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                }
                $sheet->appendRow(array(
                    '',
                    'Total',
                    $sum_extra,
                    $sum_discount,
                    $sum_price,
                    $sum_room,
                    $sum_service,
                    $sum_tax,
                    $sum_foc,
                    $sum_amount,
                    $sum_payment
                    ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
        ->download('xls');
       ob_flush();
        return Redirect();
    }

    public function dailySale($day,$month){
        $d      = $day;
        $m      = $month;
        $orders = $this->reportRepository->dailySale($d, $m);
        return view('cashier.report.DailySale')->with('orders',$orders)->with('d',$d)->with('m',$m);
    }
    public function dailySaleExport($day,$month)
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->dailySale($day,$month);
        Excel::create('DailySaleReport', function($excel)use($orders) {
            $excel->sheet('Daily Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_payment=0;
                $sum_refund=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_payment    += $order->Payment;
                    $sum_refund     += $order->Refund;
                    $sum_service    += $order->Service;
                    $sum_tax        += $order->Tax;
                    $sum_discount   += $order->Discount;
                    $sum_foc        += $order->Foc;
                }
                $sheet->appendRow(array('','','','Total',$sum_amount,$sum_payment,$sum_refund,$sum_service,$sum_tax,$sum_discount,$sum_foc));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
        ->download('xls');
       ob_flush();
        return Redirect();
    }


    public function saleSummaryExportDetail($year)
    {
        ob_end_clean();
        ob_start();
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $orders = Order::select(DB::raw('DATE_FORMAT(order.order_time,"%b")as Month'),
        DB::raw('YEAR(order.order_time)as Year'),DB::raw("SUM(order.all_total_amount)as Amount"))->groupBy(DB::raw('MONTH(order.order_time)'))->whereYear('order.order_time','=',$year)
        ->where('order.status','=',$order_paid_status)->get();    

        Excel::create('SaleReport', function($excel)use($orders) {
            $excel->sheet('Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_payment=0;
                $sum_refund=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_payment    += $order->PayAmount;
                    $sum_refund     += $order->RefundAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                }
                $sheet->appendRow(array('','Total',$sum_amount,$sum_payment,$sum_refund,$sum_service,$sum_tax,$sum_discount,$sum_foc));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');
        ob_flush();
        return Redirect();
    }

    public function monthlySale($year,$month) //checked
    {
        $m      = $month;
        $y      = $year;
        $orders = $this->reportRepository->sale($year, $month);
        return view('cashier.report.MonthlySale')->with('orders',$orders)->with('m',$m)->with('y',$y);
    }

    public function monthlySaleExport($year,$month){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->sale($year,$month);
        Excel::create('SaleReport', function($excel)use($orders) {
            $excel->sheet('Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_payment=0;
                $sum_refund=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_payment    += $order->PayAmount;
                    $sum_refund     += $order->RefundAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                }
                $sheet->appendRow(array('','Total',$sum_amount,$sum_payment,$sum_refund,$sum_service,$sum_tax,$sum_discount,$sum_foc));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
        ->download('xls');
       ob_flush();
        return Redirect();
    }

    public function searchDailySummary(){
        $to_date    = Input::get('to_date');
        $from_date  = Input::get('from_date');
        
        $from_date  = date("Y-m-d",strtotime($from_date));

        $to_date    = date("Y-m-d",strtotime($to_date));
        
        if($to_date == null ){
            alert()->warning('Please Choose Year You Want to Search!')->persistent('Close');
            return back();
        }else{
            $orders = $this->reportRepository->searchDailySummary($from_date, $to_date);
            return view('cashier.report.SaleSummaryReport')->with('orders',$orders)->with('to_date',$to_date)->with('from_date',$from_date);
        }
    }

    public function searchDailySummaryExport($start_date,$end_date){
        ob_end_clean();
        ob_start();
       
        $orders = $this->reportRepository->searchDailySummary($start_date,$end_date);
        
        Excel::create('SaleReport', function($excel)use($orders) {
            $excel->sheet('Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_extra=0;
                $sum_price=0;
                $sum_room=0;
                $sum_payment=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_extra      += $order->ExtraAmount;
                    $sum_price      += $order->PriceAmount;
                    $sum_room       += $order->RoomAmount;
                    $sum_payment    += $order->PayAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                }
                $sheet->appendRow(array(
                        '',
                        'Total',
                        $sum_extra,
                        $sum_discount,
                        $sum_price,
                        $sum_room,
                        $sum_service,
                        $sum_tax,
                        $sum_foc,
                        $sum_amount,
                        $sum_payment
                        ));

                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });

            });
        })->download('xls');
        ob_flush();
        return Redirect();
    }

     public function searchMonthlySummary(){
        $to_month   = Input::get('to_month');
        $from_month = Input::get('from_month');
        $from       = "01-".Input::get('from_month');
        $to         = "31-".Input::get('to_month');
        $from_date  = date("Y-m-d",strtotime($from));
        $to_date    = date("Y-m-d",strtotime($to));
        if($to_month == null ){
            alert()->warning('Please Choose Year You Want to Search!')->persistent('Close');
            return back();
        }else{
            $orders = $this->reportRepository->searchMonthlySummary($from_date,$to_date);

            return view('cashier.report.MonthlySaleSummaryReport')->with('orders',$orders)->with('to_month',$to_month)->with('from_month',$from_month);
        }
    }

    public function searchMonthlySummaryExport($from_month,$to_month){
        ob_end_clean();
        ob_start();
        // $to_month   = Input::get('to_month');
        // $from_month = Input::get('from_month');
        $from       = "01-" . $from_month;
        $to         = "31-" . $to_month;
        $from_date  = date("Y-m-d",strtotime($from));
        $to_date    = date("Y-m-d",strtotime($to));
        $orders = $this->reportRepository->searchMonthlySummary($from_date,$to_date);

        Excel::create('MonthlySummaryReport', function($excel)use($orders) {
            $excel->sheet('MonthlySummaryReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_extra=0;
                $sum_price=0;
                $sum_room=0;
                $sum_payment=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_extra      += $order->ExtraAmount;
                    $sum_price      += $order->PriceAmount;
                    $sum_room       += $order->RoomAmount;
                    $sum_payment    += $order->PayAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                }
                $sheet->appendRow(array(
                    '',
                    'Total',
                    $sum_extra,
                    $sum_discount,
                    $sum_price,
                    $sum_room,
                    $sum_service,
                    $sum_tax,
                    $sum_foc,
                    $sum_amount,
                    $sum_payment
                    ));

                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });

            });
        })->download('xls');
        ob_flush();
        return Redirect();
    }

    public function yearlySaleSummaryExport(){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->YearlySaleSummary();
        Excel::create('YearlySaleReport', function($excel)use($orders) {
            $excel->sheet('YearlySale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_extra=0;
                $sum_price=0;
                $sum_room=0;
                $sum_payment=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_extra      += $order->ExtraAmount;
                    $sum_price      += $order->PriceAmount;
                    $sum_room       += $order->RoomAmount;
                    $sum_payment    += $order->PayAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                }
                $sheet->appendRow(array(
                    'Total',
                    $sum_extra,
                    $sum_discount,
                    $sum_price,
                    $sum_room,
                    $sum_service,
                    $sum_tax,
                    $sum_foc,
                    $sum_amount,
                    $sum_payment
                    ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
        ->download('xls');
       ob_flush();
        return Redirect();
    }
    public function searchYearlySummary(){
        $year   = Input::get('date');
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        if($year == null ){
            alert()->warning('Please Choose Year You Want to Search!')->persistent('Close');
            return back();
        }else{
            $orders = Order::select(DB::raw('YEAR(order.order_time)as Year'),
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
                    ->groupBy(DB::raw('YEAR(order.order_time)'))
                    ->whereYear('order.order_time','=',$year)
                    ->where('order.status','=',$order_paid_status)
                    ->get();
            return view('cashier.report.YearlySaleSummaryReport')->with('orders',$orders)->with('year',$year);
        }
    }

    public function searchYearSummaryExport($year){
        ob_end_clean();
        ob_start();
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $from       = '01-01-' . $year;
        $from_year  = date("Y-m-d",strtotime($from));
        $orders = Order::select(DB::raw('YEAR(order.order_time)as Year'),
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
                    ->whereYear('order.order_time','=',$from_year)
                    ->where('order.status','=',$order_paid_status)
                    ->get(); 
        
        Excel::create('YearlySummaryReport', function($excel)use($orders) {
            $excel->sheet('YearlySummarySale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_extra=0;
                $sum_price=0;
                $sum_room=0;
                $sum_payment=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_extra      += $order->ExtraAmount;
                    $sum_price      += $order->PriceAmount;
                    $sum_room       += $order->RoomAmount;
                    $sum_payment    += $order->PayAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                }
                $sheet->appendRow(array(
                    'Total',
                    $sum_extra,
                    $sum_discount,
                    $sum_price,
                    $sum_room,
                    $sum_service,
                    $sum_tax,
                    $sum_foc,
                    $sum_amount,
                    $sum_payment
                    ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
        ->download('xls');
       ob_flush();
        return Redirect();
    }

    public function yearlySale($year) //checked
    {
        $y      = $year;
        $orders = $this->reportRepository->yearlysale($year);
        return view('cashier.report.YearlySale')->with('orders',$orders)->with('y',$y);
    }
    public function yearlySaleExport($year){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->yearlysale($year);
        Excel::create('YearlySaleReport', function($excel)use($orders) {
            $excel->sheet('YearlySale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_quantity = 0;
                $sum_extra = 0;
                $sum_amount=0;
                $sum_payment=0;
                $sum_refund=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                $room_charge = 0;
                foreach($orders as $order){
                    $sum_quantity   += $order->Quantity;
                    $sum_amount     += $order->Amount;
                    $sum_payment    += $order->PayAmount;
                    $sum_extra      += $order->Extra;
                    $sum_refund     += $order->RefundAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_discount   += $order->DiscountAmount;
                    $sum_foc        += $order->FocAmount;
                    $room_charge    += $order->RoomCharge;
                }
                $sheet->appendRow(array('Total','','',$sum_quantity,$sum_amount,$sum_payment,$sum_refund,$sum_service,$sum_tax,$room_charge,$sum_foc,$sum_discount));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
        ->download('xls');
       ob_flush();
        return Redirect();
    }

    

}
