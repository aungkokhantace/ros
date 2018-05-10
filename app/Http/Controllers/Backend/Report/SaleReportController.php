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
        // $orders = $this->reportRepository->saleReport();
        // return view('Backend.report.SaleReport')->with('orders',$orders);
        return view('Backend.report.SaleReport');
    }

    public function saleExport(){
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->saleExcelReport();

        foreach ($orders as $key => $order) {
            $items[$key]['Invoice ID']               = $order->InvoiceID;
            $items[$key]['Date']                     = $order->Date;
            $items[$key]['Cashier']                  = $order->Cashier;
            $items[$key]['Quantity']                 = $order->Quantity;
            $items[$key]['Total Discount Amount']    = $order->Discount;
            $items[$key]['Total Tax Amount']         = $order->Tax;
            $items[$key]['Total Service Amount']     = $order->Service;
            $items[$key]['Total Room Charge']        = $order->RoomCharge;
            $items[$key]['Total FOC Amount']         = $order->Foc;
            $items[$key]['Total Extra Price']        = $order->Extra;
            $items[$key]['Total Amount']             = $order->Amount;
        }
        Excel::create('SaleReport', function($excel)use($orders,$items) {
            $excel->sheet('Sale Report', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
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
        $from   = Input::get('from');
        $to     = Input::get('to');

        $from_time   = Date('Y-m-d',strtotime(Input::get('from'))).' 00:00:00';
        $to_time     = Date('Y-m-d',strtotime(Input::get('to'))).' 23:00:00';
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;
        $kitchen_cancel         = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        $customer_cancel        = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
        $status_array           = array($kitchen_cancel,$customer_cancel);
        if($from == "" || $to == ""){
            alert()->warning('Please Choose Date!')->persistent('Close');
            return redirect()->back()->withInput();
        }else{
           
            $orders = Order::leftjoin('order_details','order_details.order_id','=','order.id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->select(
                'order.id as invoice_id',
                'order.order_time',
                'users.user_name',
                'order.all_total_amount as Amount',
                'order.payment_amount as Payment',
                'order.refund as Refund',
                'order.service_amount as Service',
                'order.tax_amount as Tax',
                'order.room_charge as RoomCharge',
                'order.total_extra_price as Extra',
                'order.total_discount_amount as Discount',
                'order.foc_amount as Foc', 
            DB::raw('SUM(order_details.quantity) as Quantity'))
            ->whereBetween('order.order_time',[$from_time,$to_time])
            ->where('order.status',$order_paid_status)
            ->where('order_details.deleted_at',NULL)
            ->whereNotIn('order_details.status_id',$status_array)
            ->groupBy('order.id')
            ->orderBy('order.order_time','desc')
            ->get();
        
            return view('Backend.report.SaleReport')->with('orders',$orders)->with('from',$from)->with('to',$to);
        }

    }

    public function SaleExportDetail($from,$to){
        $from_time   = Date('Y-m-d',strtotime($from)).' 00:00:00';
        $to_time     = Date('Y-m-d',strtotime($to)).' 23:00:00';
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->saleExcelDetailReport($from_time,$to_time);

        foreach ($orders as $key => $order) {
            $items[$key]['Invoice ID']               = $order->InvoiceID;
            $items[$key]['Date']                     = $order->Date;
            $items[$key]['Cashier']                  = $order->Cashier;
            $items[$key]['Quantity']                 = $order->Quantity;
            $items[$key]['Total Discount Amount']    = $order->Discount;
            $items[$key]['Total Tax Amount']         = $order->Tax;
            $items[$key]['Total Service Amount']     = $order->Service;
            $items[$key]['Total Room Charge']        = $order->RoomCharge;
            $items[$key]['Total FOC Amount']         = $order->Foc;
            $items[$key]['Total Extra Price']        = $order->Extra;
            // $items[$key]['Total Amount']             = $order->Amount;
        }
        Excel::create('SaleReport', function($excel)use($orders,$items) {
            $excel->sheet('Sale Report', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
                // $sum_amount=0;
                // $sum_payment=0;
                // $sum_refund=0;
                // $sum_service=0;
                // $sum_tax=0;
                // $sum_discount=0;
                // $sum_foc=0;
                // $sum_quantity = 0;
                // $sum_room = 0;
                // $sum_extra = 0;
                // foreach($orders as $order){
                //     $sum_amount     += $order->Amount;
                //     $sum_refund     += $order->Refund;
                //     $sum_service    += $order->Service;
                //     $sum_tax        += $order->Tax;
                //     $sum_discount   += $order->Discount;
                //     $sum_foc        += $order->Foc;
                //     $sum_quantity   += $order->Quantity;
                //     $sum_room       += $order->RoomCharge;
                //     $sum_extra      += $order->Extra;
                // }
                // $sheet->appendRow(array(
                //     '', '','Total',$sum_quantity,$sum_discount,$sum_tax,$sum_service,$sum_room,$sum_foc,$sum_extra,$sum_amount
                // ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });

            });
        })->download('xls');
        ob_flush();
        return Redirect();

    }

    public function ajaxRequest(Request $request) {
        $limit              = (int)($request->input('length'));
        $start              = (int)($request->input('start'));
        $order_paid_status  = StatusConstance::ORDER_PAID_STATUS;
        $kitchen_cancel     = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        $customer_cancel    = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
        $status_array       = array($kitchen_cancel,$customer_cancel);
        $orders = Order::leftjoin('order_details','order_details.order_id','=','order.id')
                ->leftjoin('users','users.id','=','order.user_id')
                ->select(
                    'order.id as invoice_id',
                    'order.order_time',
                    'order.all_total_amount as Amount',
                    'order.payment_amount as Payment',
                    'order.refund as Refund',
                    'order.service_amount as Service',
                    'order.tax_amount as Tax',
                    'order.total_discount_amount as Discount',
                    'order.room_charge as RoomCharge',
                    'order.total_extra_price as Extra',
                    'order.foc_amount as Foc'
                ,'users.user_name',DB::raw('SUM(order_details.quantity) as Quantity'))
                ->where('order.status','=',$order_paid_status)
                ->where('order_details.deleted_at',NULL)
                ->whereNotIn('order_details.status_id',$status_array)
                ->groupBy('order.id')
                ->orderBy('order.order_time','desc')
                ->offset($start)
                ->limit($limit)
                ->get();
        $totalData          = $this->reportRepository->saleReport()->count();
        $totalFiltered      = $totalData;

        $data = array();
        if(!empty($orders))
        {
            foreach ($orders as $order)
            {

                $nestedData[0] = $order->invoice_id;
                $nestedData[1] = date('d-m-Y',strtotime($order->order_time));
                $nestedData[2] = $order->user_name;
                $nestedData[3] = $order->Quantity;
                $nestedData[4] = $order->Discount;
                $nestedData[5] = $order->Tax;
                $nestedData[6] = $order->Service;
                $nestedData[7] = $order->RoomCharge;
                $nestedData[8] = $order->Foc;
                $nestedData[9] = $order->Extra;
                $nestedData[10]= $order->Amount;
                $data[] = $nestedData;

            }
        }

        $array      = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data 
                        );
        return \Response::json($array);
    }

}
