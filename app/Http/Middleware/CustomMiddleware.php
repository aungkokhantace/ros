<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
class CustomMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {

            if($guard == 'Cashier'){
                return redirect('login');
            }
            if($guard == 'Kitchen'){
                return redirect('login');
            }

        }
      //  else{
      //      return redirect('Cashier/Dashboard      ');
      //
        return $next($request);
    }
}
