<?php

namespace App\Http\Controllers\Cashier\Report;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\RMS\Sale\SaleRepositoryInterface;
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

class SaleReportController extends Controller
{
    private $orderRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->reportRepository = $saleRepository;
    }

    public function saleReport(){
        $orders = $this->reportRepository->saleReport();
        return view('cashier.report.SaleReport')->with('orders',$orders);
    }

    public function saleExport(){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->saleExcelReport();
        Excel::create('SaleReport', function($excel)use($orders) {
            $excel->sheet('Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $total = 0;
                foreach($orders as $order){
                    $total+=$order->Amount;
                }
                $sheet->appendRow(array('', '','','Total',$total));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');
        ob_flush();
        return Redirect();
    }

    public function search_detail(){
        $from   = Date('Y-m-d',strtotime(Input::get('from'))).' 00:00:00';
        $to     = Date('Y-m-d',strtotime(Input::get('to'))).' 23:00:00';

        if($from == "1970-01-01"){
            alert()->warning('Please Choose Date!')->persistent('Close');
            return back();
        }else{
           
            $orders = Order::leftjoin('order_details','order_details.order_id','=','order.id')->leftjoin('users','users.id','=','order.user_id')->select('order.id as invoice_id','order.order_time','users.user_name','order.all_total_amount as Amount', DB::raw('SUM(order_details.quantity) as Quantity'))->whereBetween('order.order_time',[$from,$to])
            ->where('order.status','1')
            ->where('order_details.deleted_at',NULL)
            ->groupBy('order.id')
            ->orderBy('order.order_time','desc')
            ->get();
        
            return view('cashier.report.SaleReport')->with('orders',$orders)->with('from',$from)->with('to',$to);
        }

    }

    public function SaleExportDetail($from,$to){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->saleExcelDetailReport($from,$to);
        Excel::create('SaleReport', function($excel)use($orders) {
            $excel->sheet('Sale Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $total = 0;
                foreach($orders as $order){
                    $total += $order->Amount;
                }
                $sheet->appendRow(array(
                    '', '','','Total',$total
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });

            });
        })->download('xls');
        ob_flush();
        return Redirect();

    }

}
