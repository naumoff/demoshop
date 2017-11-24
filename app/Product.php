<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    #region CLASS PROPERTIES
    protected $dates = ['deleted_at'];
    #endregion
    
    #region RELATION METHODS
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }
    #endregion
}
