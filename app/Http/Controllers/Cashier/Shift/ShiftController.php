<?php

namespace App\Http\Controllers\Cashier\Shift;

// use App\RMS\Infrastructure\Forms\ShiftEditRequest;
use App\RMS\Shift\Shift;
use App\RMS\Shift\ShiftCategory;
use App\RMS\Shift\ShiftUser;
use App\RMS\Category\Category;
use App\User;
use App\Status\StatusConstance;
use App\RMS\Shift\ShiftRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Auth;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
class ShiftController extends Controller
{
    private $shiftRepository;

    public function __construct(ShiftRepositoryInterface $shiftRepository){
        $this->shiftRepository = $shiftRepository;
    }

    public function Shift($shift){
        $user_role      = StatusConstance::WAITER_ROLE;
        if ($shift == 'day_shift') {
            $shift_name     = StatusConstance::DAY_SHIFT_NAME;
        } 
        if ($shift == 'night_shift') {
            $shift_name     = StatusConstance::NIGHT_SHIFT_NAME;
        }
        $shift_id       = $this->shiftRepository->getDayShiftID($shift_name);
        $shift_category = $this->shiftRepository->getShiftCategoryID($shift_id);
        $shift_user     = $this->shiftRepository->getShiftUserID($shift_id);
        $category       = Category::select('id','name')->where('parent_id','=',0)->get();
        $users          = User::select('id','user_name')->where('role_id','=',$user_role)->get();
        return view('cashier.shift.Shift_Type')
                ->with('shift_name',$shift_name)
                ->with('shift_category',$shift_category)
                ->with('shift_user',$shift_user)
                ->with('category',$category)
                ->with('users',$users);
    }

    public function update(Request $request){
        $shift                          = $request->get('shift');
        $categories                     = $request->get('category');
        $users                          = $request->get('user');
        $shift_id                       = $this->shiftRepository->getDayShiftID($shift);
        //Delete Old Shift as unaviable
        $deleted_at                     = date('Y-m-d H:m:i');
        $loginUserId                    = Auth::guard('Cashier')->user()->id;
        $deleteShiftCategory            = DB::table('shift_category')
                                          ->where('shift_id',$shift_id)
                                          ->update(['status' => 0,'deleted_at' => $deleted_at,'deleted_by' => $loginUserId]);
        $deleteShiftUser                = DB::table('shift_user')
                                          ->where('shift_id',$shift_id)
                                          ->update(['status' => 0,'deleted_at' => $deleted_at,'deleted_by' => $loginUserId]);

        $cat_status                     = StatusConstance::SHIFT_CATEGORY_AVAILABLE_STATUS;
        $user_status                    = StatusConstance::USER_AVAILABLE_STATUS;
        foreach ($categories as $key => $category) {
            $categoryObj                = new ShiftCategory();
            $categoryObj->shift_id      = $shift_id;    
            $categoryObj->category_id   = $category;    
            $categoryObj->status        = $cat_status;
            $result                     = $this->shiftRepository->store($categoryObj);
        }

        foreach ($users as $key => $user) {
            $userObj                = new ShiftUser();
            $userObj->shift_id      = $shift_id;
            $userObj->user_id       = $user;
            $userObj->status        = $user_status;
            $result                 = $this->shiftRepository->store($userObj);
        }
        return redirect()->back()->withMessage(FormatGenerator::message('Success', 'Shift updated ...'));

    }
}