<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\RMS\Item\ItemRepository;
use App\Inventory\CategoryRepository;
use App\Http\Controllers\Controller;
use App\RMS\Category\Category;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;
use App\RMS\Utility;
use App\Inventory\OrderRepository;
use App\RMS\Item\Item;
use DB;
use GuzzleHttp\Psr7\Request as GuRequest;

class inventoryController extends Controller
{

	public $resquestserverurl  = 'http://gr8.acebi2.com.preview.my-hosting-panel.com';
	public $SupplierId 	       = 1;
	public $producttype 	   = 1;
	public $pprice_percent 	   = 0;
	public $sppricepercent 	   = 0;
	public $recorderlevel 	   = 0;
	public $maximum  		   = 0;
	public $mininum 		   = 0;
	public $marginpercence     = 0;

    public function category(){

		$CateRepo = new CategoryRepository();

    	$categorys = $CateRepo->getParentCate();
		$categorys  = json_encode($categorys);
        // return $categorys;
    	$client = new Client();
    	$url    = $this->resquestserverurl . '/category/create';
    	$headers = [
		    'Content-Type' => 'application/json',
		];

		$client = new client();
		$res = $client->post($url, [
		    'headers' => $headers, 
		    'body' => $categorys,
		]);
    	

    }

    public function group(){
    	$CateRepo = new CategoryRepository();

    	$categorys = $CateRepo->getParentCate();
    	$groups = array();
    	foreach($categorys as $category){
    		array_push($groups,$category->Id);
    	}
    	$groups  = $CateRepo->getGroup($groups);
    	$groups  = json_encode($groups);
        // return $groups;
    	$client = new Client();
    	$url  = $this->resquestserverurl . '/groupcode/create';
    	$headers = [
		    'Content-Type' => 'application/json',
		];

		$client = new client();
		$res = $client->post($url, [
		    'headers' => $headers, 
		    'body'    => $groups,
		]);


    }

    public function class(){
		$CateRepo = new CategoryRepository();
    	$categorys = $CateRepo->getParentCate();
    	$groups = array();
    	foreach($categorys as $category){
    		array_push($groups,$category->Id);
    	}
    	$groups  = $CateRepo->getGroup($groups);
    	$classes = array();

    	foreach($groups as $group){
    		array_push($classes,$group->Id);
    	}
        
    	$classes  = $CateRepo->getCalss($classes);
        $url  = $this->resquestserverurl.'/classcode/create';
        $classes = json_encode($classes);
        // return $classes;
	    $headers = [
		    'Content-Type' => 'application/json',
		];

		$client = new client();
		$res = $client->post($url, [
		    'headers' => $headers, 
		    'body' => $classes,
		]);

    }


    public function stock_item(){
		$CateRepo = new CategoryRepository();
		$categorys = $CateRepo->getParentCate();
    	$categoryary = array();
    	foreach($categorys as $category){
    		array_push($categoryary,$category->Id);
		}
		
    	$groups  = 	$groups  = $CateRepo->getGroup($categoryary);
    	$groupary = array();
	
    	foreach($groups as $group){
    		array_push($groupary,$group->Id);
    	}
        
    	$classes  =  $CateRepo->getClass($groupary);
		$classarray = array();
		
    	foreach($classes as $class){
    		array_push($classarray,$class->Id);
		}

		$ItemAry = array();
		
		$items = Item::where('status',1)->whereNull('deleted_at')->get();
		foreach($items as $item){
			if(in_array($item->category_id,$categoryary)){
			   $categoryid = $item->category_id;
			   $groupid    = 0;
			   $classid    = 0;
			   $item_ary   = $this->getItem($item,$groupid,$classid,$categoryid);
			   array_push($ItemAry,$item_ary);

			}elseif(in_array($item->category_id,$groupary)){
			   $item_ary = array();
			   $groupid    = $item->category_id;
			   $categoryid = $this->getparentId($groupid);
			   $classid    = 0;
			   $item_ary   = $this->getItem($item,$groupid,$classid,$categoryid);
			   array_push($ItemAry,$item_ary);

			}elseif(in_array($item->category_id,$classarray)){
			   $groupid    = $this->getparentId($classid);
			   $categoryid = $this->getparentId($groupid);
			   $classid    = $item->category_id;
			   $item_ary   = $this->getItem($item,$groupid,$classid,$categoryid);
			   array_push($ItemAry,$item_ary);
			}else{
				
				$response = $this->checkcategory($item->category_id,$categoryary,$groupary,$classarray);
				
				while($response['message'] == 404){
					$response = $this->checkcategory($response['category_id'],$categoryary,$groupary,$classarray);
					if($response['message'] == 200){
						break;
					}
				}
				
			   $groupid    = $this->getparentId($response['category_id']);
			   $categoryid = $this->getparentId($groupid);
			   $classid    = $response['category_id'];
			   $item_ary   = $this->getItem($item,$groupid,$classid,$categoryid);
			   array_push($ItemAry,$item_ary);


			}
		}

		$url  = $this->resquestserverurl.'/stock/create';
		
		$ItemAry = json_encode($ItemAry);

		$headers = [
		    'Content-Type' => 'application/json',
		];

		$client = new client();
		$res = $client->post($url, [
		    'headers' => $headers, 
		    'body' => $ItemAry,
		]);

	}


