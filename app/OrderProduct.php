<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'order_product';
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'cost',
        'weight'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    #endregion
}
