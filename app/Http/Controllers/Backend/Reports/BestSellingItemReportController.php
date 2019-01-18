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
use App\RMS\Reports_update\BestSellingItem\BestSellingItemRepositoryInterface;

class BestSellingItemReportController extends Controller
{
	 private $BestItemRepo;

    public function __construct(BestSellingItemRepositoryInterface $BestItemRepo)
    {
        $this->BestItemRepo 	= $BestItemRepo;
        $this->saleRepo 		= new SaleSummaryRepository();
    }

    public function itemReport($from_date =null ,$to_date=null,$number=null,$from_amount =null,$to_amount =null){
    	try{
            if( Auth::guard('Cashier')->check()){   

    	$orders 			= $this->saleRepo->get_last_order_day(); 
    	$from_date 			= $orders;
    	$to_date 			= $orders; 
        $orders_item        = $this->BestItemRepo->bestItem($from_date,$to_date);  	
    	return view('Backend.reports.best_item.best_item')->with('from_date',$from_date)
    													->with('to_date',$to_date)
    													->with('number',$number)
    													->with('from_amount',$from_amount)
    													->with('to_amount',$to_amount)
                
                                              ->with('orders',$orders_item);
         }/* guard */

        }
        catch(\Exception $e){            
               return redirect('/')
                ->withMessage(FormatGenerator::message('Fail..', 'Error in reports ...'));    
        }    
      
    }
    public function itemReportSearch($from_date =null ,$to_date=null,$number=null,$from_amount =null,$to_amount =null){
        // dd($from_amount,$to_amount);
        // var_dump($from_amount,$to_amount);
        // die();
        try{
            if( Auth::guard('Cashier')->check()){   

    	$orders_item        = $this->BestItemRepo->bestItem($from_date,$to_date,$number,$from_amount,$to_amount);

    	return view('Backend.reports.best_item.best_item')->with('from_date',$from_date)
    													->with('to_date',$to_date)
    													->with('number',$number)
    													->with('from_amount',$from_amount)
    													->with('to_amount',$to_amount)
                                                        ->with('orders',$orders_item);
            }/* guard */

        }
        catch(\Exception $e){            
               return redirect()->action('Backend\Reports\BestSellingItemReportController@itemReport')
                ->withMessage(FormatGenerator::message('Fail..', 'Error ...'));     
        }    
      }

    public function itemReport_excel($from_date =null ,$to_date=null,$number=null,$from_amount =null,$to_amount =null){
        try{
            if( Auth::guard('Cashier')->check()){               
                ob_end_clean();
                ob_start();      
             $orders_item        = $this->BestItemRepo->bestItem($from_date,$to_date,$number,$from_amount,$to_amount);
       
               if(count($orders_item)>0){
                     foreach ($orders_item as $key => $order) {
                        $items[$key]['Item Name']       = $order->name;
                        $items[$key]['Quantity']        = number_format($order->total);
                        $items[$key]['Price']           = number_format($order->amount);
                        $items[$key]['Discount Price']  = (string)number_format($order->discount_amount);
                        $items[$key]['Total Amount']    = number_format($order->price);
                    }                    
                Excel::create('BestSellingItem', function($excel)use($orders_item,$items) {
                $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->sheet('BestSellingItem', function($sheet)use($orders_item,$items) {
                        $sheet->fromArray($items);
                            $sum_qty        = 0;
                            $item_price     = 0;
                            $sum_discount   = 0;                    
                            $sum            = 0;    
                         foreach($orders_item as $order){
                            $sum_qty    += $order->total;
                            $sum        += $order->total_amt;
                            $item_price += $order->amount;
                            $sum_discount += $order->discount_amount;
                        }
                        $sheet->appendRow(array(
                    'Total Amount',number_format($sum_qty),number_format($item_price),number_format($sum_discount),number_format($sum)
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
                        $sheet->cell('A'.$current_row.':E'.$current_row, function($cell) {
                            $cell->setBackground('#3c8dbc');                            
                        });

                    });
                })->download('xls');
                ob_flush();                        

               }//count >0
               else{
                return redirect()->action('Backend\Reports\BestSellingItemReportController@itemReport')
                ->withMessage(FormatGenerator::message('Oops..', 'There is no data on this day ...'));
               }
            }/* guard */

        }
        catch(\Exception $e){  
            
             return redirect()->action('Backend\Reports\BestSellingItemReportController@itemReport')
                ->withMessage(FormatGenerator::message('Fail..', 'Error ...'));
        }    
    }
}
