<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->role_id == 1 && Auth::user()->status == 1) {
            return $next($request);
        }else{
            if(Auth::user()->status==0){
                Auth::logout();
                Session::flash('error','Your account has been disabled');
            }
            return redirect()->route('login');
        }
        

    }
}
