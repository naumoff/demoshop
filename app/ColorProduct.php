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
    
    #region SCOPE METHODS
    public function scopeByProductId($query,$productId)
    {
        return $query->where('product_id','=',$productId);
    }
    
    public function scopeByColorId($query, $colorId)
    {
        return $query->where('color_id','=',$colorId);
    }
    
    #endregion
    
    #region RELATION METHODS
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    #endregion
}
