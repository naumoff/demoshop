<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerRole
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
            if($userRole == config('roles.customer.en')
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
