<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/24/2016
 * Time: 10:18 AM
 */

namespace App\RMS\Member;

use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\Item\Item;
use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use App\RMS\ReturnMessage;
class MemberRepository implements MemberRepositoryInterface
{
    public function getAllMemberType(){
        $member_type=DB::table('member_type')->get();
        return $member_type;
    }

    public function getCategoryModel(){
        $joinItem=Category:: where('parent_id', '<>', 0)->get();
        return $joinItem;
    }

    public function getCategories(){
        $category   = Category::select('id', 'parent_id', 'name')->get()->toArray();
        return $category;
    }

    public function getItems(){
        $items = Item::select('id','category_id','name')->get()->toArray();
        return $items;
    }

    public function selectCat(){
        $cate = DB::table('category')->where('parent_id','=',0)->get();
        return $cate;
    }

    public function store($paramObj,$fav)
    {

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $id         = $paramObj->id;
            foreach($fav as $item){
                $paramObj               = new Favourite();
                $paramObj->member_id    = $id;
                $paramObj->item_id      = $item;
                $tempItem               = Utility::addCreatedBy($paramObj);
                $tempItem->save();
            }
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function getMemberModel(){
        $joinType=Member::all();
        return $joinType;
    }

    public function getAllItem(){
        $Item=DB::table('items')->get();
        return $Item;
    }

    public function delete($id)
    {
        $tempItem = Favourite::where('member_id', '=', $id)->get();
        foreach($tempItem as $item){
            $tempItem = Utility::addDeletedBy($item);
            $tempItem->deleted_at = date('Y-m-d H:m:i');
            $tempItem->save();
        }
       
        $tempObj = Member::find($id);
        $tempObj = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at = date('Y-m-d H:m:i');
        $tempObj->save();

    }

    public function getMemberModelById($id){
        $joinType=Member::find($id);
        return $joinType;
    }

    public function update($paramObj,$fav)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj    = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $id         = $paramObj->id;
            if(isset($fav)) {
                Favourite::where('member_id',$id)->delete();
                foreach ($fav as $item)
                {
                    $paramObj               = new Favourite();
                    $paramObj->member_id    = $id;
                    $paramObj->item_id      = $item;
                    $tempObj                = Utility::addUpdatedBy($paramObj);
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
}