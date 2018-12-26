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
    public function store($paramObj,$input,$remark)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $id_arr     = array();
            $check      = $input['check'];
            if ($check <= 0) {
                $tempObj    = Utility::addCreatedBy($paramObj);
                $tempObj->save();

                $inserted_id = $tempObj->id;
                $first_id    = $tempObj->id;
                $product_type = 1; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu
                $stock_code = Utility::generateStockCode($inserted_id,$product_type);
                $paramObj = Item::find($inserted_id);
                $paramObj->stock_code = $stock_code;
                $paramObj->save();
                $id  = $paramObj->id;                   
                array_push($id_arr, $id);
            } else {
                $count      = count($input['continent']);
                $maxID      = DB::table('items')->max('id');
                // dd($maxID);

                $uniqID     = uniqid();
                $groupID    = $uniqID . $maxID;
               for ($i = 0; $i < $count; $i++) {
                    $isDefault  = 0;
                    if ($i == 0) {
                        $isDefault  = 1;
                    }

                    $tempObj                = new item();
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
                    $id  = $paramObj->id;
                    // dd($id,"awef");
                    array_push($id_arr, $id);
               }
            }
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
             $returnedObj['data']              = $id_arr;
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
        $data=DB::table('items')->whereNull('deleted_at')->where('status',1)->get();
        return $data;
    }

    public function getContinent()
    {
        $continent     = Continent::select('id','name','description')->whereNull('deleted_at')->get()->toArray();
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
        // dd($paramObj,$oldprice);
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

        // $tempObj = Item::find($id);
        $tempObj    = Item::where('id',$id)->get();
        $a=(object)$tempObj;
        foreach ($a as $key => $value) {
           $value = Utility::addDeletedBy($value);
            $value->deleted_at = date('Y-m-d H:m:i');
             $value->save();
        }
        // dd("finies");

        // dd($tempObj,$a);
        // $tempObj = Utility::addDeletedBy($tempObj);
        // dd($tempObj);
        // $tempObj->deleted_at = date('Y-m-d H:m:i');
        // $tempObj->save();
    }
    public function getitem_forinvestory($id){
        $datas = Item::where('status',1)->whereNull('deleted_at')->where('category_id',$id)->get();
        return $datas;
    }

    public function get_category_id(){
       $data = Item::whereNull('deleted_at')->where('status',1)->select('category_id')->get();
       $item_ary = array();
       foreach($data as $item){
           array_push($item_ary,$item->category_id);
       }
       return $item_ary;
    }

    public function getparentCategory(){
         $category = Category::where('parent_id',0)->select('id as parent_id')->get();
         return $category;
    }
    public function getParent_Id($id){
        dd($id);
        $group = Category::where('parent_id',$id)->whereNull('deleted_at')->where('status',1)->get();
        dd($group);
        return $group;
    }

}
