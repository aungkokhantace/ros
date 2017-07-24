<?php
namespace App\RMS\Promotion;

use App\RMS\PromotionItem\PromotionItem;
use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\ReturnMessage;


class PromotionRepository implements PromotionRepositoryInterface
{

    public function All()
    {
        $promotion = Promotion::all();
        return $promotion;
    }

    public function store($paramObj,$sell_item)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            foreach($sell_item as $item){
                $paramObj               = new PromotionItem();
                $paramObj->promotion_id = $tempObj->id;
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

    public function update($paramObj,$sell_item)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj    = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $id         = $paramObj->id;
            if(isset($sell_item)) {
                PromotionItem::where('promotion_id',$id)->delete();
                foreach ($sell_item as $item)
                {
                    $paramObj               = new PromotionItem();
                    $paramObj->promotion_id = $id;
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

    public function delete($id)
    {
            $tempItem               = PromotionItem::where('promotion_id', '=', $id)->first();
            $tempItem               = Utility::addDeletedBy($tempItem);
            $tempItem->deleted_at   = date('Y-m-d H:m:i');
            $tempItem->save();
            $tempObj                = Promotion::find($id);
            $tempObj                = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at    = date('Y-m-d H:m:i');
            $tempObj->save();
    }
}