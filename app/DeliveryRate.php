<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryRate extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'delivery_rates';
    protected $fillable = [
        'min_weight',
        'max_weight',
        'delivery_cost'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    #endregion
}
