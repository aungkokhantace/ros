<?php

namespace App\Http\Controllers\Backend\Report;

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
    
        return view('Backend.report.SaleSummaryReport')->with('orders',$orders);

    }


    public function saleSummaryExport()
    {
        ob_end_clean();
        ob_start();
        // $orders = $this->reportRepository->saleSummary();
        $orders = $this->reportRepository->DaySaleSummaryExport();
        foreach ($orders as $key => $order) {
            $items[$key]['Day']                     = $order->Day;
            $items[$key]['Total Discount Amount']   = $order->DiscountAmount;
            $items[$key]['Total Tax Amount']        = $order->TaxAmount;
            $items[$key]['Total Service Amount']    = $order->ServiceAmount;
            $items[$key]['Total FOC Amount']        = $order->FocAmount;
            $items[$key]['Total Room Charge']       = $order->RoomAmount;
            $items[$key]['Total Extra Price']       = $order->ExtraAmount;
            $items[$key]['Total Price']             = $order->PriceAmount;
            $items[$key]['Total All Amount']        = $order->TotalAmount;
        }
        Excel::create('SaleReport', function($excel)use($orders,$items) {
            $excel->sheet('Sale Report', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
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
                    $sum_discount   += $order->DiscountAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_foc        += $order->FocAmount;
                    $sum_room       += $order->RoomAmount;
                    $sum_extra      += $order->ExtraAmount;
                    $sum_price      += $order->PriceAmount;
                    $sum_amount     += $order->TotalAmount;
                }
                $sheet->appendRow(array(
                        'Total',
                        $sum_discount,
                        $sum_tax,
                        $sum_service,
                        $sum_foc,
                        $sum_room,
                        $sum_extra,
                        $sum_price,
                        $sum_amount
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

                return view('Backend.report.SaleSummaryReport')->with('orders',$orders)->with('checked',$checked_value);
            }
            else if($checked_value == "monthly"){
                $orders = $this->reportRepository->MonthlySaleSummary();
                
                 return view('Backend.report.MonthlySaleSummaryReport')->with('orders',$orders)->with('checked',$checked_value);

            }
            else{
                $orders = $this->reportRepository->YearlySaleSummary();
                // dd($orders);
                return view('Backend.report.YearlySaleSummaryReport')->with('orders',$orders)->with('checked',$checked_value);
            }
        }
        else{
            $orders = $this->OrdeRepository->saleSummary();

            return view('Backend.report.SaleSummaryReport')->with('orders',$orders)->with('checked',$checked);
        }
         
    }

    public function monthlySaleSummaryExport()
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->MonthlySaleSummaryExport();
        foreach ($orders as $key => $order) {
            $items[$key]['Year']                     = $order->Year;
            $items[$key]['Month']                    = date("F", mktime(0, 0, 0, $order->Month, 1));
            $items[$key]['Total Discount Amount']    = $order->DiscountAmount;
            $items[$key]['Total Tax Amount']         = $order->TaxAmount;
            $items[$key]['Total Service Amount']     = $order->ServiceAmount;
            $items[$key]['Total FOC Amount']         = $order->FocAmount;
            $items[$key]['Total Room Charge']        = $order->RoomAmount;
            $items[$key]['Total Extra Price']        = $order->ExtraAmount;
            $items[$key]['Total Price']              = $order->PriceAmount;
            $items[$key]['Total All Amount']         = $order->TotalAmount;
        }
        Excel::create('SaleReport', function($excel)use($orders,$items) {
            $excel->sheet('Sale Report', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
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
                    $sum_amount     += $order->TotalAmount;
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
                    $sum_discount,
                    $sum_tax,
                    $sum_service,
                    $sum_foc,
                    $sum_room,
                    $sum_extra,
                    $sum_price,
                    $sum_amount
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
        return view('Backend.report.DailySale')->with('orders',$orders)->with('d',$d)->with('m',$m);
    }
    public function dailySaleExport($day,$month)
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->dailySale($day,$month);
        Excel::create('DailySaleReport', function($excel)use($orders) {
            $excel->sheet('Daily Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_quantity = 0;
                $sum_amount=0;
                $sum_payment=0;
                $sum_refund=0;
                $sum_service=0;
                $sum_tax=0;
                $sum_discount=0;
                $sum_foc=0;
                $sum_extra = 0;
                $sum_room = 0;
                foreach($orders as $order){
                    $sum_quantity   += $order->Quantity;
                    $sum_discount   += $order->Discount;
                    $sum_tax        += $order->Tax;
                    $sum_service    += $order->Service;
                    $sum_foc        += $order->Foc;
                    $sum_room       += $order->Room;
                    $sum_extra      += $order->Extra;
                    $sum_amount     += $order->Amount;
                    
                }
                $sheet->appendRow(array('','','Total',$sum_quantity,$sum_discount,$sum_tax,
                            $sum_service,$sum_foc,$sum_room,$sum_extra,$sum_amount));
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
        return view('Backend.report.MonthlySale')->with('orders',$orders)->with('m',$m)->with('y',$y);
    }

    public function monthlySaleExport($year,$month){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->sale($year,$month);
        Excel::create('SaleReport', function($excel)use($orders) {
            $excel->sheet('Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $sum_amount=0;
                $sum_quantity = 0;
                foreach($orders as $order){
                    $sum_quantity   += $order->Quantity;
                    $sum_amount     += $order->Amount;
                }
                $sheet->appendRow(array('','','Total',$sum_quantity,$sum_amount));
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
        
        if($to_date == null || $from_date == null){
            alert()->warning('Please Choose Date You Want to Search!')->persistent('Close');
            return back();
        }else{
            $from_date  = date("Y-m-d",strtotime($from_date));

            $to_date    = date("Y-m-d",strtotime($to_date));
            $orders = $this->reportRepository->searchDailySummary($from_date, $to_date);
            return view('Backend.report.SaleSummaryReport')->with('orders',$orders)->with('to_date',$to_date)->with('from_date',$from_date);
        }
    }

    public function searchDailySummaryExport($start_date,$end_date){
        ob_end_clean();
        ob_start();
       
        // $orders = $this->reportRepository->searchDailySummary($start_date,$end_date);
        $orders = $this->reportRepository->DaySearchDailySummaryExport($start_date,$end_date);
        foreach ($orders as $key => $order) {
            $items[$key]['Day']                     = $order->Day;
            $items[$key]['Total Discount Amount']   = $order->DiscountAmount;
            $items[$key]['Total Tax Amount']        = $order->TaxAmount;
            $items[$key]['Total Service Amount']    = $order->ServiceAmount;
            $items[$key]['Total FOC Amount']        = $order->FocAmount;
            $items[$key]['Total Room Charge']       = $order->RoomAmount;
            $items[$key]['Total Extra Price']       = $order->ExtraAmount;
            $items[$key]['Total Price']             = $order->PriceAmount;
            $items[$key]['Total All Amount']        = $order->Amount;
        }
        Excel::create('SaleReport', function($excel)use($orders,$items) {
            $excel->sheet('Sale Report', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
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
                    $sum_discount   += $order->DiscountAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_foc        += $order->FocAmount;
                    $sum_room       += $order->RoomAmount;
                    $sum_extra      += $order->ExtraAmount;
                    $sum_price      += $order->PriceAmount;
                    $sum_amount     += $order->Amount;   
                }
                $sheet->appendRow(array(
                        'Total',
                        $sum_discount,
                        $sum_tax,
                        $sum_service,
                        $sum_foc,
                        $sum_room,
                        $sum_extra,
                        $sum_price,
                        $sum_amount
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
            alert()->warning('Please Choose Month You Want to Search!')->persistent('Close');
            return redirect()->back()->withInput();
        }else{
            $orders = $this->reportRepository->searchMonthlySummary($from_date,$to_date);

            return view('Backend.report.MonthlySaleSummaryReport')->with('orders',$orders)->with('to_month',$to_month)->with('from_month',$from_month);
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
        // $orders = $this->reportRepository->searchMonthlySummary($from_date,$to_date);
        $orders = $this->reportRepository->searchMonthlySummaryExport($from_date,$to_date);
        foreach ($orders as $key => $order) {
            $items[$key]['Year']                     = $order->Year;
            $items[$key]['Month']                    = date("F", mktime(0, 0, 0, $order->Month, 1));
            $items[$key]['Total Discount Amount']    = $order->DiscountAmount;
            $items[$key]['Total Tax Amount']         = $order->TaxAmount;
            $items[$key]['Total Service Amount']     = $order->ServiceAmount;
            $items[$key]['Total FOC Amount']         = $order->FocAmount;
            $items[$key]['Total Room Charge']        = $order->RoomAmount;
            $items[$key]['Total Extra Price']        = $order->ExtraAmount;
            $items[$key]['Total Price']              = $order->PriceAmount;
            $items[$key]['Total All Amount']         = $order->Amount;
        }
        Excel::create('MonthlySummaryReport', function($excel)use($orders,$items) {
            $excel->sheet('MonthlySummaryReport', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
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
                    $sum_discount,
                    $sum_tax,
                    $sum_service,
                    $sum_foc,
                    $sum_room,
                    $sum_extra,
                    $sum_price,
                    $sum_amount
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
        // $orders = $this->reportRepository->YearlySaleSummary();
        $orders = $this->reportRepository->YearlySaleSummaryExport();
        foreach ($orders as $key => $order) {
            $items[$key]['Year']                     = $order->Year;
            $items[$key]['Total Discount Amount']    = $order->DiscountAmount;
            $items[$key]['Total Tax Amount']         = $order->TaxAmount;
            $items[$key]['Total Service Amount']     = $order->ServiceAmount;
            $items[$key]['Total FOC Amount']         = $order->FocAmount;
            $items[$key]['Total Room Charge']        = $order->RoomAmount;
            $items[$key]['Total Extra Price']        = $order->ExtraAmount;
            $items[$key]['Total Price']              = $order->PriceAmount;
            $items[$key]['Total All Amount']         = $order->Amount;
        }
        Excel::create('YearlySaleReport', function($excel)use($orders,$items) {
            $excel->sheet('YearlySale Report', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
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
                    $sum_discount,
                    $sum_tax,
                    $sum_service,
                    $sum_foc,
                    $sum_room,
                    $sum_extra,
                    $sum_price,
                    $sum_amount
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
            return view('Backend.report.YearlySaleSummaryReport')->with('orders',$orders)->with('year',$year);
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
                    ->whereYear('order.order_time','=',$from_year)
                    ->where('order.status','=',$order_paid_status)
                    ->get(); 
        foreach ($orders as $key => $order) {
            $items[$key]['Year']                     = $order->Year;
            $items[$key]['Total Discount Amount']    = $order->DiscountAmount;
            $items[$key]['Total Tax Amount']         = $order->TaxAmount;
            $items[$key]['Total Service Amount']     = $order->ServiceAmount;
            $items[$key]['Total FOC Amount']         = $order->FocAmount;
            $items[$key]['Total Room Charge']        = $order->RoomAmount;
            $items[$key]['Total Extra Price']        = $order->ExtraAmount;
            $items[$key]['Total Price']              = $order->PriceAmount;
            $items[$key]['Total All Amount']         = $order->Amount;
        }
        Excel::create('YearlySummaryReport', function($excel)use($orders,$items) {
            $excel->sheet('YearlySummarySale Report', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
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
                    $sum_discount,
                    $sum_tax,
                    $sum_service,
                    $sum_foc,
                    $sum_room,
                    $sum_extra,
                    $sum_price,
                    $sum_amount
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
        return view('Backend.report.YearlySale')->with('orders',$orders)->with('y',$y);
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
                    $sum_discount   += $order->DiscountAmount;
                    $sum_tax        += $order->TaxAmount;
                    $sum_service    += $order->ServiceAmount;
                    $sum_foc        += $order->FocAmount;
                    $room_charge    += $order->RoomCharge;
                    $sum_extra      += $order->Extra;
                    $sum_amount     += $order->Amount; 
                }
                $sheet->appendRow(array('Total','','',$sum_quantity,$sum_discount,$sum_tax,$sum_service,$sum_foc,$room_charge,$sum_extra,$sum_amount));
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