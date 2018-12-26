<?php

/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/8/2016
 * Time: 10:22 AM
 */
namespace App\RMS\Shift;
use App\RMS\SetMenu\SetMenu;
use App\User;
use Illuminate\Support\Facades\DB;
use App\RMS\Utility;
use App\RMS\ReturnMessage;
use App\RMS\Shift\Shift;
use App\RMS\Shift\ShiftCategory;
use App\RMS\Category\Category;
use App\RMS\User\UserRepository;
use App\RMS\Shift\ShiftUser;
use App\RMS\Shift\ShiftSetMenu;
use App\Status\StatusConstance;
use App\RMS\Restaurant\Restaurant;
use App\RMS\Branch\Branch;

class ShiftRepository implements ShiftRepositoryInterface
{
    public function allShift() {
        $status         = StatusConstance::SHIFT_AVAILABLE_STATUS;
        $branch_id         = Utility::getCurrentBranch();
        $restaurant_id     = Utility::getCurrentRestaurant();

        $query             = Shift::query();
        $query             = $query->where('status',$status)->whereNull('deleted_at');
        if($restaurant_id != 0 || $restaurant_id != null){
            $query      = $query->where('restaurant_id',$restaurant_id);
        }
        if($branch_id != 0 || $branch_id != null){
            $query        = $query->where('branch_id',$branch_id);
        }
        $get_shift      = $query->get();
        return $get_shift;
    }
    
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
        $restaurant_id          = Utility::getCurrentRestaurant();
        $branch_id              = Utility::getCurrentBranch();

        $status                 = StatusConstance::SHIFT_CATEGORY_AVAILABLE_STATUS;
        $categoryID             = ShiftCategory::select('category_id')->where('shift_id',$id)->where('restaurant_id',$restaurant_id)->where('branch_id',$branch_id)->where('status',$status)->whereNull('deleted_at')->get();
        $categoryArr        = array();
        foreach ($categoryID as $key => $category) {
            $categoryArr[$key]      = $category->category_id;
        }
        return $categoryArr;
    }

    public function getShiftSetMenuID($id) {
        $restaurant_id          = Utility::getCurrentRestaurant();
        $branch_id              = Utility::getCurrentBranch();

        $status                 = StatusConstance::SETMENU_AVAILABLE_STATUS;
        $setmenuID              = ShiftSetMenu::select('setmenu_id')->where('shift_id',$id)->where('restaurant_id',$restaurant_id)->where('branch_id',$branch_id)->where('status',$status)->whereNull('deleted_at')->get();
        $setMenuArr             = array();
        foreach ($setmenuID as $key => $setMenu) {
            $setMenuArr[$key]      = $setMenu->setmenu_id;
        }
        return $setMenuArr;
    }

    public function getShiftUserID($id) {
        $restaurant_id          = Utility::getCurrentRestaurant();
        $branch_id              = Utility::getCurrentBranch();

        $status                 = StatusConstance::SHIFT_USER_AVAILABLE_STATUS;
        $userID                 = ShiftUser::select('user_id')->where('shift_id',$id)->where('restaurant_id',$restaurant_id)->where('branch_id',$branch_id)->where('status',$status)->whereNull('deleted_at')->get();
        $userArr                = array();
        foreach ($userID as $key => $user) {
            $userArr[$key]      = $user->user_id;
        }
        return $userArr;
    }

    public function Shift_edit($id){
        $shifts =DB::table('shift')->find($id);
        return $shifts;
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
    
    public function delete($id){
        $tempObj = Shift::find($id);
        $tempObj = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at = date('Y-m-d H:m:i');
        $tempObj->save();
    }
    public function getAll(){
        $branch        = Utility::getCurrentBranch();
        $restaurant    = Utility::getCurrentRestaurant();

        $query         = Category::query();
        $query         = $query->whereNull('deleted_at');
        if($restaurant != 0 || $restaurant != null){
            $query      = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query     = $query->where('branch_id',$branch);
        }
        $category        = $query->get();
        return $category;


    }
    public function getCategory($branch_id,$restaurant_id){
        $status        = StatusConstance::CATEGORY_AVAILABLE_STATUS;
        $query         = Category::query();
        $category      = $query->where('parent_id','=',0)
            ->where('status',$status)
            ->where('restaurant_id',$restaurant_id)
            ->where('branch_id',$branch_id)
            ->whereNull('deleted_at')
            ->get();
        return $category;
    }

    public function getSetMenu($branch_id,$restaurant_id){
        $status             = StatusConstance::SETMENU_AVAILABLE_STATUS;
        $query              = ShiftSetMenu::query();
        $setmenu           = $query->where('status',$status)
            ->where('restaurant_id',$restaurant_id)
            ->where('branch_id',$branch_id)
            ->whereNull('deleted_at')->get();
        return $setmenu;
    }

    public function getLastShift($restaurant_id,$branch_id){
        $status        = StatusConstance::SHIFT_AVAILABLE_STATUS;
        $query             = Shift::query();
        $query             = $query->whereNull('deleted_at');
        $last_shift       = $query->where('is_last_shift', 1)
            ->whereNull('deleted_at')->first()
            ->where('restaurant_id',$restaurant_id)
            ->where('branch_id',$branch_id)
            ->get();
        return $last_shift;

    }

    public function getShiftUserByBranch($branch_id,$restaurant_id,$shift_other_users){
        $status         = StatusConstance::SHIFT_USER_AVAILABLE_STATUS  ;
        $user_role      = StatusConstance::WAITER_ROLE;
        $query          = User::query();
        $user           = $query->where('role_id','=',$user_role)
            ->whereNotIn('id',$shift_other_users)
            ->where('status',$status)
            ->where('restaurant_id',$restaurant_id)
            ->where('branch_id',$branch_id)
            ->whereNull('deleted_at')
            ->get();
        return $user;

    }
    public function getShiftByBranch(){
        $branch_id       = Utility::getCurrentBranch();
        $restaurant_id   = Utility::getCurrentRestaurant();

        $status          = StatusConstance::SHIFT_AVAILABLE_STATUS  ;
            $query          = Shift::query();
            $user           = $query->where('status',$status)
                ->where('restaurant_id',$restaurant_id)
                ->where('branch_id',$branch_id)
                ->whereNull('deleted_at')
                ->get();
            return $user;

    }

    public function getShift()
    {   $branch_id         = Utility::getCurrentBranch();
        $restaurant_id     = Utility::getCurrentRestaurant();

        $query             = Shift::query();
        $query             = $query->whereNull('deleted_at');
        if($restaurant_id != 0 || $restaurant_id != null){
            $query      = $query->where('restaurant_id',$restaurant_id);
        }
        if($branch_id != 0 || $branch_id != null){
            $query        = $query->where('branch_id',$branch_id);
        }
        $shift      = $query->get();
        return $shift;

    }


}