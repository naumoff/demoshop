<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    #region CLASS PROPERTIES
    protected $dates = ['deleted_at'];
    #endregion
    
    #region MAIN METHODS
    public static function getCategories()
    {
        $categories = self::where('id','>',0);
        return $categories;
    }
    #endregion
    
    #region RELATION METHODS
    public function groups()
    {
        return $this->hasMany(Group::class,'category_id','id');
    }
    #endergion
}
