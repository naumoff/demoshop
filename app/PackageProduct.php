<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'package_product';
    protected $fillable = [
        'id',
        'package_id',
        'product_id'
    ];
    #endregion
    
    #region MAIN METHODS
    public static function getProductIdsByPackageId($packageId)
    {
        return array_flatten(self::where('package_id','=',$packageId)
            ->get(['product_id'])
            ->toArray()
        );
    }
    
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
    #endregion
}
