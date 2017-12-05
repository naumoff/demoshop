<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Present extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'presents';
    protected $fillable = [
        'present_ru',
        'present_de',
        'description',
        'urls',
        'weight_gr',
        'min_order_value_rub',
        'max_order_value_rub',
        'active'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    #endregion
}
