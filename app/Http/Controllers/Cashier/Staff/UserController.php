<?php

namespace App\Http\Controllers\Cashier\Staff;

use App\RMS\Infrastructure\Forms\UserEditFormRequest;
use App\RMS\Infrastructure\Forms\UserEntryFormRequest;
use App\RMS\Infrastructure\Forms\ProfileEditRequest;
use App\RMS\Role\Role;
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
        return view('cashier.user.UserList')->with('users', $users)
            ->with('roles', $roles)->with('cur_time', $cur_time)
            ->with('kitchens',$kitchens);
    }

    public function create(){
        $roles      = $this->userRepository->getRoles();
        $kitchens   = $this->userRepository->getKitchens();

        return view('cashier.user.User')->with('roles', $roles)->with('kitchens',$kitchens);
    }

    public function profile($id){
        if(Auth::guard('Cashier')->check()){
            //$id     = Auth::guard('Cashier')->user()->id;
            $user   = User::find($id);

            return view('cashier.user.profile')->with('user', $user);
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
            return redirect()->action('Cashier\Staff\UserController@index')->withMessage(FormatGenerator::message('Success','Password Changed'));
        }else{
            return redirect()->action('Cashier\Staff\UserController@index')->withMessage(FormatGenerator::message('Fail','Password did not change'));
        }
    }

    public function store(UserEntryFormRequest $request){
        $request->validate();
        $id         = Auth::guard('Cashier')->user()->id;
        $name       = trim(Input::get('name'));
        $staffId    = trim(Input::get('staff_id'));
        $password   = trim(bcrypt(Input::get('login_password')));
        $roleId     = Input::get('userType');
        $kitchenId  = Input::get('kitchen');

        $paramObj               = new User();
        $paramObj->user_name    = $name;
        $paramObj->staff_id     = $staffId;
        $paramObj->password     = $password;
        $paramObj->role_id      = $roleId;
        $paramObj->kitchen_id   = $kitchenId;
        $paramObj->status       = 1;

        $result = $this->userRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Staff\UserController@index')
                ->withMessage(FormatGenerator::message('Success', 'User created ...'));
        }
        else{
            return redirect()->action('Cashier\Staff\UserController@index')
                ->withMessage(FormatGenerator::message('Fail', 'User did not create ...'));
        }
     }

    public function edit($id){
        $user       = $this->userRepository->getID($id);
        $roles      = Role::get();
        $kitchens   = $this->userRepository->getKitchens();

        return view('cashier.user.User')->with('user', $user)->with('roles', $roles)->with('kitchens',$kitchens);
    }

    public function active($id) {
        if (Auth::guard('Cashier')->user()->role_id !== 1) {
            alert()->warning('You have no permission in this action!')->persistent('Close');
            return back();
        }
        $user     = $this->userRepository->active($id);
        return redirect()->action('Cashier\Staff\UserController@index')
        ->withMessage(FormatGenerator::message('Success', 'User Active ...')); //to redirect listing page
    }

    public function inactive($id) {
        if (Auth::guard('Cashier')->user()->role_id !== 1) {
            alert()->warning('You have no permission in this action!')->persistent('Close');
            return back();
        }
        $user     = $this->userRepository->inactive($id);
        return redirect()->action('Cashier\Staff\UserController@index')
        ->withMessage(FormatGenerator::message('Success', 'User Inactive ...')); //to redirect listing page
    }

    public function update(UserEditFormRequest $request){
        $request->validate();
        $id          = Input::get('id');
        $name        = Input::get('name');
        $staffId     = Input::get('staff_id');
        $userType    = Input::get('userType');
        $kitchenId   = Input::get('kitchen');
        $updated_by  = Auth::guard('Cashier')->user()->id;
        //check staffid exist or not
        $olduser     = $this->userRepository->getIdForStaffId($id);
        $all         = $this->userRepository->getUsersForStaffId();
        $flag        = 0;
        if($staffId == $olduser->staff_id ){
            $flag = 0;
        }
        else{
            foreach($all as $user){
                if($staffId == $user->staff_id){
                    $flag = 1;
                }
            }
        }
        if($flag == 0){
            if(empty($userType)){
                $result = $this->userRepository->update($id,$name,$staffId,$updated_by);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Cashier\Staff\UserController@index')
                        ->withMessage(FormatGenerator::message('Success', 'User updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Staff\UserController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'User did not update ...'));
                }
            }
            else{
                $result = $this->userRepository->updateWithUserType($id,$name,$staffId,$userType,$kitchenId,$updated_by);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Cashier\Staff\UserController@index')
                        ->withMessage(FormatGenerator::message('Success', 'User updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Staff\UserController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'User did not update ...'));
                }
            }

        }
        elseif($flag == 1){
            //show warning message if staff id is exist
            alert()->warning('Staff ID already exists.Please Try Again!')->persistent('Close');
            return back();
        }
    }

    public function delete($id){
        $new_string = explode(',', $id);
        $deleted_by  = Auth::guard('Cashier')->user()->id;
        foreach($new_string as $id){
            $this->userRepository->delete_users($id,$deleted_by);
        }

        return redirect()->action('Cashier\Staff\UserController@index'); //to redirect listing page
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
            }
            if ($r == "Super Admin" || $r == 'Manager' || $r == 'Supervisor') {
                return redirect('Backend/Dashboard');
            }
            else{
                return redirect('Cashier/Dashboard');
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
                    return redirect('Cashier/logout');
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
