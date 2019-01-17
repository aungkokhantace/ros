<?php

namespace App\Http\Controllers\Backend\Staff;

use App\RMS\Infrastructure\Forms\UserEditFormRequest;
use App\RMS\Infrastructure\Forms\UserEntryFormRequest;
use App\RMS\Infrastructure\Forms\ProfileEditRequest;
use App\RMS\Role\Role;
use App\RMS\Utility;
use App\Status\StatusConstance;
use App\RMS\Permission\Permission;
use App\Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Input;
use App\Http\Middleware\CustomMiddleware;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
        $this->middleware('custom');
    }

    public function index(Request $request){
        $users      = $this->userRepository->getUsers();
        $roles      = $this->userRepository->getRoles();
        $kitchens   = $this->userRepository->getKitchens();
        $cur_time   = Carbon::now();
        return view('Backend.user.UserList')->with('users', $users)
            ->with('roles', $roles)->with('cur_time', $cur_time)
            ->with('kitchens',$kitchens);
    }

    public function create(){
        $roles      = $this->userRepository->getRoles();
        $kitchens   = $this->userRepository->getKitchens();

        return view('Backend.user.User')->with('roles', $roles)->with('kitchens',$kitchens);
    }

    public function profile($id){
        if(Auth::guard('Cashier')->check()){
            //$id     = Auth::guard('Cashier')->user()->id;
            $user   = User::find($id);

            return view('Backend.user.profile')->with('user', $user);
        }
    }
    public function updateProfile(ProfileEditRequest $request){
        $request->validate();
        $staff_id = Input::get('staff_id');
        $password = bcrypt(Input::get('login_password'));
     
        $paramObj = User::find($staff_id);
        $paramObj->id = $staff_id;
        $paramObj->password= $password;
        $paramObj->created_by = $staff_id;
        $result = $this->userRepository->updateProfile($paramObj);

        if($result['aceplusStatusCode'] == ReturnMessage::OK){
            return redirect()->action('Backend\Staff\UserController@index')->withMessage(FormatGenerator::message('Success','Password Changed'));
        }else{
            return redirect()->action('Backend\Staff\UserController@index')->withMessage(FormatGenerator::message('Fail','Password did not change'));
        }
    }

    public function store(UserEntryFormRequest $request){
        $request->validate();
        $id         = Auth::guard('Cashier')->user()->id;
        $name       = trim(Input::get('name'));
        $password   = trim(bcrypt(Input::get('login_password')));
        $roleId     = Input::get('userType');
        $kitchenId  = Input::get('kitchen');

        $paramObj               = new User();
        $paramObj->user_name    = $name;
        $paramObj->password     = $password;
        $paramObj->role_id      = $roleId;
        $paramObj->staff_id      = Utility::generateStaffId();
        $paramObj->kitchen_id   = $kitchenId;
        $paramObj->status       = 1;

        $result = $this->userRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Staff\UserController@index')
                ->withMessage(FormatGenerator::message('Success', 'User created ...'));
        }
        else{
            return redirect()->action('Backend\Staff\UserController@index')
                ->withMessage(FormatGenerator::message('Fail', 'User did not create ...'));
        }
     }

    public function edit($id){
        $user       = $this->userRepository->getID($id);
        $roles      = Role::get();
        $kitchens   = $this->userRepository->getKitchens();

        return view('Backend.user.User')->with('user', $user)->with('roles', $roles)->with('kitchens',$kitchens);
    }

    public function active($id) {
        if (Auth::guard('Cashier')->user()->role_id !== 1) {
            alert()->warning('You have no permission in this action!')->persistent('Close');
            return back();
        }
        $userObj  = User::find($id);
        $user_status    = $userObj->status;
        if ($user_status == StatusConstance::USER_AVAILABLE_STATUS) {
            alert()->warning('This User is already active!')->persistent('Close');
            return back();
        } else {
            $user     = $this->userRepository->active($id);
            return redirect()->action('Backend\Staff\UserController@index')
            ->withMessage(FormatGenerator::message('Success', 'User Active ...')); //to redirect listing page
        }
    }

    public function inactive($id) {
        if (Auth::guard('Cashier')->user()->role_id !== 1) {
            alert()->warning('You have no permission in this action!')->persistent('Close');
            return back();
        }
        $userObj  = User::find($id);
        $user_status    = $userObj->status;
        if ($user_status == StatusConstance::USER_UNAVAILABLE_STATUS) {
            alert()->warning('This User is already inactive!')->persistent('Close');
            return back();
        } else {
            $user     = $this->userRepository->inactive($id);
            return redirect()->action('Backend\Staff\UserController@index')
            ->withMessage(FormatGenerator::message('Success', 'User Inactive ...')); //to redirect listing page
        }
    }

    public function update(UserEditFormRequest $request){
        $request->validate();

    
        $id          = Input::get('id');
        $name        = Input::get('name');
        $userType    = Input::get('userType');
        $kitchenId   = Input::get('kitchen');
        $updated_by  = Auth::guard('Cashier')->user()->id;
        //check staffid exist or not
        $olduser     = $this->userRepository->getIdForStaffId($id);
        $all         = $this->userRepository->getUsersForStaffId($id);
        if(in_array($name, $all)) {
            alert()->warning('Username already exists.Please Try Again!')->persistent('Close');
            return back();
        } else {
            if(empty($userType)){
                $result = $this->userRepository->update($id,$name,$updated_by);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Backend\Staff\UserController@index')
                        ->withMessage(FormatGenerator::message('Success', 'User updated ...'));
                }
                else{
                    return redirect()->action('Backend\Staff\UserController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'User did not update ...'));
                }
            }
            else{
                $result = $this->userRepository->updateWithUserType($id,$name,$userType,$kitchenId,$updated_by);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Backend\Staff\UserController@index')
                        ->withMessage(FormatGenerator::message('Success', 'User updated ...'));
                }
                else{
                    return redirect()->action('Backend\Staff\UserController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'User did not update ...'));
                }
            }
        }
    }

    public function delete($id){
        $new_string = explode(',', $id);
        $deleted_by  = Auth::guard('Cashier')->user()->id;
        foreach($new_string as $id){
            $this->userRepository->delete_users($id,$deleted_by);
        }

        return redirect()->action('Backend\Staff\UserController@index')->withMessage(FormatGenerator::message('Success', 'Success delete User ...')); //to redirect listing page
    }


    public function getAuthUser(){ //after login, update status field 0 to 1
        if (Auth::guard('Cashier')->check()) {
            $id         = Auth::guard('Cashier')->user()->id;
            $cur        = Carbon::now();
            $this->userRepository->changeDisableToEnable($id, $cur);
            $role       = User::find($id);
            $r = $role->roles->name;
            if($r == "Kitchen"){
                return redirect('Kitchen/kitchen');
            }else{
                return redirect('Backend/Dashboard');
            }
        }
    }
    public function updateDataBeforeLogout(Request $request){ //before logout, update status field 1 to 0
        if (Auth::guard('Cashier')->check()){
            $id         = Auth::guard('Cashier')->user()->id;
            // $this->userRepository->changeEnableToDisable($id);
            $role       = User::find($id);
            $r          = $role->roles->name;

            //Remove Module Session  
            $request->session()->forget('module');
            if($r != "Kitchen"){
                    return redirect('Backend/logout');
                }
            if($r == "Kitchen"){
                return redirect('Kitchen/logout');
             }
            }
        else{
            echo "fail";
        }
    }
    


}
