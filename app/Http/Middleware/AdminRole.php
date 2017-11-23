<?php

namespace App\Http\Middleware;

use Closure;

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
            if($userRole != config('roles.admin.en')
                && $userStatus != config('lists.user_status.approved.en'))
            {
                return redirect('home');
            }
        }else{
            return redirect('login');
        }
    
    
        return $next($request);
    }
}
