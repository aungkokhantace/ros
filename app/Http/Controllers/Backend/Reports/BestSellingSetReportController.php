<?php

namespace App\Http\Controllers\Backend\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Faker\Provider\DateTime;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\Item\Item;
use App\Status\StatusConstance;
use Illuminate\Support\Facades\Input;
use Excel;
use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use Auth;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use App\Session;
use App\RMS\SaleSummary\SaleSummaryRepository;
use App\RMS\Reports_update\BestSellingSet\BestSellingSetRepositoryInterface;

class BestSellingSetReportController extends Controller
{
     private $BestSetRepo;

    public function __construct(BestSellingSetRepositoryInterface $BestSetRepo)
    {
        $this->BestSetRepo 		= $BestSetRepo;
        $this->saleRepo 		= new SaleSummaryRepository();
    }

    public function index(){
    	try{
    		if( Auth::guard('Cashier')->check()){    			
    			$orders 		= $this->saleRepo->get_last_order_day();    	
		    	$from 			= $orders;
		    	$to 			= $orders;
		    	$orders_item    = $this->BestSetRepo->best_set($from,$to);		    	
		    	return view('Backend.reports.best_set_menu.best_set_menu')->with('from_date',$from)
    													->with('to_date',$to)           
                                              			->with('orders',$orders_item);


			}/* guard */
			else{
				 return redirect('/');
			}

    	}
    	catch(\Exception $e){   		
    		  return redirect('/') ->withMessage(FormatGenerator::message('Error..', 'There is an error in Sale Summary Report ...'));       
      	}	 
    }
    public function search($from_date =null ,$to_date=null,$number=null,$from_amount =null,$to_amount =null){
    	try{
    		if( Auth::guard('Cashier')->check()){   			
    			
		    	$orders_item    = $this->BestSetRepo->best_set($from_date,$to_date,$number,$from_amount,$to_amount);	    	
		    	return view('Backend.reports.best_set_menu.best_set_menu')->with('from_date',$from_date)
    													->with('to_date',$to_date)  
    													->with('number',$number)
    													->with('from_amount',$from_amount)
    													->with('to_amount',$to_amount)         
                                              			->with('orders',$orders_item);


			}/* guard */
			else{
				 return redirect('/');
			}

    	}
    	catch(\Exception $e){   		
    		  return redirect('/') ->withMessage(FormatGenerator::message('Error..', 'There is an error in Sale Summary Report ...'));       
      	}

    	
    }
    public function export($from_date =null ,$to_date=null,$number=null,$from_amount =null,$to_amount =null){
    	 try{
            if( Auth::guard('Cashier')->check()){               
                ob_end_clean();
                ob_start();      
            $orders_item    = $this->BestSetRepo->best_set($from_date,$to_date,$number,$from_amount,$to_amount);
       
               if(count($orders_item)>0){
                     foreach ($orders_item as $key => $order) {
                        $items[$key]['Set Name']       = $order->Name;
                        $items[$key]['Quantity']        = number_format($order->Quantity);                       
                        $items[$key]['Total Amount']  	= (string)number_format($order->TotalAmount);
                       
                    }                    
                Excel::create('BestSellingSetMenu', function($excel)use($orders_item,$items) {
                $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->sheet('BestSetMenu', function($sheet)use($orders_item,$items) {
                        $sheet->fromArray($items);
                            $sum_qty        = 0;                                           
                            $sum            = 0;    
                         foreach($orders_item as $order){
                            $sum_qty    += $order->Quantity;
                            $sum        += $order->TotalAmount;
                           
                        }
                        $sheet->appendRow(array(
                    'Total Amount',number_format($sum_qty),number_format($sum)
                     ));           

                        $sheet->row(1,function($row){
                            $row->setBackground('#3c8dbc');
                        });
                         /* to add background in total */
                        $row            = count($items);                         
                        $current_row    = '1'; 
                            for($i=0; $i <= $row; $i++) 
                            {                          
                              $current_row++;
                            }                             
                         /* to add background in total */
                        $sheet->cell('A'.$current_row.':C'.$current_row, function($cell) {
                            $cell->setBackground('#3c8dbc');                            
                        });

                    });
                })->download('xls');
                ob_flush();                        

               }//count >0
               else{
                return redirect()->action('Backend\Reports\BestSellingSetReportController@index')
                ->withMessage(FormatGenerator::message('Oops..', 'There is no data on this day ...'));
               }
            }/* guard */

        }
        catch(\Exception $e){       
            
             return redirect()->action('Backend\Reports\BestSellingSetReportController@index')
                ->withMessage(FormatGenerator::message('Fail..', 'Error ...'));
        }    
    	
    
    }
}
