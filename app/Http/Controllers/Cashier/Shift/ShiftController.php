<?php

namespace App\Http\Controllers\Cashier\Shift;

// use App\RMS\Infrastructure\Forms\ShiftEditRequest;
use App\RMS\Shift\Shift;
use App\RMS\Shift\ShiftCategory;
use App\RMS\Shift\ShiftUser;
use App\RMS\Shift\ShiftSetMenu;
use App\RMS\Category\Category;
use App\RMS\SetMenu\SetMenu;
use App\RMS\Infrastructure\Forms\CreateShiftRequest;
// use App\RMS\Infrastructure\Forms\EditCategoryRequest;
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

    public function index() {
        $shifts      = $this->shiftRepository->allShift();
        return view('cashier.shift.Shift_Listing')->with('shifts',$shifts);
    }

    public function create() {
        return view('cashier.shift.Shift');
    }

    public function store(CreateShiftRequest $request) {
        $status         = StatusConstance::SHIFT_AVAILABLE_STATUS;
        $name                   = $request->get('name');
        $description            = $request->get('description');
        $count_shift        = Shift::select('id')->where('status',$status)->whereNull('deleted_at')->get()->count();
        $is_last            = 0;
        if ($count_shift == 0) {
            $is_last        = 1;
        }
        $paramObj               = new Shift();
        $paramObj->name         = $name;
        $paramObj->description  = $description;
        $paramObj->is_last_shift= $is_last;
        $result                 = $this->shiftRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
             return redirect()->action('Cashier\Shift\ShiftController@index')
                 ->withMessage(FormatGenerator::message('Success', 'Shift created ...'));
        } else{
             return redirect()->action('Cashier\Shift\ShiftController@index')
                 ->withMessage(FormatGenerator::message('Fail', 'Shift did not create ...'));
        }
    }

    public function delete($id)
    {
        //Check if Default
        $status         = StatusConstance::SHIFT_AVAILABLE_STATUS;
        $get_last         = Shift::select('is_last_shift')->where('id',$id)->first();
        $check_last       = $get_last->is_last_shift;
        $count_shift      = Shift::select('id')->where('status',$status)->whereNull('deleted_at')->get()->count();
        if ($check_last == 1 AND $count_shift > 0) {
             alert()->warning('Please Change Last Shift Before Delete!')->persistent('Close');
//            return back();
            return redirect()->action('Cashier\Shift\ShiftController@index');
        } else {
            $new_string = explode(',', $id);
            foreach($new_string as $id){
                $this->shiftRepository->delete($id);
            }
            return redirect()->action('Cashier\Shift\ShiftController@index');
        }
    }

    public function last_update($id)
    {
        //Check if Default
        $status         = StatusConstance::SHIFT_AVAILABLE_STATUS;
        $tempObj                = Shift::where('is_last_shift',1)->whereNull('deleted_at')->first();
        $tempObj->is_last_shift = 0;
        $tempObj->save();

        $paramObj                   = Shift::find($id);
        $paramObj->is_last_shift    = 1;
        $result                     = $this->shiftRepository->update($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
             return redirect()->action('Cashier\Shift\ShiftController@index')
                 ->withMessage(FormatGenerator::message('Success', 'Shift last created ...'));
        } else{
             return redirect()->action('Cashier\Shift\ShiftController@index')
                 ->withMessage(FormatGenerator::message('Fail', 'Shift last did not create ...'));
        }
    }

    public function permission($id) {
        $user_role      = StatusConstance::WAITER_ROLE;
        $shift          = Shift::find($id);
        $shift_category = $this->shiftRepository->getShiftCategoryID($id);
        $shift_setmenu  = $this->shiftRepository->getShiftSetMenuID($id);
        $shift_user     = $this->shiftRepository->getShiftUserID($id);
        $cat_status     = StatusConstance::CATEGORY_AVAILABLE_STATUS;
        $set_status     = StatusConstance::SETMENU_AVAILABLE_STATUS;
        $user_status    = StatusConstance::SHIFT_USER_AVAILABLE_STATUS;

        $id_arr         = array($id);
        $category       = Category::select('id','name')->where('parent_id','=',0)->where('status',$cat_status)->get();
        $setmenu        = SetMenu::select('id','set_menus_name')
                          ->where('status',$set_status)
                          ->whereNull('deleted_at')->get();
        $shift_other_users   = ShiftUser::select('user_id')
                              ->whereNotIn('shift_id',$id_arr)
                              ->where('status',$user_status)
                              ->whereNull('deleted_at')
                              ->get()->toArray();
        $users          = User::select('id','user_name')
                          ->where('role_id','=',$user_role)
                          ->whereNotIn('id',$shift_other_users)->get();
        return view('cashier.shift.Shift_Type')
                ->with('shift',$shift)
                ->with('shift_category',$shift_category)
                ->with('shift_setmenu',$shift_setmenu)
                ->with('shift_user',$shift_user)
                ->with('category',$category)
                ->with('setmenu',$setmenu)
                ->with('users',$users);
    }

    public function shift_update(Request $request) {
        $shift_id                       = $request->get('id');
        $categories                     = $request->get('category');
        $setmenu                        = $request->get('setmenu');
        $users                          = $request->get('user');
        //Delete Old Shift as unaviable
        $deleted_at                     = date('Y-m-d H:m:i');
        $loginUserId                    = Auth::guard('Cashier')->user()->id;
        $deleteShiftSetmenu             = DB::table('shift_setmenu')
                                          ->where('shift_id',$shift_id)
                                          ->update(['status' => 0,'deleted_at' => $deleted_at,'deleted_by' => $loginUserId]);
        $deleteShiftCategory            = DB::table('shift_category')
                                          ->where('shift_id',$shift_id)
                                          ->update(['status' => 0,'deleted_at' => $deleted_at,'deleted_by' => $loginUserId]);
        $deleteShiftUser                = DB::table('shift_user')
                                          ->where('shift_id',$shift_id)
                                          ->update(['status' => 0,'deleted_at' => $deleted_at,'deleted_by' => $loginUserId]);

        $cat_status                     = StatusConstance::SHIFT_CATEGORY_AVAILABLE_STATUS;
        $set_status                     = StatusConstance::SHIFT_SETMENU_AVAILABLE_STATUS;
        $user_status                    = StatusConstance::USER_AVAILABLE_STATUS;
        if (isset($categories) AND count($categories) > 0) {
            foreach ($categories as $key => $category) {
                $categoryObj                = new ShiftCategory();
                $categoryObj->shift_id      = $shift_id;    
                $categoryObj->category_id   = $category;    
                $categoryObj->status        = $cat_status;
                $result                     = $this->shiftRepository->store($categoryObj);
            }
        }
        if (isset($setmenu) AND count($setmenu) > 0) {
            foreach ($setmenu as $key => $set) {
                $setObj                     = new ShiftSetMenu();
                $setObj->shift_id           = $shift_id;    
                $setObj->setmenu_id         = $set;    
                $setObj->status             = $set_status;
                $result                     = $this->shiftRepository->store($setObj);
            }
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
    /*
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
        $shift_setmenu  = $this->shiftRepository->getShiftSetMenuID($shift_id);
        $shift_user     = $this->shiftRepository->getShiftUserID($shift_id);
        $shift_id_arr   = array($shift_id);
        $category       = Category::select('id','name')->where('parent_id','=',0)->where('status',1)->get();
        $setmenu        = SetMenu::select('id','set_menus_name')->where('status',1)->whereNull('deleted_at')->get();
        $shift_different_user   = ShiftUser::select('user_id')->whereNotIn('shift_id',$shift_id_arr)->where('status',1)->whereNull('deleted_at')->get()->toArray();
        $users          = User::select('id','user_name')->where('role_id','=',$user_role)->whereNotIn('id',$shift_different_user)->get();
        return view('cashier.shift.Shift_Type')
                ->with('shift_name',$shift_name)
                ->with('shift_category',$shift_category)
                ->with('shift_setmenu',$shift_setmenu)
                ->with('shift_user',$shift_user)
                ->with('category',$category)
                ->with('setmenu',$setmenu)
                ->with('users',$users);
    }

    public function update(Request $request){
        $shift                          = $request->get('shift');
        $categories                     = $request->get('category');
        $setmenu                        = $request->get('setmenu');
        $users                          = $request->get('user');
        $shift_id                       = $this->shiftRepository->getDayShiftID($shift);
        //Delete Old Shift as unaviable
        $deleted_at                     = date('Y-m-d H:m:i');
        $loginUserId                    = Auth::guard('Cashier')->user()->id;
        $deleteShiftSetmenu             = DB::table('shift_setmenu')
                                          ->where('shift_id',$shift_id)
                                          ->update(['status' => 0,'deleted_at' => $deleted_at,'deleted_by' => $loginUserId]);
        $deleteShiftCategory            = DB::table('shift_category')
                                          ->where('shift_id',$shift_id)
                                          ->update(['status' => 0,'deleted_at' => $deleted_at,'deleted_by' => $loginUserId]);
        $deleteShiftUser                = DB::table('shift_user')
                                          ->where('shift_id',$shift_id)
                                          ->update(['status' => 0,'deleted_at' => $deleted_at,'deleted_by' => $loginUserId]);

        $cat_status                     = StatusConstance::SHIFT_CATEGORY_AVAILABLE_STATUS;
        $set_status                     = StatusConstance::SHIFT_SETMENU_AVAILABLE_STATUS;
        $user_status                    = StatusConstance::USER_AVAILABLE_STATUS;
        if (isset($categories) AND count($categories) > 0) {
            foreach ($categories as $key => $category) {
                $categoryObj                = new ShiftCategory();
                $categoryObj->shift_id      = $shift_id;    
                $categoryObj->category_id   = $category;    
                $categoryObj->status        = $cat_status;
                $result                     = $this->shiftRepository->store($categoryObj);
            }
        }
        if (isset($setmenu) AND count($setmenu) > 0) {
            foreach ($setmenu as $key => $set) {
                $setObj                     = new ShiftSetMenu();
                $setObj->shift_id           = $shift_id;    
                $setObj->setmenu_id         = $set;    
                $setObj->status             = $set_status;
                $result                     = $this->shiftRepository->store($setObj);
            }
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
    */
}