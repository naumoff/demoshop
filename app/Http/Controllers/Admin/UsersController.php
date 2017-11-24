<?php

namespace App\Http\Controllers\Admin;

use App\Events\CustomerRegistered;
use App\Helpers\TranslateUserStatus;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    use TranslateUserStatus;
    
    #region CLASS PROPERTIES
    private $usersPerPage = 5;
    #endregion
    
    #region MAIN METHODS
    public function index()
    {
        return view('admin.users-home');
    }
    
    public function showApproved()
    {
        $approvedUsers = User::getUsers(config('lists.user_status.approved.en'),
            config('roles.customer.en'))->paginate($this->usersPerPage);

        return view('admin.users-approved')
            ->with('users',$approvedUsers);
    }
    
    public function showPending()
    {
        $pendingUsers = User::getUsers(config('lists.user_status.pending.en'),
            config('roles.customer.en'))->paginate($this->usersPerPage);
        return view('admin.users-pending')->with('users',$pendingUsers);
    }
    
    public function showSuspended()
    {
        $suspendedUsers = User::getUsers(config('lists.user_status.suspended.en'),
            config('roles.customer.en'))->paginate($this->usersPerPage);
        return view('admin.users-suspended')->with('users',$suspendedUsers);
    }
    
    public function showRejected()
    {
        $rejectedUsers = User::getUsers(config('lists.user_status.rejected.en'),
            config('roles.customer.en'))->paginate($this->usersPerPage);
        return view('admin.users-rejected')->with('users',$rejectedUsers);
    }
    
    public function showAll()
    {
        $user = User::find(2);
        event(new CustomerRegistered($user));
        dd("OK!");
        
        $allUsers = User::getUsers(null, config('roles.customer.en'))
            ->paginate($this->usersPerPage);
        foreach ($allUsers AS $user){
           $user->status = $this->translateStatusEnToRu($user->status);
        }
        return view('admin.users-all')->with('users',$allUsers);
    }
    #endregion
    
    #region AJAX METHODS
    
    #endregion
    
    #region SERVICE METHODS

    #endregion
}
