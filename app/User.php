<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

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
    
    /**
     * soft delete property
     */
    protected $dates = ['deleted_at'];
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
    
    public static function getUsers(string $status = null, string $role = null, $order = 'desc')
    {
        $whereStatusCondition = ['id','>',0];
        $whereRoleCondition = ['id','>',0];
    
        if($status !== null){
            $whereStatusCondition = ['status','=',$status];
        }
        
        if($role !== null){
            $roleId = Role::getRoleId($role);
            $whereRoleCondition = ['role_id','=',$roleId];
        }
        
        $users = self::where([$whereRoleCondition, $whereStatusCondition])
            ->orderBy('created_at', $order);
        return $users;
    }

    #endregion
    
    #region RELATION METHODS
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    
    //one-to-many
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id','id');
    }
    
    // many-to-many
    public function questions()
    {
        return $this->belongsToMany(Question::class,
            'question_user',
            'question_id',
            'user_id')
            ->withPivot('answer','created_at');
    }
    #endregion
}
