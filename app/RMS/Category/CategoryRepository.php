<?php
/**
 * Created by PhpStorm.
 * User: UNiQUE
 * Date: 3/24/2016
 * Time: 2:30 PM
 */

namespace App\RMS\Category;


use App\RMS\Item\Item;
use App\RMS\Category\Category;
use App\RMS\Kitchen\Kitchen;
use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Util;
use App\RMS\ReturnMessage;
use App\Status\StatusConstance;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function ChooseCat(){
        $category   = Category::select('id', 'parent_id', 'name','status')->where('status','1')->get()->toArray();
        return $category;
    }

    public function getAllCategory(){
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
        $categories        = $query->get();
        return $categories;

      
    }

    //show data from db in select box
    public function getMainCategory(){
        $selectcategory = Category::where('parent_id', 0)->get();
        return $selectcategory;
    }

    public function store($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            $inserted_id = $tempObj->id;
            $product_type = 2; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu
            $stock_code = Utility::generateStockCode($inserted_id,$product_type);
            $paramObj = Category::find($inserted_id);
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

    public function subCategory($send_id){
        $subcategory = Category::where('parent_id','=',$send_id)->first();
        return $subcategory;
    }

    public function item($id){
        $items = Item::where('category_id','=',$id)->first();//must be first() and must not be find()
        return $items;
    }

    public function deleteCategory($id){
        $tempObj                = Category::find($id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();
    }

    public function editCategory($id){
        $editcategory = DB::table('category')->find($id);
        return $editcategory;
    }

    public function find($id){
       $editcategory = DB::table('category')->where('id',$id)->first();
       return $editcategory;
    }

    public function findcat($id){
        $editcategory = DB::table('category')->where('id','=',$id)->get();
        return $editcategory;
    }

    public function updateAllCategory($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            $categories     = Category::select('id')->where('group_id','=',$paramObj->group_id)->get();
            foreach($categories as $category) {
                $cat_id                 = $category->id;
                $updateCat              = Category::find($cat_id);
                $updateCat->kitchen_id  = $paramObj->kitchen_id;
                $updateCatObj           = Utility::addUpdatedBy($updateCat);
                $updateCatObj->save();
            }
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }
    public function updateCategory($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            $categories     = Category::select('id')->where('group_id','=',$paramObj->group_id)->get();
            foreach($categories as $category) {
                $cat_id                 = $category->id;
                $updateCat              = Category::find($cat_id);
                $updateCat->kitchen_id  = $paramObj->kitchen_id;
                $updateCatObj           = Utility::addUpdatedBy($updateCat);
                $updateCatObj->save();
            }
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function selectCat(){
        $categ = DB::table('category')->where('parent_id','=',0)->get();
        return $categ;
    }

    public function multi($id){
        $categ = DB::table('category')->where('parent_id','=',$id)->get();
        return $categ;
    }

    public function disabledmulti($id){
        DB::table('category')
            ->where('parent_id',$id)
            ->update(['status' => 0]);

        DB::table('items')
            ->where('category_id',$id)
            ->update(['status' => 0]);

        $categ = DB::table('category')->where('parent_id','=',$id)->get();
        return $categ;
    }

    public function enabledmulti($id){
        DB::table('category')
            ->where('parent_id',$id)
            ->update(['status' => 1]);

        DB::table('items')
            ->where('category_id',$id)
            ->update(['status' => 1]);

        $categ = DB::table('category')->where('parent_id','=',$id)->get();
        return $categ;
    }

    public function getAllCategoryName(){
        $allname = DB::table('category')->whereNull('deleted_at')->get();
        return $allname;
    }

    public function catenabled($id){
        DB::table('category')
            ->where('id',$id)
            ->update(['status'=>1]);
    }

    public function catdisabled($id){
        DB::table('category')
            ->where('id',$id)
            ->update(['status'=>0]);
    }

    public function getKitchen(){
        $kit = Kitchen::get();
        return $kit;
    }

    public function getKitchenByCat($catID) {
        $kitchen    = Category::select('kitchen_id')->where('id','=',$catID)->first();
        return $kitchen;   
    }

    public function getLevelByParentCat($category) {
        $level_attr  = Category::select('level')->where('id','=',$category)->first();
        $level       = $level_attr->level;
        return $level;
    }

    public function getParentCat(){
        $branch        = Utility::getCurrentBranch();
        $restaurant    = Utility::getCurrentRestaurant();
        $status        = StatusConstance::CATEGORY_AVAILABLE_STATUS;
        $query         = Category::query();
        if($branch != 0 || $branch != null){
            $query     = $query->where('branch_id',$branch);
        }
        if($restaurant != 0 || $restaurant != null){
            $query      = $query->where('restaurant_id',$restaurant);
        }
        $category       = $query->where('parent_id','=',0)->where('status',$status)
                                ->whereNull('deleted_at')->get();       
     
        return $category;
    }

}