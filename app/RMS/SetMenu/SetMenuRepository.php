<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 5/5/2016
 * Time: 10:53 AM
 */

namespace App\RMS\SetMenu;

use App\RMS\Category\Category;
use App\RMS\Item\Item;
use App\RMS\Kitchen\Kitchen;
use App\RMS\Utility;
use App\RMS\ReturnMessage;
use App\RMS\Member\Member;
use App\RMS\SetMenu\SetMenu;
use App\RMS\SetItem\SetItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SetMenuRepository implements SetMenuRepositoryInterface
{
    public function getCategories(){
        $category = Category::select('id', 'parent_id', 'name')->get()->toArray();

        return $category;
    }


    public function getItems(){
        $items = Item::select('id', 'category_id', 'name')->whereNull('deleted_at')->where('status','=',1)->get()->toArray();

        return $items;
    }

    public function getKitchen(){
        $kitchens = Kitchen::all();
        
        return $kitchens;
    }

    public function getSetItem(){
        $joinType = SetItem::get();

        return $joinType;
    }

    public function getAllItem(){
        $Item = DB::table('items')->get();
        return $Item;
    }

    public function getAllSet(){
        $set = DB::table('set_menu')->get();

        return $set;
    }

    public function store($paramObj,$items)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $id      = $paramObj->id;
            foreach($items as $item){
                $paramObj                = new SetItem();
                $paramObj->set_menu_id   = $id;
                $paramObj->item_id       = $item;
                $tempItem                = Utility::addCreatedBy($paramObj);
                $tempItem->save();
            }

            $inserted_id = $tempObj->id;
            $product_type = 4; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu
            $stock_code = Utility::generateStockCode($inserted_id,$product_type);
            $paramObj = SetMenu::find($inserted_id);
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

    public function delete($id)
    {
        $tempItem               = SetItem::where('set_menu_id', '=', $id)->get();
        
        foreach($tempItem as $item){
            $tempItem               = Utility::addDeletedBy($item);
            $tempItem->deleted_at   = date('Y-m-d H:m:i');
            $tempItem->save();
        }
        
        $tempObj                = SetMenu::find($id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->status        = 2; 
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();
    }

    public function setMenuUpdate($paramObj,$item,$oldprice)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser = Utility::getCurrentUserID();//get current user login
        try {
            $tempObj    = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            if ($tempObj->set_menus_price !== $oldprice) {
                //Save item Price change history
                Utility::savePriceTracking('set_menu',$tempObj->id,'integer','update',$oldprice,$tempObj->set_menus_price,$currentUser,$tempObj->updated_at);
            }

            $id         = $paramObj->id;
            if(isset($sell_item)) {
                SetItem::where('set_menu_id',$id)->delete();
                foreach ($item as $items)
                {
                    $paramObj                 = new SetItem();
                    $paramObj->set_menu_id    = $id;
                    $paramObj->item_id        = $items;
                    $tempObj                  = Utility::addUpdatedBy($paramObj);
                    $tempObj->save();

                }
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function itemUpdate($paramObj,$item,$oldprice)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser = Utility::getCurrentUserID();//get current user login
        try {
            $tempObj    = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            if ($tempObj->set_menus_price !== $oldprice) {
                //Save item Price change history
                Utility::savePriceTracking('set_menu',$tempObj->id,'integer','update',$oldprice,$tempObj->set_menus_price,$currentUser,$tempObj->updated_at);
            }

            $id         = $paramObj->id;
            if(isset($item)) {
                SetItem::where('set_menu_id',$id)->delete();
                foreach ($item as $items)
                {
                    $paramObj               = new SetItem();
                    $paramObj->set_menu_id  = $id;
                    $paramObj->item_id      = $items;
                    $tempObj                = Utility::addCreatedBy($paramObj);
                    $tempObj->save();

                }
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
        $old_name   = SetMenu::find($id);

        return $old_name;
    }

    public function getAllNames(){
        $all_names  = SetMenu::select('set_menus_name')->get();

        return $all_names;
    }
}
