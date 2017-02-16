<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\RMS\User;
use App\RMS\Role\Role;
use App\RMS\Permission\Permission;
use App\RMS\Module\Module;

class ItemMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {

        $role_id = Auth::guard($guard)->user()->role_id;
        $role    = Permission::select('module_id')->where('role_id','=',$role_id)->get();
        foreach($role as $r){
         $array[] = $r->module_id;
        }
        //var_dump($array);
         if(in_array(5,$array)){
             return $next( $request );
         }else{
             //return response('Unauthorized',401);
             return redirect('Cashier/Unauthorized');
         }
    }
}
