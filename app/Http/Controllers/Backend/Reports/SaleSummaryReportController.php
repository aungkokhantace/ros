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
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use App\Session;
use App\RMS\Reports_update\Invoice\InvoiceRepository;


class SaleSummaryReportController extends Controller
{
    private $orderRepository;

    public function __construct(SaleSummaryRepositoryInterface $saleSummaryRepository)
    {
        $this->reportRepository = $saleSummaryRepository;
        $this->invoiceRepo 		= new InvoiceRepository();
    }

    public function saleSummary()
    {   

    	$type 			= "Daily";
    	$orders 		= $this->reportRepository->get_last_order_day();    	
    	$from 			= $orders;
    	$to 			= $orders;
    	

    	$orders 		= $this->reportRepository->sale_summary($type,$from,$to);
	           return view('Backend.reports.sale_summary.sale_summary')
		        ->with('orders',$orders)		       
                ->with('from_date',$from)            
              	->with('to_date',$to)             
                ->with('type',$type) ; 
        return view('Backend.reports.sale_summary.sale_summary');
	}

    public function search_query($type = null, $from = null, $to = null){    	
    	try{
    		if( Auth::guard('Cashier')->check()){
    			$from_year      = null;
    			$to_year      	= null;

	            $from_month     = null;
	            $to_month       = null;

	            $from_date      = null;
	            $to_date        = null;
	          
	            if($type == "Yearly"){
	                $from_year  = $from;
	                $to_year    = $to;
	                // session()->put('from_year', $from_year);	               
	            }
	            if($type == "Monthly"){
	                $from_month = $from;
	                $to_month   = $to;
	               
	            }
	            if($type == "Daily"){
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
    		
    		  return redirect('/') ->withMessage(FormatGenerator::message('Error..', 'There is an error in Sale Summary Report ...'));       
      	}  	 
      }

     public function exportExcel($type = null, $from = null, $to = null){
    	try{
    		if( Auth::guard('Cashier')->check()){
    			$from_year      = null;
    			$to_year      	= null;

	            $from_month     = null;
	            $to_month       = null;

	            $from_date      = null;
	            $to_date        = null;
	          
	            if($type == "Yearly"){
	                $from_year  = $from;
	                $to_year    = $to;
	            }
	            if($type == "Monthly"){
	                $from_month = $from;
	                $to_month   = $to;
	            }
	            if($type == "Daily"){
	                $from_date  = $from;
	                $to_date    = $to;
	            }
	            ob_end_clean();
        		ob_start();
      
	            $orders 		= $this->reportRepository->sale_summary($type,$from,$to);
	           if(count($orders)>0){
	           		foreach ($orders as $key => $order) {	
	           		if ($type =="Yearly") {
	           			$items[$key]['Year']              = date('Y',strtotime($order->ShiftDate));
	           		}
	           		elseif ($type=="Monthly") {
	           			$items[$key]['Month']              = date('m-Y',strtotime($order->ShiftDate));
	           		}
	           		else{
	           			$items[$key]['Day']              = date('d-m-Y',strtotime($order->ShiftDate));

	           		}		    
		            // $items[$key]['Shift Date']              = $order->ShiftDate;
		            // $items[$key]['Order Time']              = $order->Day;
		            $items[$key]['Total Discount Amount']   = (string)number_format($order->DiscountAmount);
		            $items[$key]['Total Tax Amount']        = (string)number_format($order->TaxAmount);
		            $items[$key]['Total Service Amount']    = (string)number_format($order->ServiceAmount);          
		            
		            $items[$key]['Total Room Charge']       = (string)number_format($order->RoomAmount);
		            $items[$key]['Total Extra Price']       = (string)number_format($order->ExtraAmount);
		            $items[$key]['Sub Total']       		= number_format($order->SubTotal);
		            $items[$key]['Total Net Amount']        = number_format($order->NetAmount);
		            $items[$key]['Total All Amount']        = number_format($order->TotalAmount);
		           
		        }
		        Excel::create('SaleReport', function($excel)use($orders,$items) {
		        $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		            $excel->sheet('Sale Report', function($sheet)use($orders,$items) {
		                $sheet->fromArray($items);
		                	$sum_discount   = 0;
                            $sum_tax        = 0;
                            $sum_service    = 0;
                            $sum_room       = 0;
                            $sum_extra      = 0;
                            $sum_subtotal   = 0;
                            $sum_net        = 0;
                            $sum_amount     = 0;     
		                foreach($orders as $order){
		                    $sum_discount   += $order->DiscountAmount;
                            $sum_tax        += $order->TaxAmount;
                            $sum_service    += $order->ServiceAmount;
                            $sum_room       += $order->RoomAmount;
                            $sum_extra      += $order->ExtraAmount;
                            $sum_subtotal   += $order->SubTotal;
                            $sum_net        += $order->NetAmount;
                            $sum_amount     += $order->TotalAmount;        
		                }
		                $sheet->appendRow(array(
		                        'Total',		                        
		                        number_format($sum_discount),
		                        number_format($sum_tax),
		                        number_format($sum_service),		                       
		                        number_format($sum_room),
		                        number_format($sum_extra),
		                        number_format($sum_subtotal),
		                        number_format($sum_net),		                      
		                        number_format($sum_amount)
		                        ));	              

		                $sheet->row(1,function($row){
		                    $row->setBackground('#3c8dbc');
		                });
		                 /* to add background in total */
		                $row 			= count($items);		                 
	                    $current_row 	= '1'; 
	                        for($i=0; $i <= $row; $i++) 
	                        {                          
	                          $current_row++;
	                        } 
	                        // dd($current_row);
	                     /* to add background in total */
		                $sheet->cell('A'.$current_row.':J'.$current_row, function($cell) {
                            $cell->setBackground('#3c8dbc');                            
                      	});

		            });
		        })->download('xls');
		        ob_flush();
			            

	           }//count >0
	           else{
	           	return redirect()->action('Backend\Reports\SaleSummaryReportController@saleSummary')
                ->withMessage(FormatGenerator::message('Oops..', 'There is no data on this day ...'));
	           }
    	 	}/* guard */

    	}
    	catch(\Exception $e){	    		
    		  return redirect('/')
    		  ->withMessage(FormatGenerator::message('Error..', 'There is an error in Sale Summary Report ...'));
    	} 	 
	}
    public function summary_detail($date,$type,$from=null,$to=null){

    	$orders 		= $this->reportRepository->sale_summary_detail($date, $type);
        return view('Backend.reports.sale_summary.sale_detail')
        ->with('orders',$orders)
        ->with('date',$date)
        ->with('type',$type)
        ->with('from',$from)
        ->with('to',$to);

    }

    public function summary_detail_sort($date,$type,$sort,$from=null,$to=null){    	
    	$orders 		= $this->reportRepository->sale_summary_detail_sort($date, $type,$sort);

    	  return view('Backend.reports.sale_summary.sale_detail')
    	  ->with('orders',$orders)
    	  ->with('date',$date)
    	  ->with('type',$type)
    	  ->with('sort',$sort)
    	  ->with('from',$from)
    	  ->with('to',$to);

    }

    public function summary_detail_sort_export($date,$type,$sort){
    		try{
    		if( Auth::guard('Cashier')->check()){    			
	            ob_end_clean();
        		ob_start();
      
	          $orders 			= $this->reportRepository->sale_summary_detail_sort($date, $type,$sort);
	           if(count($orders)>0){
	           	foreach ($orders as $key => $order) {		    	
		           
		            $items[$key]['Voucher No']              	= $order->invoice_id;
		            if($type == "Yearly"){
		            	$items[$key]['Year']              		= date('Y',strtotime($date.'-01-01'));
		            }elseif ($type == "Monthly") {
		           	 	$items[$key]['Month']              	= date('m-Y',strtotime($date.'-01'));
		            }
		            else{
		            	$items[$key]['Day']              		= date('d-m-Y',strtotime($date));
		            }
		         
		            // $items[$key]['Order Time']              = $order->Date;
		            $items[$key]['Staff']   				= $order->Staff;		         
		            $items[$key]['Discount']    		= (string)number_format($order->Discount);		            
		            $items[$key]['Tax']        				= (string) number_format($order->Tax);            
		            
		            $items[$key]['Service']       			= (string)number_format($order->Service);
		            $items[$key]['Room Charge']             = (string)number_format($order->Room);
		            $items[$key]['Extra']        			= (string)number_format($order->Extra);
		            $items[$key]['Quantity']        		= number_format($order->Quantity);
		            $items[$key]['Sub Total']			    = number_format($order->SubTotal);
		            $items[$key]['Net Amount']			    = number_format($order->NetAmount);
		            $items[$key]['Total Amount']			= number_format($order->Amount);

		        }
		        Excel::create('Sale_Report_Detail'.$type, function($excel)use($orders,$items) {
		        $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		            $excel->sheet('Sale Report', function($sheet)use($orders,$items) {
		                $sheet->fromArray($items);
		                	$sum_discount   = 0;
                            $sum_tax        = 0;
                            $sum_service    = 0;
                            $sum_room       = 0;
                            $sum_extra      = 0;
                            $sum_qty        = 0;
                            $sum_subtotal   = 0;
                            $sum_net        = 0;
                            $sum_amount     = 0;
		                foreach($orders as $order){
		                    $sum_discount   += $order->Discount;
                            $sum_tax        += $order->Tax;
                            $sum_service    += $order->Service;
                            $sum_room       += $order->Room;
                            $sum_extra      += $order->Extra;
                            $sum_qty        += $order->Quantity;
                            $sum_subtotal   += $order->SubTotal;
                            $sum_net        += $order->NetAmount;
                            $sum_amount     += $order->Amount; 
		                }
		                $sheet->appendRow(array(

		                        'Total',		                       
		                        '',
		                        '',
		                        number_format($sum_discount),
								number_format($sum_tax),
								number_format($sum_service),
								number_format($sum_room),
								number_format($sum_extra),
								number_format($sum_qty),
								number_format($sum_subtotal),
								number_format($sum_net),
								number_format($sum_amount),
		                     ));	              

		                $sheet->row(1,function($row){
		                    $row->setBackground('#3c8dbc');
		                });
		                /* to add background in total */
		                $row 			= count($items);		                 
	                    $current_row 	= '1'; 
	                        for($i=0; $i <= $row; $i++) 
	                        {                          
	                          $current_row++;
	                        } 
	                        // dd($current_row);
	                     /* to add background in total */
		                $sheet->cell('A'.$current_row.':L'.$current_row, function($cell) {
                            $cell->setBackground('#3c8dbc');                            
                      	});

		            });
		        })->download('xls');
		        ob_flush();
			            

	           }//count >0
	           else{
	           	return redirect()->action('Backend\Reports\sale_SummaryReport\detail\{$date}\{$type}\{$sort}@saleSummary')
                ->withMessage(FormatGenerator::message('Oops..', 'There is no data on this day ...'));
	           }



    	 	}/* guard */

    	}
    	catch(\Exception $e){    		
    		  return redirect('/') ->withMessage(FormatGenerator::message('Error..', 'There is an error in Sale Summary Report ...'));
    	}
    
    	

    }

    public function invoice_detail($invoice_id,$date,$type,$from=null,$to=null){
     $orders 		= $this->invoiceRepo->getorder($invoice_id);
     // dd($orders);
        $add    	= $this->invoiceRepo->getaddon($invoice_id);
        // dd($add);
        $total  	= $this->invoiceRepo->getaddonAmount($invoice_id);
        $continent  = $this->invoiceRepo->getContinent();
        $addon  	= array();
        foreach($add as $dd){
            foreach($dd as $d){
                $addon[] = $d;
            }
        }
        $amount 	= array();
        foreach($total as $t){
            foreach($t as $tt){
                $amount[] = $tt;
            }
        }
        $order_detail   = $this->invoiceRepo->getdetail($invoice_id);       
        $tables         = $this->invoiceRepo->orderTable($invoice_id);
        $rooms          = $this->invoiceRepo->orderRoom($invoice_id);
        $cashier        = $this->invoiceRepo->cashier($invoice_id);
        $config 		= $this->invoiceRepo->config();

        $order_arry 	= array();

        /*$v='';


        $item = array();

        $collection_array = $order_detail->toArray();

        foreach($collection_array as $key => $value)
        {
            $item[$key] = $value['item_id'];
        }
        array_multisort($item, SORT_ASC, $collection_array);

        $details = collect($collection_array);    

        $addOn = array();

        foreach($addon as $key => $value)
        {   
            $addOn[$key] = $value['extra_id'];
        }
        array_multisort($addOn, SORT_ASC, $addon);
        $addon = $addon;  */

        return view('Backend.reports.sale_summary.invoice_detail',compact('orders','order_detail','addon','amount','config','tables','rooms','cashier','continent','invoice_id','config','date','type','from','to'));

		// return view('Backend.reports.sale_summary.invoice_detail',compact('details','order','order_detail','addon','amount','config','tables','rooms','cashier','continent','date','type','from','to','invoice_id','orders'));
        	// compact('orders','order_detail','addon','amount','config','tables','rooms','cashier','continent','invoice_id','config','date','type','from','to','order_arr'));
    }
}
