<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/24/2016
 * Time: 1:54 PM
 */

namespace App\RMS\Discount;


use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Item\Item;
use App\RMS\Discount\DiscountModel;
use App\RMS\ReturnMessage;
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
            $tempObj        = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }
    public function discount_delete($id)
    {
        $tempObj = DiscountModel::find($id);
        $tempObj = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at = date('Y-m-d H:m:i');
        $tempObj->save();
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
            $tempObj        = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }
}