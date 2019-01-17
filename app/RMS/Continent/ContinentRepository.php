<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/6/2016
 * Time: 10:58 AM
 */

namespace App\RMS\Continent;


use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use App\RMS\ReturnMessage;
use App\Status\StatusConstance;
use App\RMS\Continent\Continent;
use App\RMS\Category\Category;

class ContinentRepository implements ContinentRepositoryInterface
{

    public function getContinent(){
        $Continent          = Continent::with(['category_continent'=>function($query){
                                        $query->select('name');
                                    }])
                                ->get();
    return $Continent;
    }

    public function getCategories(){
    $category = Category::select('id', 'parent_id', 'name')->get()->toArray();

    return $category;
    }

    public function store($paramObj,$categories){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        try {
            $tempObj                = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            // Sync Table
            $tempObj->category_continent()->sync($categories);

            $inserted_id = $tempObj->id;
            $product_type = 6; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu// product tye 5= remark
            $stock_code = Utility::generateStockCode($inserted_id,$product_type);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function update($paramObj,$categories){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj                = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            // Sync Table
            $tempObj->category_continent()->sync($categories);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function getContinentID($id)
    {
        $continent  =  Continent::where('id',$id)->with(['category_continent'=>function($query){
                                $query->select('id');
                            }])
                        ->first();
        return $continent;
    }

    public function deleteContinent($id){
        $tempObj                = Continent::find($id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();
        $tempObj->category_continent()->sync([]);
    }

}
