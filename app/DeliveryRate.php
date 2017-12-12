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
    public static function calculateDeliveryCost($weight)
    {
        $deliveryRange = self::where('min_weight', '<=', $weight)
            ->where('max_weight','>=',$weight)->first();
        
        if($deliveryRange !== null){
            return $deliveryRange->delivery_cost;
        }else{
            return false;
        }
    }
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    #endregion
}
