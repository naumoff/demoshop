<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    
    #region MAIN METHODS
    public static function getRoleId($roleName)
    {
        return self::where('role','=',$roleName)->first()->id;
    }
    #endregion
    
    #region RELATION METHODS
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
    #endregion
}
