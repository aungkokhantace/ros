<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 4/28/2016
 * Time: 11:49 AM
 */

namespace App\RMS\Addon;

use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Monolog\Handler\Curl\Util;
use App\RMS\ReturnMessage;
use App\RMS\Addon\Addon;
use App\Status\StatusConstance;
use App\RMS\Category\Category;

class AddonRepository  implements  AddonRepositoryInterface
{
    public function getAllType() {
        $restaurant          = Utility::getCurrentRestaurant();
        $branch              = Utility::getCurrentBranch();
        $query               = Addon::query();
        $query               = $query->whereNull('deleted_at');
        if($restaurant != 0 || $restaurant != null){
            $query           = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query          = $query->where('branch_id',$branch);
        }
        $addon              = $query->get();
        // $addon = Addon::all();
        return $addon;
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
            $paramObj = Addon::find($inserted_id);
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
        $addon = Addon::find($id);
        return $addon;
    }

    public function extra_delete($id){
        $tempObj                = Addon::find($id);
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
        $old_name   = Addon::find($id);
        return $old_name;
    }
    public function getAllNames(){
        $all_names  = Addon::select('food_name')->get();
        return $all_names;
    }

    public function get_CatBranch($branch_id,$restaurant_id){       
        $status        = StatusConstance::CATEGORY_AVAILABLE_STATUS;

        $query         = Category::query();
        if($restaurant_id != 0 || $restaurant_id != null || $restaurant_id != ''){
        $query           = $query->where('restaurant_id',$restaurant_id);
        
        }
        if($branch_id != 0 || $branch_id != null){
            $query          = $query->where('branch_id',$branch_id);
        }
        $category           = $query->where('parent_id','=',0)
                                    ->where('status',$status)
                                    ->whereNull('deleted_at')
                                    ->get();       
        return $category;
    }


    public function getCategory(){
        $branch        = Utility::getCurrentBranch();
        $restaurant    = Utility::getCurrentRestaurant();
       

        $query         = Category::query();
        $query         = $query->whereNull('deleted_at');
        if($restaurant != 0){
            $query      = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0){
            $query     = $query->where('branch_id',$branch);
        }
        $categories        = $query->where('parent_id', '=', 0)->get();
        return $categories;

      
    }

    public function getextra(){
        $branch        = Utility::getCurrentBranch();
        $restaurant    = Utility::getCurrentRestaurant();
       

        $query         = Addon::query();
        $query         = $query->whereNull('deleted_at');
        if($restaurant != 0){
            $query      = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0){
            $query     = $query->where('branch_id',$branch);
        }
        $addon        = $query->get();
        return $addon;

      
    }
}