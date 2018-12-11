<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/6/2016
 * Time: 10:58 AM
 */

namespace App\RMS\Remark;


use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use App\RMS\ReturnMessage;
use App\Status\StatusConstance;
use App\RMS\Remark\Remark;

class RemarkRepository implements RemarkRepositoryInterface
{
    public function store($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj                = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $inserted_id = $tempObj->id;
            $product_type = 5; //Product Type 1 = items, 2 = category, 3 = add on, 4 = set menu// product tye 5= remark
            $stock_code = Utility::generateStockCode($inserted_id,$product_type);
            $paramObj   = Remark::find($inserted_id);
            $paramObj->remark_code = $stock_code;
            $paramObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function getRemark(){
        $Remarks                  = Remark::all();
        return $Remarks;
    }

    public function getRemarkById($id){
        $Remark                   = Remark::find($id);
        return $Remark;
    }

    public function update($paramObj){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj                = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function deleteRemarkData($Remark_id){
        $tempObj                = Remark::find($Remark_id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();
    }



    public function Remarkenabled($id){
        $Remark_enable    = StatusConstance::Remark_AVAILABLE_STATUS;
        DB::table('Remarks')
            ->where('id',$id)
            ->update(['status'=>$Remark_enable]);
    }

    public function Remark_active($id){
         $status     = StatusConstance::REMARK_AVAILABLE_STATUS;
         $tempObj    = Remark::find($id);
         $tempObj->status = $status;
         $tempObj->save();
     }

     public function Remark_inactive($id){
         $status     = StatusConstance::REMARK_UNAVAILABLE_STATUS;
         $tempObj    = Remark::find($id);
         $tempObj->status = $status;
         $tempObj->save();
     }
}
