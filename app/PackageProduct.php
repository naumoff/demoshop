<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'package_product';
    protected $fillable = [
    
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function product()
    {
        return $this->belongsTo(Product::class, 'products');
    }
    
    public function package()
    {
        return $this->belongsTo(Package::class, 'packages');
    }
    #endregion
}
