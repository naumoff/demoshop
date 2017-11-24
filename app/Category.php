<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    #region RELATION METHODS
    public function groups()
    {
        return $this->hasMany(Group::class,'category_id','id');
    }
    #endergion
}
