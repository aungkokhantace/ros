<?php

namespace App\Http\Controllers\Backend\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RMS\Config\Config;
use App\Status\StatusConstance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use PDF;
use Excel;
use App;
use App\RMS\Utility;
use Response;
use Hash;
use App\User;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use App\RMS\Reports_update\Invoice\InvoiceRepositoryInterface;
use App\RMS\Order\Order;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Item\Item;
use App\RMS\SaleSummary\SaleSummaryRepository;
use Auth;

class InvoiceCancelReportController extends Controller
{
     private $InvoiceRepository;

    public function __construct(InvoiceRepositoryInterface $InvoiceRepository)
    {
        $this->InvoiceRepository 	= $InvoiceRepository;
        $this->saleRepo 			= new SaleSummaryRepository();
    }

     public function invoiceCancel() {

        $orders 			= $this->saleRepo->get_last_order_day(); 
    	$from_date 			= $orders;
    	$to_date 			= $orders;
    	$ordersCancel 		= $this->InvoiceRepository->getinvoiceCancel($from_date,$to_date);   	
      
        return view('Backend.reports.invoice_cancel.invoice_cancel',compact('from_date','to_date','ordersCancel'));
    }

    public function invoiceCancel_Search($from_date=null,$to_date=null){
    	try{
            if( Auth::guard('Cashier')->check()){  	
     
      		$ordersCancel   = $this->InvoiceRepository->getinvoiceCancel($from_date,$to_date);
     
         	
        return view('Backend.reports.invoice_cancel.invoice_cancel',compact('from_date','to_date','ordersCancel'));
         }/* guard */

        }
        catch(\Exception $e){     
            return redirect('/')
                ->withMessage(FormatGenerator::message('Fail..', 'Error in reports ...'));    
        }    

    }
     public function export($from_date = null, $to_date = null){
    	try{

        if( Auth::guard('Cashier')->check()){	
         ob_end_clean();
         ob_start();     	
		 $ordersCancel 			= $this->InvoiceRepository->getinvoiceCancel($from_date,$to_date); 
       	 if(count($ordersCancel)>0){
           	foreach ($ordersCancel as $key => $order) {		    	
	           
	            $items[$key]['Voucher No']              = $order->invoice_id;          
	         	$items[$key]['Staff']   				= $order->Staff;		         
	            $items[$key]['Discount']    			= (string)number_format($order->Discount);		            
	            $items[$key]['Tax']        				= (string) number_format($order->Tax);            
	            
	            $items[$key]['Service']       			= (string)number_format($order->Service);
	            $items[$key]['Room Charge']             = (string)number_format($order->Room);
	            $items[$key]['Extra']        			= (string)number_format($order->Extra);
	            $items[$key]['Quantity']        		= number_format($order->Quantity);
	            $items[$key]['Sub Total']			    = number_format($order->SubTotal);
	            $items[$key]['Net Amount']			    = number_format($order->NetAmount);
	            $items[$key]['Total Amount']			= number_format($order->Amount);

	        }
		        Excel::create('Cancel Vocher Listing', function($excel)use($ordersCancel,$items) {
		        $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		            $excel->sheet('Cancel Vocher Listing', function($sheet)use($ordersCancel,$items) {
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
		                foreach($ordersCancel as $order){
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
		                $sheet->cell('A'.$current_row.':K'.$current_row, function($cell) {
                            $cell->setBackground('#3c8dbc');                            
                      	});

		            });
		        })->download('xls');
		        ob_flush();
			            

	           }//count >0
	           else{
	           	return redirect('/')
                ->withMessage(FormatGenerator::message('Oops..', 'There is no data on this day ...'));
	           }



    	 	}/* guard */

    	}
    	catch(\Exception $e){ 	
    		  return redirect('/') ->withMessage(FormatGenerator::message('Error..', 'There is an error in Sale Summary Report ...'));
    	}
    }
     public function invoice_detail($invoice_id,$from=null,$to=null){
    try{
     $orders 		= $this->InvoiceRepository->getorder($invoice_id);
     // dd($orders);
        $add    	= $this->InvoiceRepository->getaddon($invoice_id);
        // dd($add);
        $total  	= $this->InvoiceRepository->getaddonAmount($invoice_id);
        $continent  = $this->InvoiceRepository->getContinent();
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
        $order_detail   = $this->InvoiceRepository->getdetail_cancel($invoice_id);
        $tables         = $this->InvoiceRepository->orderTable($invoice_id);
        $rooms          = $this->InvoiceRepository->orderRoom($invoice_id);
        $cashier        = $this->InvoiceRepository->cashier($invoice_id);
        $config 		= $this->InvoiceRepository->config();
      
    	// dd($orders);

        return view('Backend.reports.invoice_cancel.invoice_detail',compact('orders','order_detail','addon','amount','config','tables','rooms','cashier','continent','invoice_id','config','from','to'));
        }
        catch(\Exception $e){   
              return redirect('/') ->withMessage(FormatGenerator::message('Error..', 'There is an error in Sale Summary Report ...'));
        }
    }

}
