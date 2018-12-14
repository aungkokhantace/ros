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
use App\RMS\Item\Continent;
use Illuminate\Support\Facades\DB;
use InterventionImage;
use App\RMS\ReturnMessage;

class ItemRepository implements ItemRepositoryInterface
{
    public function store($paramObj,$input)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $check      = $input['check'];
            if ($check <= 0) {
                $tempObj    = Utility::addCreatedBy($paramObj);
                $tempObj->save();

                $inserted_id = $tempObj->id;
                $product_type = 1; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu
                $stock_code = Utility::generateStockCode($inserted_id,$product_type);
                $paramObj = Item::find($inserted_id);
                $paramObj->stock_code = $stock_code;
                $paramObj->save();
            } else {
                $count      = count($input['continent']);
                $maxID      = DB::table('items')->max('id');
                $uniqID     = uniqid();
                $groupID    = $uniqID . $maxID;
               for ($i = 0; $i < $count; $i++) {
                    $isDefault  = 0;
                    if ($i == 0) {
                        $isDefault  = 1;
                    }
                    $tempObj    = new item();
                    $tempObj->name          = $input['name'];
                    $file                   = $input['input-file-preview'][$i];
                    $imagedata              = file_get_contents($file);
                    $photo                  = uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move('uploads', $photo);
                    // resizing image
                    $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();
                    $tempObj->image                    = $photo;
                    $tempObj->mobile_image            = base64_encode($image->encoded);
                    $tempObj->description              = $input['description'];
                    $tempObj->price                    = $input['continent-price'][$i];
                    $tempObj->continent_id             = $input['continent'][$i];
                    $tempObj->status                   = $input['status'];
                    $tempObj->category_id              = $input['parent_category'];
                    $tempObj->standard_cooking_time    = $input['standard_cooking_time'];
                    $tempObj->isdefault                = $isDefault;
                    $tempObj->group_id                 = $groupID;
                    $tempObj->has_continent            = $check;
                    $addCreatedBy                      = Utility::addCreatedBy($tempObj);
                    $addCreatedBy->save();

                    //Insert item Code
                    $inserted_id = $addCreatedBy->id;
                    $product_type = 1; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu
                    $stock_code = Utility::generateStockCode($inserted_id,$product_type);
                    $paramObj = Item::find($inserted_id);
                    $paramObj->stock_code = $stock_code;
                    $paramObj->save();
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
        // $category   = Category::select('id', 'parent_id', 'name','status')->where('status','1')->get()->toArray();
        $restaurant          = Utility::getCurrentRestaurant();
        $branch              = Utility::getCurrentBranch();
        $query               = Category::query();
        $query               = $query->whereNull('deleted_at');
        if($restaurant != 0 || $restaurant != null){
            $query           = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query          = $query->where('branch_id',$branch);
        }
        $category           = $query->select('id', 'parent_id', 'name','status')
                                    ->where('status','1')->get()->toArray();
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

    public function getContinent()
    {
        $restaurant          = Utility::getCurrentRestaurant();
        $query               = Continent::query();
        if($restaurant != null || $restaurant != 0){
            $query           = $query->where('restaurant_id',$restaurant);
        }
        $continent           = $query->select('id','name','description')->whereNull('deleted_at')->get()->toArray();  
        return $continent;
    }

    public function getContinentByGroupID($groupID)
    {
        $continent_items    = Item::select('id','image','price','continent_id')
        ->where('group_id','=',$groupID)->whereNull('deleted_at')->get();
        return $continent_items;
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

    public function updateContinent($paramObj,$oldprice)
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

    public function updateNewContinent($paramObj)
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

     public function getCategory($branch_id,$restaurant_id)
    {
       
        $query               = Category::query();
        $query               = $query->whereNull('deleted_at');
        if($restaurant_id != 0 || $restaurant_id != null || $restaurant_id != ''){           
            $query           = $query->where('restaurant_id',$restaurant_id);
        }
        if($branch_id != 0 || $branch_id != null){
            $query          = $query->where('branch_id',$branch_id);
        }
        $category           = $query->select('id', 'parent_id', 'name','status')
                                    ->where('status','1')->get()->toArray();        
          
        return $category;
    }

     public function ChooseCatByID($branch_id)
    {       
      
        $query               = Category::query();
        $query               = $query->whereNull('deleted_at');
       
        if($branch_id != 0 || $branch_id != null){
            $query          = $query->where('branch_id',$branch_id);
        }
        $category           = $query->select('id', 'parent_id', 'name','status')
                                    ->where('status','1')->get()->toArray();
        return $category;
    }

    public function getItem()
    {
        $restaurant          = Utility::getCurrentRestaurant();
        $branch              = Utility::getCurrentBranch();
        $query               = Item::query();
        $query               = $query->whereNull('deleted_at');
        if($restaurant != 0 || $restaurant != null){
            $query           = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query           = $query->where('branch_id',$branch);
        }
        $item                =$query->get();
        return $item;
    }


}