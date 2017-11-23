<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $userRole = User::getLoggedUserRole();
            $userStatus = User::getLoggedUserStatus();
            if($userRole == config('roles.admin.en')
                && $userStatus == config('lists.user_status.approved.en'))
            {
                return $next($request);
            }else{
                return redirect('home');
            }
        }else{
            return redirect('login');
        }
    }
}
