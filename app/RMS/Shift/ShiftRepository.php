<?php

/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/8/2016
 * Time: 10:22 AM
 */
namespace App\RMS\Shift;
use Illuminate\Support\Facades\DB;
use App\RMS\Utility;
use App\RMS\ReturnMessage;
use App\RMS\Shift\Shift;
use App\RMS\Shift\ShiftCategory;
use App\RMS\Shift\ShiftUser;
use App\RMS\Shift\ShiftSetMenu;
use App\Status\StatusConstance;
class ShiftRepository implements ShiftRepositoryInterface
{
    public function getDayShiftID($shift_name) {
        $status         = StatusConstance::SHIFT_AVAILABLE_STATUS;
        $shiftObj       = Shift::select('id')
                        ->where('name','=',$shift_name)
                        ->where('status','=',$status)
                        ->first();
        $shiftID         = $shiftObj->id;
        return $shiftID;

    }

    public function getShiftCategoryID($id) {
        $status         = StatusConstance::SHIFT_CATEGORY_AVAILABLE_STATUS;
        $categoryID     = ShiftCategory::select('category_id')->where('shift_id',$id)->where('status',$status)->whereNull('deleted_at')->get();
        $categoryArr        = array();
        foreach ($categoryID as $key => $category) {
            $categoryArr[$key]      = $category->category_id;
        }
        return $categoryArr;
    }

    public function getShiftSetMenuID($id) {
        $status         = StatusConstance::SETMENU_AVAILABLE_STATUS;
        $setmenuID      = ShiftSetMenu::select('setmenu_id')->where('shift_id',$id)->where('status',$status)->whereNull('deleted_at')->get();
        $setMenuArr        = array();
        foreach ($setmenuID as $key => $setMenu) {
            $setMenuArr[$key]      = $setMenu->setmenu_id;
        }
        return $setMenuArr;
    }

    public function getShiftUserID($id) {
        $status         = StatusConstance::SHIFT_USER_AVAILABLE_STATUS;
        $userID         = ShiftUser::select('user_id')->where('shift_id',$id)->where('status',$status)->whereNull('deleted_at')->get();
        $userArr        = array();
        foreach ($userID as $key => $user) {
            $userArr[$key]      = $user->user_id;
        }
        return $userArr;
    }

    public function store($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj    = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

}