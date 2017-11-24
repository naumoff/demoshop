<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
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
