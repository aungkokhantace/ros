<?php

namespace App\Http\Controllers\inventory;

use Carbon\Carbon;
//use Chrisbjr\ApiGuard\Contracts\Providers\Auth;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use App\RMS\Item\ItemRepository;
use App\Http\Controllers\Controller;
use App\RMS\Category\Category;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request as GuRequest;
use App\Inventory\UM;

class inventoryController extends Controller
{

	public $resquestserverurl  = 'http://gr8.acebi2.com.preview.my-hosting-panel.com';

    public function category(){

    	$categorys = Category::where('parent_id',0)->whereNull('deleted_at')->where('status',1)->select('id as Id','name as Description','stock_code as CategoryNo')->get();
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
    	$categorys = Category::where('parent_id',0)->whereNull('deleted_at')->where('status',1)->select('id as Id','name as Description','stock_code as categoryNo')->get();
    	$groups = array();
    	foreach($categorys as $category){
    		array_push($groups,$category->Id);
    	}
    	$groups  = Category::whereIn('parent_id',$groups)->whereNull('deleted_at')->where('status',1)->select('id as Id','name as Description','stock_code as GroupNo')->get();
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

    	$categorys = Category::where('parent_id',0)->whereNull('deleted_at')->where('status',1)->select('id as Id','name as Description','stock_code as categoryNo')->get();
    	$groups = array();
    	foreach($categorys as $category){
    		array_push($groups,$category->Id);
    	}
    	$groups  = Category::whereIn('parent_id',$groups)->whereNull('deleted_at')->where('status',1)->select('id as Id','name as Description','stock_code as categoryNo')->get();
    	$classes = array();

    	foreach($groups as $group){
    		array_push($classes,$group->Id);
    	}
        
    	$classes  = Category::whereIn('parent_id',$classes)->whereNull('deleted_at')->where('status',1)->select('id as Id','stock_code as ClassNo','name as Description')->get();
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
	
		$itemRepo = new ItemRepository();
		$Cate_ary = array();
		$Group_ary  = array();
		$class_ary  = array();
		$category_id_ary = $itemRepo->get_category_id();
		$parent_category = $itemRepo->getparentCategory();
		foreach($parent_category as $parent){
			if(in_array($parent->parent_id,$category_id_ary)){
				$item = $itemRepo->getitem_forinvestory($parent->parent_id);
				array_push($Cate_ary,$item);
			}else{
				$groups = $itemRepo->getParent_Id($parent->parent_id);		
				foreach($groups as $group){
					if(in_array($group->parent_id,$category_id_ary)){
						$item = $itemRepo->getitem_forinvestory($parent->parent_id);
						array_push($Group_ary,$item);
					}else{
						$classes  = $itemRepo->getParent_Id($group->parent_id);
						foreach($classes as $class){
							if(in_array($class->parent_id,$category_id_ary)){
								$item = $itemRepo->getitem_forinvestory($class->parent_id);
								array_push($class_ary,$item);
							}else{
								continue;
								
							}
						}
					}
				}
			}
		}
		
		
		

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
        $url     = $this->resquestserverurl.'/purchaserequest/create';
        $now     = Carbon::now();
        $id      = Auth::guard('Cashier')->user()->kitchen_id;
        $detail  = [];
        $client  = new Client();
        $date_string        = implode(explode('-' , $now->toDateString()));
        $date_time          = $now->format('d/m/Y H:i:s A');
        $requisition_no     = $date_string.'-'.$id.'-'.'0000';
        $stock_requisitions = $request->stock;

        $headers = [
            'Content-Type' => 'application/json',
        ];

        foreach ($stock_requisitions as $stock_requisition) {
            unset($stock_requisition['group'], $stock_requisition['unit']);
            $detail[] = $stock_requisition;
        }

        $data = [
            'RequisitionNo'       => $requisition_no,
            'RequisitionDate'     => $date_time,
            'LocationId'          => $id,
            'PriorityId'          => 0,
            'ReceivedDate'        => null,
            'requisition_details' => $detail
        ];

        $result = json_encode($data);

        $res = $client->post($url, [
            'headers' => $headers,
            'body' => $result
        ]);

        dd(json_decode($res->getBody()));
    }
   
}
