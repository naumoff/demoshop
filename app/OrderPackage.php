<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'order_package';
    protected $fillable = [
        'order_id',
        'package_id',
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
