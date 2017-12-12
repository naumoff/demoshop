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
    public static function getAvailablePresents($goodsCost)
    {
        return self::where('min_order_value_rub','<=',$goodsCost)
            ->where('max_order_value_rub','>=',$goodsCost)->get();
    }
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function orders()
    {
        return $this->hasMany(Order::class, 'present_id','id');
    }
    #endregion
}
