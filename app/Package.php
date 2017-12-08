<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'packages';
    protected $fillable = [
        'package_name',
        'package_price',
        'package_start_period',
        'package_end_period',
        'active'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class,'package_product');
    }
    
    public function orders()
    {
        return $this->belongsToMany(Order::class,
            'order_package',
            'package_id',
            'order_id');
    }
    
    #endregion
}
