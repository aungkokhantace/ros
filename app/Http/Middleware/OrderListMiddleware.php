<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\RMS\User;
use App\RMS\Role\Role;
use App\RMS\Permission\Permission;

class OrderListMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {

        $role_id = Auth::guard($guard)->user()->role_id;
        $role    = Permission::select('module_id')->where('role_id','=',$role_id)->get();
        foreach($role as $r){
            $array[] = $r->module_id;
        }
        if(in_array(17,$array)){
            return $next( $request );
        }else{
            //return response('Unauthorized',401);
            return redirect('Cashier/Unauthorized');
        }
    }
}
