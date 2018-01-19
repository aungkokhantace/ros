<?php
/**
 * Created by PhpStorm.
 * User: Dell Inspiron
 * Date: 3/24/2016
 * Time: 10:37 AM
 */

namespace App\RMS\MemberType;


use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\RMS\ReturnMessage;
class MemberTypeRepository implements  MemberTypeRepositoryInterface
{
    public function getAllType(){
        $member_types           = MemberType::all();
        return $member_types;
    }

    public function All(){
        $member_types           = MemberType::get();
        return $member_types;
    }

    public function store($paramObj){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj                = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function member_type_delete($id){
        $tempObj                = MemberType::find($id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();
    }

    public function member_type_edit($id){
        $member_type            = DB::table('member_type')->find($id);
        return $member_type;
    }

    public function update($paramObj)
    {
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

    public function check_member($id){
        $subcategory            = DB::table('members')->where('member_type_id', '=', $id)->first();//check whether there are users of this user_type
        return $subcategory;
    }
}