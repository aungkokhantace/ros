<?php

namespace App\Http\Controllers\Cashier\Report;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\RMS\CategorySaleSummary\CategorySaleSummaryRepositoryInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\Item\Item;

use Illuminate\Support\Facades\Input;
//use Input;
use Excel;
use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;

class CategorySaleSummaryReportController extends Controller
{
    private $orderRepository;

    public function __construct(CategorySaleSummaryRepositoryInterface $CategorySaleSummaryRepository)
    {
        $this->reportRepository = $CategorySaleSummaryRepository;
    }

    //Daily Detail Report & Excel
    public function DailyDetailReport(){
        $start      = $this->reportRepository->getStartDate();
        $end        = $this->reportRepository->getEndDate();
        $orders     = $this->reportRepository->DailyDetailReport();
        $category   = $this->reportRepository->getChildCategory();

        return view('cashier.report.SaleSummaryDetailReport')->with('orders',$orders)->with('start',$start)->with('end',$end)->with('category',$category);
    }

    public function saleSummaryDailyDetailExport(){
        ob_end_clean();
        ob_start();
        $start  = $this->reportRepository->getStartDate();
        $end    = $this->reportRepository->getEndDate();
        $orders = $this->reportRepository->saleSummaryDailyDetailExport($start, $end);

        Excel::create('DailySaleDetailReport', function($excel)use($orders) {
            $excel->sheet('DailyReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','Total Amount',$totalamt
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
    // End Daily Detail Report & Excel

    //SaleSummaryDetailReport With Date & Excel
    public function saleSummaryDetailReportWithDate(){
        $start_date    = Date('Y-m-d',strtotime(Input::get('from')));
        $end_date      = Date('Y-m-d',strtotime(Input::get('to')));
        $category      = $this->reportRepository->getChildCategory();
        $child         = Input::get('child_category');

        if($start_date == "1970-01-01"||$end_date == "1970-01-01"){
            alert()->warning('Please Choose Date!')->persistent('Close');
            return back();
        }
        else{
            $orders = $this->reportRepository->getDetailReportWithDate($start_date, $end_date,$child);
            
            return view('cashier.report.SaleSummaryDetailReport',compact('orders','start_date','end_date','category','child'));
        }

    }
  	
    public function saleSummaryDailyDetailExportWithDate($start_date,$end_date,$child){
        $start_date = $start_date.' 00:00:00';
        $end_date   = $end_date.' 23:00:00';
        $child      = $child;
        ob_end_clean();
        ob_start();
        $orders     = $this->reportRepository->saleSummaryDailyDetailExportWithDate($start_date, $end_date,$child);
        Excel::create('DailySaleDetailReport', function($excel)use($orders) {
            $excel->sheet('DailyReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $totalamt = null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','Total Amount',$totalamt
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
    //End SaleSummaryDetailReport With Date & Excel

    //Sale Summary Detail Report (Daily/Monthly/Yearly) & Excel Download
    public function saleSummaryDetailReport($checked)
    {
        $start  = $this->reportRepository->getStartDate();
        $end    = $this->reportRepository->getEndDate();
        $category = $this->reportRepository->getChildCategory();
        if(isset($checked)){
            if($checked == "daily"){
                $orders = $this->reportRepository->DailyDetailReport();
            }
            else if($checked == "monthly"){
                $orders = $this->reportRepository->MonthlyDetailReport();
            }
            else{
                $orders = $this->reportRepository->YearlyDetailReport();
            }
        }
        else{
            $orders = $this->OrdeRepository->DailyDetailReport();
        }
        return view('cashier.report.SaleSummaryDetailReport')->with('orders',$orders)->with('checked',$checked)->with('start',$start)->with('end',$end)->with('category',$category);
    }
    //End Sale Summary Detail Report (Daily/Monthly/Yearly) & Excel Download

    public function saleSummaryMonthlyDetailExport(){
        ob_end_clean();
        ob_start();
        $start  = $this->reportRepository->getStartDate();
        $end    = $this->reportRepository->getEndDate();
        $orders = $this->reportRepository->saleSummaryMonthlyDetailExport($start, $end);
        Excel::create('MonthlySaleDetailReport', function($excel)use($orders) {
            $excel->sheet('MonthlyReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','Total Amount',$totalamt
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

    public function saleSummaryYearlyDetailExport(){
        ob_end_clean();
        ob_start();
        $start  = $this->reportRepository->getStartDate();
        $end    = $this->reportRepository->getEndDate();
        $orders = $this->reportRepository->saleSummaryYearlyDetailExport($start, $end);
        Excel::create('YearlySaleDetailReport', function($excel)use($orders) {
            $excel->sheet('YearlyReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','Total Amount',$totalamt
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

    //Sale Summary Yearly Detail Report With Date & Excel Download
    public function saleSummaryYearlyDetailReportWithDate($checked){
        $year       = Input::get('year_pick');
        $child      = Input::get('child_category');
        $category   = $this->reportRepository->getChildCategory();
        $orders     = $this->reportRepository->getYearlyDetailReportWithDate($year,$child);
        return view('cashier.report.SaleSummaryDetailReport',compact('orders','year','checked','child','category'));
    }

    public function saleSummaryYearlyDetailExportWithDate($year,$child){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->saleSummaryYearlyDetailExportWithDate($year,$child);
        Excel::create('YearlySaleDetailReport', function($excel)use($orders) {
            $excel->sheet('YearlyReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','Total Amount',$totalamt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');
        ob_flush();
        return Redirect();
    }//End

    //Sale Summary Monthly Detail Report With Date & Excel Download
    public function saleSummaryMonthlyDetailReportWithDate($checked){
        $from_month_picked  = Input::get('from_month');
        $to_month_picked    = Input::get('to_month');
        $child              = Input::get('child_category');
        $category           = $this->reportRepository->getChildCategory();
        $from               = "01-".Input::get('from_month');
        $to                 = "31-".Input::get('to_month');
        $from_date          = date("Y-m-d",strtotime($from));
        $to_date            = date("Y-m-d",strtotime($to));
        $orders = $this->reportRepository->getMonthlyDetailReportWithDate($from_date,$to_date,$child);
        return view('cashier.report.SaleSummaryDetailReport',compact('orders','checked','from_month_picked','to_month_picked','child','category'));
    }
    public function saleSummaryMonthlyDetailExportWithDate($from,$to,$child){

        ob_end_clean();
        ob_start();
        $from_month = "01-".$from;
        $to_month   = "31-".$to;
        $child      = $child;
        $from_date  = date("Y-m-d",strtotime($from_month));
        $to_date    = date("Y-m-d",strtotime($to_month));
        $orders     = $this->reportRepository->saleSummaryMonthlyDetailExportWithDate($from_date, $to_date,$child);
        Excel::create('MonthlySaleDetailReport', function($excel)use($orders) {
            $excel->sheet('MonthlyReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','Total Amount',$totalamt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
            ->download('xls');
        ob_flush();
        return Redirect();
    }//END
 
}
