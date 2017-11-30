<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorProduct extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'color_product';
    
    protected $fillable = [
        'color_id',
        'product_id',
        'url'
    ];
    #endregion
    
    #region MAIN METHODS
   
    #endregion
}