  public function sale_create(){
	  
  }

	
   public function getItem($item,$groupid,$classid,$categoryid){
	    $item_ary = array();
		$item_ary['Id'] 				= $item->id;
		$item_ary['StockNo']			= $item->stock_code;
		$item_ary['StockName'] 			= $item->name;
		$item_ary['ReorderLevel']		= $this->recorderlevel;
		$item_ary['Maximum']			= $this->maximum;
		$item_ary['Minimum']			= $this->mininum;
		$item_ary['Price']  			= $item->price;
		$item_ary['CategoryId']			= $categoryid;
		$item_ary['GroupCodeId']		= $groupid;
		$item_ary['ClassId'] 			= $classid;
		$item_ary['SupplierId'] 		= $this->SupplierId;
		$item_ary['UMId'] 				= 1;
		if($item->is_ready_food == 1){
		$item_ary['ProductTypeId'] 		= 3;
		}else{
		$item_ary['ProductTypeId'] 		= 1;
		}
		$item_ary['MarginPercent']  	= $this->marginpercence;
		$item_ary['PurchasePrice']   	= $item->price;
		$item_ary['SellingPrice']    	= $item->price;
		$item_ary['PPrice_Percent']  	= $this->pprice_percent;
		$item_ary['SPrice_Percent']  	= $this->sppricepercent;
		$item_ary['Image']          	= null;
		return $item_ary;
   }


	public function checkcategory($id,$categoryary,$groupary,$classarray){
		$CateRepo = new CategoryRepository();
        if(in_array($id,$categoryary)){
		   $response = array();
		   $response['message'] = 200;
		   $response['category_id'] = $id;
		   return $response;
		}
		elseif(in_array($id,$groupary)){
		   $response = array();
		   $response['message'] = 200;
		   $response['category_id'] = $id;
		   return $response;
		}
		elseif(in_array($id,$classarray)){
		   $response = array();
		   $response['message'] = 200;
		   $response['category_id'] = $id;
		   return $response;
		}else{
		   $response = array();
		   $response['message'] = 404;
		   $cate_id = $CateRepo->SelectParentId($id);
		   $response['category_id'] = $cate_id->parent_id;
		   return $response;
		}
	}

	public function getparentId($id){
		$response = Category::find($id);
		$parent_id =  $response->parent_id;
		return $parent_id;
	}



	public function saleStock($id){
		 $orderRepo = new OrderRepository();
		 $order     = $orderRepo->getOrderById($id);
		 
		 $order_details = $orderRepo->getOrderDetail($order->id);

		 foreach($order_details as $key=>$details){
			 $details->PurchasePrice = $details->SellingPrice;
			 $details->Amount      = $details->SellingPrice;
		 }

		
		
		 $orderAry = array();
		 $orderAry['InvoiceNo']     = $order->id;
		 $orderAry['InvoiceDate']   = Utility::saledate($order->order_time);
		 $orderAry['CustomerId']    = $order->user_id;
		 $orderAry['LocationId']    = 'loc001';
		 $orderAry['CurrencyId']    = '1';
		 $orderAry['Rate']          = '1.0000';
		 $orderAry['CashierId']     = $order->user_id;
		 $orderAry['ShiftId']       = $order->shift_id;
		 $orderAry['TotalAmount']   = $order->all_total_amount;
		 $orderAry['PaidAmount']    = $order->payment_amount;
		 $orderAry['Refund']        = $order->refund;
		 $orderAry['Expenses']      = '0.0000';
		 $orderAry['TaxAmount']     = $order->tax_amount;
		 $orderAry['PCAddress']     = $order->staff_id;
		 $orderAry['DueDate']       = Utility::saledate($order->order_time);
		 $orderAry['SaleStatus']    = 'W';
		 $orderAry['InvoiceStatus'] = 'CR';
		 $orderAry['CardCodeId']    = 0;
		 $orderAry['sale_details']  = $order_details;


		$url  = $this->resquestserverurl.'/sale/create';
		$saleAry = array();
		$saleAry[] = $orderAry;
		$orderAry = json_encode($saleAry);

		

		$headers = [
		    'Content-Type' => 'application/json',
		];

		$client = new client();
		$res = $client->post($url, [
		    'headers' => $headers, 
		    'body' => $orderAry,
		]);

		
		
	}


	
 
}
