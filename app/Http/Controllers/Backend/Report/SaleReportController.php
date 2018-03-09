<?php

namespace App\Http\Controllers\Backend\Report;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\RMS\Sale\SaleRepositoryInterface;
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

class SaleReportController extends Controller
{
    private $orderRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->reportRepository = $saleRepository;
    }

    public function saleReport(){
        $orders = $this->reportRepository->saleReport();
        return view('Backend.report.SaleReport')->with('orders',$orders);
    }

    public function saleExport(){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->saleExcelReport();
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
                $sum_room = 0;
                $sum_extra = 0;
                $sum_quantity = 0;
                foreach($orders as $order){
                    $sum_discount   += $order->Discount;
                    $sum_tax        += $order->Tax;
                    $sum_service    += $order->Service;
                    $sum_foc        += $order->Foc;
                    $sum_amount     += $order->Amount;
                    $sum_payment    += $order->Payment;
                    $sum_room       += $order->RoomCharge;
                    $sum_extra      += $order->Extra;
                    $sum_quantity   += $order->Quantity;
                }
                $sheet->appendRow(array('', '','Total',$sum_quantity,$sum_discount,$sum_tax,$sum_service,$sum_room,$sum_foc,$sum_extra,$sum_amount));
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
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        if($from == "1970-01-01"){
            alert()->warning('Please Choose Date!')->persistent('Close');
            return back();
        }else{
           
            $orders = Order::leftjoin('order_details','order_details.order_id','=','order.id')
            ->leftjoin('users','users.id','=','order.user_id')->select('order.id as invoice_id','order.order_time','users.user_name','order.all_total_amount as Amount','order.payment_amount as Payment','order.refund as Refund',
        'order.service_amount as Service','order.tax_amount as Tax','order.total_discount_amount as Discount','order.foc_amount as Foc', DB::raw('SUM(order_details.quantity) as Quantity'))->whereBetween('order.order_time',[$from,$to])
            ->where('order.status',$order_paid_status)
            ->where('order_details.deleted_at',NULL)
            ->groupBy('order.id')
            ->orderBy('order.order_time','desc')
            ->get();
        
            return view('Backend.report.SaleReport')->with('orders',$orders)->with('from',$from)->with('to',$to);
        }

    }

    public function SaleExportDetail($from,$to){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->saleExcelDetailReport($from,$to);
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
                $sum_quantity = 0;
                $sum_room = 0;
                $sum_extra = 0;
                foreach($orders as $order){
                    $sum_amount     += $order->Amount;
                    $sum_refund     += $order->Refund;
                    $sum_service    += $order->Service;
                    $sum_tax        += $order->Tax;
                    $sum_discount   += $order->Discount;
                    $sum_foc        += $order->Foc;
                    $sum_quantity   += $order->Quantity;
                    $sum_room       += $order->RoomCharge;
                    $sum_extra      += $order->Extra;
                }
                $sheet->appendRow(array(
                    '', '','Total',$sum_quantity,$sum_discount,$sum_tax,$sum_service,$sum_room,$sum_foc,$sum_extra,$sum_amount
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
