<?php

namespace App\Http\Controllers\Cashier\Auth;

use App\RMS\Infrastructure\Forms\LoginFormRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
            return redirect('Cashier/Dashboard');
        }
        if(Auth::guard('Kitchen')->check())
        {
            return redirect('Kitchen/kitchen');
        }
        return view('cashier.auth.login');
    }
    public function postDataForCashierLogin(LoginFormRequest $request){
        $request->validate();
        $validation = Auth::guard('Cashier')->attempt([
            'user_name'=>$request->user_name,
            'password'=>$request->password,
        ]);
        if(!$validation){//if validation has errors,go to getFailedLoginMessage()
            return redirect()->back()->withErrors($this->getFailedLoginMessage());
        }
        else{
            return redirect('Cashier/userAuth');
        }
    }
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? Lang::get('auth.failed')
            : 'These credentials do not match our records.';
    }
}
