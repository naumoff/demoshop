<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    #region CLASS PROPERTIES
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile_phone',
        'country',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    #endregion
    
    #region MAIN METHODS
    public static function checkActiveAdmin()
    {
        if(self::getLoggedUserRole() == config('roles.admin.en')
            && self::getLoggedUserStatus() == config('lists.user_status.approved.en'))
        {
            return true;
        }else{
            return false;
        }
    }
    
    public static function checkActiveCustomer()
    {
        if(self::getLoggedUserRole() == config('roles.customer.en')
            && self::getLoggedUserStatus() == config('lists.user_status.approved.en'))
        {
            return true;
        }else{
            return false;
        }
    }
    
    public static function getLoggedUserRole()
    {
        $loggedUser = Auth::user();
        return $loggedUser->role->role;
    }
    
    public static function getLoggedUserStatus()
    {
        $loggedUser = Auth::user();
        return $loggedUser->status;
    }
    #endregion
    
    #region RELATION METHODS
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    #endregion
}
