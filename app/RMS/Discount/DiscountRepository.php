<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/24/2016
 * Time: 1:54 PM
 */

namespace App\RMS\Discount;


use App\RMS\Branch\Branch;
use App\RMS\Restaurant\Restaurant;
use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Item\Item;
use App\RMS\Discount\DiscountModel;
use App\RMS\Discount\DiscountLog;
use App\RMS\ReturnMessage;
use App\RMS\Item\Continent;

class DiscountRepository implements DiscountRepositoryInterface
{
    public function getAllUser()
    {
        $discount = DiscountModel::all();
        return $discount;
    }

    public function store($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $this->storeDiscountLog($tempObj);
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } catch (Exception $e) {

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function discount_delete($id)
    {
        $tempObj = DiscountModel::find($id);
        if (count($tempObj) > 0) {
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();
            $this->deleteDiscountLog($tempObj);
        }
    }

    public function getItem()
    {
        $items = DB::table('items')->get();
        return $items;
    }

    public function discount_edit($id)
    {
        $discount_edit = DiscountModel::find($id);
        return $discount_edit;
    }

    public function update($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $this->updateDiscountLog($tempObj);
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } catch (Exception $e) {
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function storeDiscountLog($tempObj)
    {

        try {
            $paramObj                  = new DiscountLog();
            $paramObj->name            = $tempObj->name;
            $paramObj->restaurant_id   = $tempObj->restaurant_id;
            $paramObj->branch_id       = $tempObj->branch_id;
            $paramObj->amount          = $tempObj->amount;
            $paramObj->type            = $tempObj->type;
            $paramObj->start_date      = $tempObj->start_date;
            $paramObj->end_date        = $tempObj->end_date;
            $paramObj->item_id         = $tempObj->item_id;
            //Set Updated By and Updated at Null
            $paramObj->updated_by      = 0;
            $paramObj->updated_at      = Null;

            $paramObj->save();
        } catch (Exception $e) {
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function updateDiscountLog($tempObj)
    {
        try {
            $paramObj                 = new DiscountLog();
            $paramObj->name           = $tempObj->name;
            $paramObj->restaurant_id  = $tempObj->restaurant_id;
            $paramObj->branch_id      = $tempObj->branch_id;
            $paramObj->amount         = $tempObj->amount;
            $paramObj->type           = $tempObj->type;
            $paramObj->start_date     = $tempObj->start_date;
            $paramObj->end_date       = $tempObj->end_date;
            $paramObj->item_id        = $tempObj->item_id;
            $paramObj->created_at     = Null;
            $paramObj->save();
        } catch (Exception $e) {
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function deleteDiscountLog($tempObj)
    {
        try {
            $paramObj                 = new DiscountLog();
            $paramObj->name           = $tempObj->name;
            $paramObj->restaurant_id  = $tempObj->restaurant_id;
            $paramObj->branch_id      = $tempObj->branch_id;
            $paramObj->amount         = $tempObj->amount;
            $paramObj->type           = $tempObj->type;
            $paramObj->start_date     = $tempObj->start_date;
            $paramObj->end_date       = $tempObj->end_date;
            $paramObj->item_id        = $tempObj->item_id;
            $updateObj                = Utility::addDeletedBy($paramObj);
            $updateObj->deleted_at    = date('Y-m-d H:m:i');
            $updateObj->created_at    = Null;
            $updateObj->updated_at    = Null;
            $updateObj->save();

        } catch (Exception $e) {
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getContinent()
    {
        $continent = Continent::select('id', 'name')->get();
        return $continent;
    }
   public function getRestaurant($restaurant_id){
       $restaurant            = Branch::where('restaurant_id',$restaurant_id)->whereNull('deleted_at')->get();
       return $restaurant;
       }

    public  function getBranch($restaurant_id,$branch_id){
        $query               = Category::query();
        $query               = $query->whereNull('deleted_at');

        if($branch_id != 0 || $branch_id != null && $restaurant_id != 0 || $restaurant_id != null){
            $branch         = $query->where('branch_id',$branch_id);
            return $branch;
        }

    }
    public function getAll(){
        $branch        = Utility::getCurrentBranch();
        $restaurant    = Utility::getCurrentRestaurant();

    //dd($branch,$restaurant);
        $query         = DiscountModel::query();
        $query         = $query->whereNull('deleted_at');
        if($restaurant != 0 || $restaurant != null){
            $query      = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query     = $query->where('branch_id',$branch);
        }
        $discount        = $query->get();
        return $discount;


    }

}