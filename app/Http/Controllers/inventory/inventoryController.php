<?php

namespace App\Http\Controllers\inventory;

use App\RMS\Config\ConfigRepository;
use Carbon\Carbon;
//use Chrisbjr\ApiGuard\Contracts\Providers\Auth;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\RMS\Item\ItemRepository;
use App\Inventory\CategoryRepository;
use App\Http\Controllers\Controller;
use App\RMS\Category\Category;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Inventory\UM;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;
use App\RMS\Utility;
use App\RMS\Config\ConfigRepositoryInterface;
use App\RMS\Kitchen\Kitchen;
use Validator;
use App\Inventory\OrderRepository;
use App\RMS\Item\Item;
use DB;
use GuzzleHttp\Psr7\Request as GuRequest;
use App\RMS\Kitchen\KitchenRepository;


class inventoryController extends Controller
{
    private $utility;

    private $configRepository;

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

		$res = $client->post($url, [
		    'headers' => $headers,
		    'body'    => $groups,
		]);


    }

    public function classes(){
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

		$client = new Client();
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

		$client = new Client();
		$res = $client->post($url, [
		    'headers' => $headers,
		    'body' => $ItemAry,
		]);

	}


	public function getSyncUm()
    {
    	$uri = 'um/get_um';
    	$data = $this->guzzleClient($uri);

    	foreach ($data as $um) {

        if (UM::pluck('um_id')->contains($um->Id)) {
                UM::find($um->Id)->first()->update([
                    'um_id' =>$um->Id,
                    'code' =>$um->Code ,
                    'description' =>$um->Description,
                    'updated_by' =>1,
                ]);
        }else{
            UM::create([
                    'um_id' =>$um->Id,
                    'code' =>$um->Code,
                    'description' =>$um->Description,
                    'created_by' =>1,
                ]);
        }
    }

    }
    public function guzzleClient($uri)
    {
	   	$client 		= new Client(['base_uri' => $this->resquestserverurl]);
		$response 		= $client->get($uri)->getBody();
    	return json_decode($response);
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
			 if($details->Discount == ''){
			  $details->Discount    = 0.0000;
			 }
		 }



		 $orderAry = array();

		 $orderAry['InvoiceNo']     = $order->id;
		 $orderAry['InvoiceDate']   = Utility::saledate($order->order_time);
		 $orderAry['CustomerId']    = 'ROS001';
		 $orderAry['LocationId']    = 'LOC001';
		 $orderAry['CurrencyId']    = 1;
		 $orderAry['Rate']          = 1.0000;
		 $orderAry['CashierId']     = 1;
		 $orderAry['ShiftId']       = $order->shift_id;
		 $orderAry['TotalAmount']   = $order->all_total_amount;
		 $orderAry['PaidAmount']    = $order->payment_amount;
		 $orderAry['Refund']        = $order->refund;
		 $orderAry['Expenses']      = 0.0000;
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

		$client = new Client();
		$res = $client->post($url, [
		    'headers' => $headers,
		    'body' => $orderAry,
		]);


	}

    public function index()
    {
        $client = new Client([
            'base_uri' => $this->resquestserverurl
        ]);
        $raw_group_url    = 'groupcode/get_rawgroup';
        $raw_stock_url    = 'stock/get_raw_stock';
        $measurement_unit = 'um/get_um';
        $raw_group_responses  = json_decode($client->get($raw_group_url)->getBody());
        $raw_stock_responses  = json_decode($client->get($raw_stock_url)->getBody());
        $measurement_unit_responses  = json_decode($client->get($measurement_unit)->getBody());
        return view('kitchen.stock_requisition', compact(['raw_group_responses',
            'raw_stock_responses', 'measurement_unit_responses'
        ]));
    }

    public function store(Request $request)
    {
		    $configRepo  = new ConfigRepository();
        $kitchenRepo = new KitchenRepository();
        $post_url  = $this->resquestserverurl.'/purchaserequest/create';
        $get_url   = '/purchaserequest/get_purchaserequisition';
        $id        = Auth::guard('Cashier')->user()->kitchen_id;
        $code      = Utility::generateRequisitionNo()['code'];
        $config_id = Utility::generateRequisitionNo()['id'];
        $detail    = [];
        $date_string = Utility::dateString();
        $kitchen_code = $kitchenRepo->getKitchenCode($id)->kitchen_code;
        $stock_requisitions = $request->stock;

        foreach ($stock_requisitions as $stock_requisition) {
            $validator = Validator::make($stock_requisition, [
                'Quantity' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect('Kitchen/stock-requisition')->with('fail', 'Required Please Insert All Fields.');
            }

            $stock = explode(',', $stock_requisition['StockId']);
            $stock_requisition['StockId'] = $stock[0];
            if (!empty($stock[1])) {
              $stock_requisition['PurchasePrice'] = (int)$stock[1];
              $stock_requisition['Amount'] = $stock_requisition['Quantity'] * $stock[1];
            }
            $detail[] = $stock_requisition;
        }

        $data = [
            [
                "RequisitionNo" => $code,
                "RequisitionDate" => $date_string,
                "LocationId" => $kitchen_code,
                "PriorityId"=> 0,
                "ReceivedDate" => $date_string,
                "requisition_details" => $detail
            ]
        ];

        $body = json_encode($data);

        $post_client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $get_client  = new Client([
           'base_uri' => $this->resquestserverurl
        ]);

        $post_client->post($post_url, ['body' => $body]);

        $requisitions = json_decode($get_client->get($get_url)->getBody());

        foreach ($requisitions as $requisition) {
            if ($requisition->RequisitionNo == $code) {
                $configRepo->updateRequisitionNo($config_id, $code);
                return redirect('Kitchen/stock-requisition')->with('success', 'Successful To Request.');
            }
        }

        return redirect('Kitchen/stock-requisition')->with('fail', 'Fail To Request, Please Try Again Later.');
    }

    public function getKitchen()
    {
        $uri            = '/Location/create';
        $kitchenData    =  Kitchen::all(['id as Id ','name as LocationName','kitchen_code as LocationNo'])->toJson();
        $response       = $this->guzzleStore($uri, $kitchenData);
    }

    public function guzzleStore($uri,$data)
    {
        $meta   = [ 'base_uri' => $this->resquestserverurl,'headers' => ['Content-Type' => 'application/json']];
        $client = new \GuzzleHttp\Client($meta);
        $client->post($uri,['body' => $data ]);
    }
}
