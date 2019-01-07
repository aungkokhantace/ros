<?php

namespace App\Http\Controllers\Backend\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Faker\Provider\DateTime;
use App\RMS\SaleSummary\SaleSummaryRepositoryInterface;
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
use Auth;

class SaleSummaryReportController extends Controller
{
    private $orderRepository;

    public function __construct(SaleSummaryRepositoryInterface $saleSummaryRepository)
    {
        $this->reportRepository = $saleSummaryRepository;
    }

    public function saleSummary()
    {
        // $orders = $this->reportRepository->saleSummary();
    
        return view('Backend.reports.sale_summary.sale_summary');

    }

    public function search_query($type = null, $from = null, $to = null){
    	// dd($type,$from,$to);
    	try{
    		if( Auth::guard('Cashier')->check()){
    			$from_year      = null;
    			$to_year      	= null;

	            $from_month     = null;
	            $to_month       = null;

	            $from_date      = null;
	            $to_date        = null;
	          
	            if($type == "yearly"){
	                $from_year  = $from;
	                $to_year    = $to;
	            }
	            if($type == "monthly"){
	                $from_month = $from;
	                $to_month   = $to;
	            }
	            if($type == "daily"){
	                $from_date  = $from;
	                $to_date    = $to;
	            }
	            $orders 		= $this->reportRepository->sale_summary($type,$from,$to);
	           return view('Backend.reports.sale_summary.sale_summary')
		        ->with('orders',$orders)
		        ->with('from_year',$from_year)
		        ->with('to_year',$to_year)
                ->with('from_month',$from_month)
                ->with('to_month',$to_month)
                ->with('from_date',$from_date)            
              	->with('to_date',$to_date)             
                ->with('type',$type) ;
	            


    	 	}/* guard */

    	}
    	catch(\Exception $e){
    		dd($e);
    		  return redirect('/');
       
      	}
    	 


    }

     public function exportExcel($type = null, $from = null, $to = null){
    	// dd($type,$from,$to);
    	try{
    		if( Auth::guard('Cashier')->check()){
    			$from_year      = null;
    			$to_year      	= null;

	            $from_month     = null;
	            $to_month       = null;

	            $from_date      = null;
	            $to_date        = null;
	          
	            if($type == "yearly"){
	                $from_year  = $from;
	                $to_year    = $to;
	            }
	            if($type == "monthly"){
	                $from_month = $from;
	                $to_month   = $to;
	            }
	            if($type == "daily"){
	                $from_date  = $from;
	                $to_date    = $to;
	            }
	            ob_end_clean();
        		ob_start();
      
	            $orders 		= $this->reportRepository->sale_summary($type,$from,$to);
			    foreach ($orders as $key => $order) {
			    	if($type == "yearly"){
			    		$items[$key]['Year']                     = date('Y',strtotime($order->Day));	
			    	}else if($type == "monthly"){
			    		$items[$key]['Month']                     = date('m-Y',strtotime($order->Day));

			    	}else{
			    		$items[$key]['Day']                     = date('d-m-Y',strtotime($order->Day));
			    	}
		            // $items[$key]['Day']                     = $order->Day;
		            $items[$key]['Total Discount Amount']   = (string)$order->DiscountAmount;
		            $items[$key]['Total Tax Amount']        = $order->TaxAmount;
		            $items[$key]['Total Service Amount']    = $order->ServiceAmount;
		            if(is_null($order->FocAmount)){		            
		            $items[$key]['Total FOC Amount']        = (string)0;		           
		            }
		            else{
		            $items[$key]['Total FOC Amount']        = $order->FocAmount;
		            }
		            
		            $items[$key]['Total Room Charge']       = (string)$order->RoomAmount;
		            $items[$key]['Total Extra Price']       = (string)$order->ExtraAmount;
		            $items[$key]['Total Price']             = $order->PriceAmount;
		            $items[$key]['Total All Amount']        = $order->Amount;
		        }
		        Excel::create('SaleReport', function($excel)use($orders,$items) {
		        $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
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
		                    $row->setBackground('#3c8dbc');
		                });

		            });
		        })->download('xls');
		        ob_flush();
			            


    	 	}/* guard */

    	}
    	catch(\Exception $e){
    		dd($e);
    		  return redirect('/');
       
      	}
    	 


    }
}
