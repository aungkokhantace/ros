<?php

namespace App\Http\Controllers\Backend\Auth;

use App\RMS\Infrastructure\Forms\LoginFormRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\RMS\Permission\Permission;
use App\RMS\Permission\PermissionRepository;
use App\Log\LogCustom;
use App\Http\Controllers\Controller;
use App\Status\StatusConstance;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use App\Session;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';
    protected $guard='Cashier';
    protected $redirectAfterLogout='login';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    public function getLoginForm()
    {
        if (Auth::guard('Cashier')->check())
        {
            return redirect('Backend/Dashboard');
        }
        if(Auth::guard('Kitchen')->check())
        {
            return redirect('Kitchen/kitchen');
        }
        return view('Backend.auth.login');
    }
    public function postDataForCashierLogin(LoginFormRequest $request){
        $status     = StatusConstance::USER_AVAILABLE_STATUS;
        $request->validate();
        $validation = Auth::guard('Cashier')->attempt([
            'user_name'=>$request->user_name,
            'password'=>$request->password,
            'status'=>$status,
        ]);
        if(!$validation){//if validation has errors,go to getFailedLoginMessage()
            return redirect()->back()->withErrors($this->getFailedLoginMessage());
        }
        else{
            // $array      = array('name' => 'shwekayin');
            // $request->session()->push('key', $array);
            $role_id        = Auth::guard('Cashier')->user()->role_id;
            $permissionMod  = new PermissionRepository();
            $permissions    = $permissionMod->getModuleArr($role_id);
            // dd($permissions);
            $module     = array();
            foreach($permissions as $key => $permission) {
                $module     = $permission['module_id'];
                $request->session()->push('module',$module);
            }
            LogCustom::deleteLogFileAutomatically();
            return redirect('Backend/userAuth');
        }
    }
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? Lang::get('auth.failed')
            : 'These credentials do not match our records.';
    }
}
