<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    #region CLASS PROPERTIES

    #endregion
    
    #region MAIN METHODS
    public static function getColors()
    {
        return self::all();
    }
    
    public static function getColorIdFromColorName($colorName)
    {
        $colorId = self::where('color_code','=',$colorName)->first()->id;
        return $colorId;
    }
    #endregion
    
    #region RELATION METHODS
    public function products()
    {
        return $this->belongsToMany(Product::class,'color_product');
    }
    #endregion
}
