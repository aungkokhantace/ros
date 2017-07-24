<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/28/2016
 * Time: 11:51 AM
 */

namespace App\RMS\Item;
use App\RMS\Utility;
use App\RMS\Category\Category;
use App\RMS\Item\Item;
use Illuminate\Support\Facades\DB;
use App\RMS\ReturnMessage;

class ItemRepository implements ItemRepositoryInterface
{
    public function store($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj    = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            $inserted_id = $tempObj->id;
            $product_type = 1; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu
            $stock_code = Utility::generateStockCode($inserted_id,$product_type);
            $paramObj = Item::find($inserted_id);
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

    public function selectParent()
    {
        $parent = DB::table('category')->where('parent_id', '=', 0)->get();
        return $parent;
    }

    public function selectSub()
    {
        $sub = DB::table('category')->where('parent_id', '!=', 0)->get();
        return $sub;
    }

    public function allCat()
    {
        $allCat = DB::table('category')->get();
        return $allCat;
    }

    public function ChooseCat()
    {
        $category   = Category::select('id', 'parent_id', 'name','status')->where('status','1')->get()->toArray();
        return $category;
    }

   
    public function ChooseDisabled()
    {
        $disabled   = Category::select('id', 'parent_id', 'name','status')
            ->where('status','=',0)
            ->get()->toArray();
        return $disabled;
    }

    //    Testing for multilevel
    public function selectCat()
    {
        $categ = DB::table('category')->where('parent_id','=',0)->get();
        return $categ;
    }

    public function multi($id)
    {
        $categ = DB::table('category')->where('parent_id','=',$id)->get();
        return $categ;
    }
    //    Testing for multilevel

    public function find($id){
        $data = DB::table('items')->find($id);
        return $data;
    }

    public function getAllItemName()
    {
        $data=DB::table('items')->get();
        return $data;
    }

    public function updateAllItem($paramObj,$oldprice)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID();//get current user login
        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            if ($tempObj->price !== $oldprice) {
                //Save item Price change history
                Utility::savePriceTracking('items',$tempObj->id,'integer','update',$oldprice,$tempObj->price,$currentUser,$tempObj->updated_at);
            }
            
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function updateItem($paramObj,$oldprice)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID();//get current user login
        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            if ($tempObj->price !== $oldprice) {
                //Save item Price change history
                Utility::savePriceTracking('items',$tempObj->id,'integer','update',$oldprice,$tempObj->price,$currentUser,$tempObj->updated_at);
            }
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function itemenabled($id){
        DB::table('items')
            ->where('id',$id)
            ->update(['status'=>1]);
    }

    public function itemdisabled($id){
        DB::table('items')
            ->where('id',$id)
            ->update(['status'=>0]);
    }

    public function delete($id){
        $tempObj = Item::find($id);
        $tempObj = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at = date('Y-m-d H:m:i');
        $tempObj->save();
    }

}