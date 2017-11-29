<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    #region RELATION METHODS
    public function products()
    {
        return $this->belongsToMany(Product::class,'color_product');
    }
    #endregion
}
