<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    
    #region CLASS PROPERTIES
    protected $dates = ['deleted_at'];
    #endregion
    
    #region RELATION METHODS
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class,'group_id', 'id');
    }
    #endregion
}
