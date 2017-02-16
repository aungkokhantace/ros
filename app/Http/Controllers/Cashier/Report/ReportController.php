<?php
namespace App\Http\Controllers\Cashier\Report;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\RMS\Report\ReportRepositoryInterface;
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


class ReportController extends Controller
{
    private $orderRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }
    
    public function invoiceList()
    {
        $order = $this->reportRepository->getinvoice();

        return view('cashier.invoice.index',compact('orders'));

    } 

    //Item Report & Excel Download
    public function itemReport()
    {
        $start  = $this->reportRepository->getStartDate();
        $end    = $this->reportRepository->getEndDate();
        $orders = $this->reportRepository->getItemReport($start, $end);
        return view('cashier.report.itemReport', compact('orders', 'start', 'end'));
    }

    public function downloadItemReport(){
        ob_end_clean();
        ob_start();
        $start  = $this->reportRepository->getStartDate();
        $end    = $this->reportRepository->getEndDate();
        $orders = $this->reportRepository->getExcel($start, $end);

        Excel::create('BestSellingItemReport', function($excel)use($orders) {
            $excel->sheet('ItemReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','', '','Total Amount',$totalamt
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

    //Item Report With Date & Excel
    public function itemReportWithDate()
    {
        $start_date   = Date('Y-m-d',strtotime(Input::get('from')));
        $end_date     = Date('Y-m-d',strtotime(Input::get('to')));
        $from_amount  = Input::get('from_amount');
        $to_amount    = Input::get('to_amount');
        $number       = Input::get('number');
        $from_amt     = (double)$from_amount;
        $to_amt       = (double)$to_amount;
        if($start_date == "1970-01-01"||$end_date == "1970-01-01"){
            alert()->warning('Please Choose Date!')->persistent('Close');
//            return back();
            return redirect()->action('Cashier\ReportController@itemReport');
        }
        elseif(($from_amt != "" && $to_amt == "") || ($from_amt == "" && $to_amt != "")){
            alert()->warning('Please Choose Amount!')->persistent('Close');
            return redirect()->action('Cashier\ReportController@itemReport');
//            return back();
        }
        elseif($to_amt < $from_amt){
            alert()->warning('End Amount must be greater than Start Amount!')->persistent('Close');
            return redirect()->action('Cashier\ReportController@itemReport');
        }
        else{
            $orders = $this->reportRepository->getItemReportWithDate($start_date, $end_date,$number,$from_amount,$to_amount);
            return view('cashier.report.itemReport',compact('orders','start_date','end_date','number','from_amount','to_amount'));
        }
    }

    public function downloadItemReportWithDateAndNumber($start_date,$end_date,$number)
    {
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';

        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->getExcelWithDateAndNumber($start_date, $end_date,$number);
        Excel::create('BestSellingItemReport', function($excel)use($orders) {
            $excel->sheet('ItemReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);

                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','','','Total Amount',$totalamt
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

    public function downloadItemReportWithDateAndAmount($start_date,$end_date,$from_amount,$to_amount)
    {
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';
        $from_amount    = $from_amount;
        $to_amount      = $to_amount;
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->getExcelWithDateAndAmount($start_date, $end_date,$from_amount,$to_amount);
        Excel::create('BestSellingItemReport', function($excel)use($orders) {
            $excel->sheet('ItemReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);

                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','','','Total Amount',$totalamt
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

    public function downloadItemReportWithAll($start_date,$end_date,$number,$from_amount,$to_amount)
    {
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';
        $from_amount    = $from_amount;
        $to_amount      = $to_amount;
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->getExcelWithDate($start_date, $end_date,$number,$from_amount,$to_amount);
        Excel::create('BestSellingItemReport', function($excel)use($orders) {
            $excel->sheet('ItemReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);

                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','','','Total Amount',$totalamt
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
    
    public function downloadItemReportWithDateWithNull($start_date,$end_date)
    {
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->getExcelWithDateWithNull($start_date, $end_date);
        Excel::create('BestSellingItemReport', function($excel)use($orders) {
            $excel->sheet('ItemReport', function($sheet)use($orders) {
                $sheet->fromArray($orders);

                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '', '','','','Total Amount',$totalamt
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
    //END

    //Favourite Set Menu Report & Excel Download
    public function favourite_set_menus()
    {
        $start      = $this->reportRepository->getStartDate();
        $end        = $this->reportRepository->getEndDate();
        $sub_orders = $this->reportRepository->getset($start,$end);
        return view('cashier.report.sub_menus_report', compact('sub_orders', 'start', 'end'));
    }

    public function downloadsubReport(){
        ob_end_clean();
        ob_start();
        $start      = $this->reportRepository->getStartDate();
        $end        = $this->reportRepository->getEndDate();
        $orders     = $this->reportRepository->getset($start,$end);

        Excel::create('BestSellingSet_menusReport', function($excel)use($orders) {
            $excel->sheet('Set_menus_Report', function($sheet)use($orders) {

                $sheet->fromArray($orders);
                $total_amt=null;
                foreach($orders as $order){
                    $total_amt+=$order->Amount;
                }
                $sheet->appendRow(array(
                    '','','','','Total Amount',$total_amt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');
        ob_flush();
        return Redirect();
    }

    public function fav_set_date_report()
    {
        $start_date     = Date('Y-m-d',strtotime(Input::get('from')));
        $end_date       = Date('Y-m-d',strtotime(Input::get('to')));
        $number         = Input::get('number');
        if($start_date == "1970-01-01"||$end_date == "1970-01-01"){
            alert()->warning('Please Choose Date!')->persistent('Close');
            return back();
        }
        else{
            $sub_orders = $this->reportRepository->fav_set_date_report($start_date, $end_date, $number);
            return view('cashier.report.sub_menus_report')->with('start_date',$start_date)->with('end_date',$end_date)->with('sub_orders',$sub_orders)->with('number',$number);
        }
    }
    public function downloadsubReportWithDateWithNull($start_date,$end_date)
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->fav_set_date_report_with_null($start_date, $end_date);
        Excel::create('BestSellingSet_menusReport', function($excel)use($orders) {
            $excel->sheet('Set_menu_Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $total_amt=null;
                foreach($orders as $order){
                    $total_amt+=$order->Amount;
                }
                $sheet->appendRow(array(
                    '','','','','Total Amount',$total_amt
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
    public function downloadsubReportWithDate($start_date,$end_date,$number)
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->fav_set_date_report($start_date, $end_date, $number);
        Excel::create('BestSellingSet_menusReport', function($excel)use($orders) {
            $excel->sheet('Set_menu_Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $total_amt=null;
                foreach($orders as $order){
                    $total_amt+=$order->Amount;
                }
                $sheet->appendRow(array(
                  '','','','','Total Amount',$total_amt
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

    public function saleSummaryDetailReport_checked($checked){
        return view('cashier.report.SaleSummaryDetailReport')->with('checked',$checked);
    }
}

