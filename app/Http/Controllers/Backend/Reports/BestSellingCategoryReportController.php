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
use App\RMS\Reports_update\BestSellingCategory\BestSellingCategoryRepositoryInterface;


class BestSellingCategoryReportController extends Controller
{

	private $BestCategoryRepo;

    public function __construct(BestSellingCategoryRepositoryInterface $BestCategoryRepo)
    {
        $this->BestCategoryRepo 	= $BestCategoryRepo;
        $this->saleRepo 			= new SaleSummaryRepository();
    }

    public function index($from_date = null , $to_date = null){
    	try{
            if( Auth::guard('Cashier')->check()){   

    	$orders 			= $this->saleRepo->get_last_order_day(); 
    	$from_date 			= $orders;
    	$to_date 			= $orders;
     
        $orders_category    = $this->BestCategoryRepo->BestSetCategory($from_date,$to_date);  	
     
         $result     		= $this->category_sum($orders_category,$from_date,$to_date); 
         return view('Backend.reports.best_category.best_category')->with('from_date',$from_date)
    													->with('to_date',$to_date) 							
    													->with('orders',$result);
         }/* guard */

        }
        catch(\Exception $e){     
            return redirect('/')
                ->withMessage(FormatGenerator::message('Fail..', 'Error in reports ...'));    
        }    

    }
    public function search($from_date = null , $to_date = null){
    	try{
            if( Auth::guard('Cashier')->check()){		
		$orders_category    = $this->BestCategoryRepo->BestSetCategory($from_date,$to_date); 	
     
         $result     		= $this->category_sum($orders_category,$from_date,$to_date);
   
          return view('Backend.reports.best_category.best_category')->with('from_date',$from_date)
    													->with('to_date',$to_date)   							
    													->with('orders',$result);
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
		$orders_category    = $this->BestCategoryRepo->BestSetCategory($from_date,$to_date);	
     	$result     		= $this->category_sum($orders_category,$from_date,$to_date);
         // dd($result);
        if(count($result)>0){
         foreach ($result as $key => $order) {
            $items[$key]['Category']       	= $order['name'];
            $items[$key]['Quantity']        = (string)number_format($order['qty']);
            $items[$key]['Total Amount']    = (string)number_format($order['price']);
        }                    
        Excel::create('BestSellingCategory', function($excel)use($result,$items) {
        $excel->getDefaultStyle()
        ->getAlignment()
        ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->sheet('BestSellingCategory', function($sheet)use($result,$items) {
                $sheet->fromArray($items);                                            
                    $sum            = 0;    
                 foreach($result as $order){                           
                    
                    $sum += $order['price'];
                }
                $sheet->appendRow(array(
            		'Total Amount','',number_format($sum)
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
        return redirect()->action('Backend\Reports\BestSellingCategoryReportController@index')
        ->withMessage(FormatGenerator::message('Oops..', 'There is no data on this day ...'));
       }         
         }/* guard */

        }
        catch(\Exception $e){    
             return redirect('/')
                ->withMessage(FormatGenerator::message('Fail..', 'Error in reports ...'));    
        }    

    }

    public function getFinalResultForCategorySaleReport($data){
        $result = [];
        $item   = [];
        $i = 0;
        // dd("data",$data);
        if (!empty($data)) {
            foreach ($data as $category_sale_report) {
                if (array_search($category_sale_report->item_id, $item)) {
                    $duplicate = array_search($category_sale_report->item_id, $item);
                    $data = $result[$duplicate];
                    $category_sale_report->quantity += $data->quantity;
                    $category_sale_report->amount   += $data->amount;
                    unset($result[$duplicate]);
                    unset($item[$duplicate]);
                }
                $parent_id = $category_sale_report->parent_id;
                if ($parent_id !== 0) {

                    $child = $this->BestCategoryRepo->getParentCategory($parent_id);

                    if ($child->parent_id !== 0) {
                        $sub_child = $child = $this->BestCategoryRepo->getParentCategory($child->parent_id);
                        $category_sale_report->category_name = $sub_child->item_name;
                    }
                    $category_sale_report->category_name     = $category_sale_report->category_name;
                    $category_sale_report->category_name 	= $child->name;
                }

                $item['id'.$i] = $category_sale_report->item_id;
                $result['id'.$i] = $category_sale_report;
                $i++;
            }
        }


        return $result;
    }

     public function category_sum($data,$from_date,$to_date){    

        /* parent category */
        $category     = $this->BestCategoryRepo->getParentCat();
        for ($cat_count=0; $cat_count < count($category) ; $cat_count++) {        
         
          $category_array_temp[$category[$cat_count]->id]['category_id']        = $category[$cat_count]->id;
          $category_array_temp[$category[$cat_count]->id]['category_name']      = $category[$cat_count]->name;
          $category_array_temp[$category[$cat_count]->id]['total_Qty']          = 0;
          $category_array_temp[$category[$cat_count]->id]['total_price']        = 0;
        }
       
        for ($count_c=0; $count_c < count($category) ; $count_c++) {            
         
          $category_parent[$category[$count_c]->id]['category_id']        = $category[$count_c]->id;
          $category_parent[$category[$count_c]->id]['category_name']      = $category[$count_c]->name;
          $category_parent[$category[$count_c]->id]['total_Qty']          = 0;
          $category_parent[$category[$count_c]->id]['total_price']        = 0;
        }    
        $sum_quantity 			= 0;
        $sum_total    			= 0; 
        $sum_quantity_parent 	= 0;
        $sum_total_parent    	= 0;   

       if (!empty($data)) {
        foreach ($data as $category_array) {
        	if($category_array->parent_id != 0){
        	   $parent_temp        = false; /* parent id is not 0 */

                while ($parent_temp == false ) {                    
                    $cat_id                 = $category_array->category_id;
                    if($cat_id != 0){
                        $child              = $this->BestCategoryRepo->getParentCategory($cat_id);
                        $temp_cat_id        = $child->parent_id;                                     
                        $temp_cat_result    = $this->BestCategoryRepo->BestSetbyCategory($child->id,$from_date,$to_date);                     

                        for ($count=0; $count <count($temp_cat_result) ; $count++) { 
                            $sum_quantity   += $temp_cat_result[$count]->quantity;
                            $sum_total      += $temp_cat_result[$count]->amount;
                        }
                        // dd($sum_quantity,$sum_total);
                        
                        if(array_key_exists($temp_cat_id, $category_array_temp)){

                              $category_array_temp[$temp_cat_id]['total_Qty']   = $sum_quantity;
                              $category_array_temp[$temp_cat_id]['total_price'] = $sum_total;
                              $sum_quantity = 0;
                              $sum_total    = 0;   
                            }
                            else{
                                $parent_temp        = false;                               
                            }       
                          $parent_temp = true;
                    }
                    else{
                        $parent_temp = true;                   
                    }                   
                }//while    

        	}///if
        	else{
    		 $temp_cat_result_parent    = $this->BestCategoryRepo->BestSetbyCategory($category_array->category_id,$from_date,$to_date);        
    		       
    		       for ($count1=0; $count1 <count($temp_cat_result_parent) ; $count1++) { 
                    	// dd($temp_cat_result_parent[$count1]->quantity);
                        $sum_quantity_parent   += $temp_cat_result_parent[$count1]->quantity;
                        $sum_total_parent      += $temp_cat_result_parent[$count1]->amount;
                    }                   
                    
                    if(array_key_exists($category_array->category_id, $category_parent)){
                        // dd("exig");
                          $category_parent[$category_array->category_id]['total_Qty']   = $sum_quantity_parent;
                          $category_parent[$category_array->category_id]['total_price'] = $sum_total_parent;
                          $sum_quantity_parent = 0;
                          $sum_total_parent   =  0;   
                        }
        	}
        
            }
             
        }      
          /* sum all array value*/
          foreach ($category_array_temp as $key => $value) {
          	$final_arr[$key]['id'] 		= $value['category_id'];
          	$final_arr[$key]['name']  		= $value['category_name'];
          	$final_arr[$key]['qty'] 		= $value['total_Qty'] + $category_parent[$key]['total_Qty'];
          	$final_arr[$key]['price'] 		= $value['total_price'] + $category_parent[$key]['total_price'];
          }   
		return $final_arr;
    }    

   
}
