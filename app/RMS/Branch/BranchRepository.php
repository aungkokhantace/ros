<?php
namespace App\RMS\Branch;

use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Monolog\Handler\Curl\Util;
use App\RMS\ReturnMessage;
use App\RMS\Branch\Branch;
use Auth;

class BranchRepository  implements  BranchRepositoryInterface
{
    public function getAllType() {

        $restaurant_id = Auth::guard('Cashier')->user()->restaurant_id;
        $branch_id     = Auth::guard('Cashier')->user()->branch_id;   

        $query         = Branch::query();
        $query         = $query->whereNull('deleted_at');
        if($restaurant_id != 0){
            $query      = $query->where('restaurant_id',$restaurant_id);
        }
        if($branch_id != 0){
            $query     = $query->where('id',$branch_id);
        }
        $Branch        = $query->get();

        
       
        return $Branch;
    }

    public function store($paramObj){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            $inserted_id = $tempObj->id;
            $product_type = 3; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu
            $stock_code = Utility::generateStockCode($inserted_id,$product_type);
            $paramObj = Branch::find($inserted_id);
            $paramObj->stock_code = $stock_code;
            $paramObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function extra_edit($id){
        $Branch = Branch::find($id);
        return $Branch;
    }

    public function extra_delete($id){
        $tempObj                = Branch::find($id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();
    }

    public function update($paramObj,$oldprice){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser = Utility::getCurrentUserID();//get current user login
        try {
            $tempObj            = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            if ($tempObj->price !== $oldprice) {
                //Save item Price change history
                Utility::savePriceTracking('add_on',$tempObj->id,'integer','update',$oldprice,$tempObj->price,$currentUser,$tempObj->updated_at);
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function updateall($paramObj,$oldprice){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser = Utility::getCurrentUserID();//get current user login
        try {
            $tempObj             = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            if ($tempObj->price !== $oldprice) {
                //Save item Price change history
                Utility::savePriceTracking('add_on',$tempObj->id,'integer','update',$oldprice,$tempObj->price,$currentUser,$tempObj->updated_at);
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }
    public function getOldName($id){
        $old_name   = Branch::find($id);
        return $old_name;
    }
    public function getAllNames(){
        $all_names  = Branch::select('food_name')->get();
        return $all_names;
    }
}