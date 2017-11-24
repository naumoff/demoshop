<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    #region RELATION METHODS
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }
    #endregion
}
