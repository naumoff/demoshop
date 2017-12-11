<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 06.12.2017
 * Time: 17:33
 */

namespace App\Services;

use App\Package;
use App\Product;

class InvoiceRowCalculatorService
{
    #region MAIN METHODS
    public function calculateProductCostByQty(Product $product, $qty)
    {
        if($product->price_rub_manual == null){
            $cost = $product->price_rub_auto * $qty;
        }else{
            $cost = $product->price_rub_manual * $qty;
        }
        
        return $cost;
    }
    
    public function calculateProductWeightByQty(Product $product, $qty)
    {
        $weight = $product->weight_gr * $qty;
        return $weight;
    }
    
    public function calculatePackageCostByQty(Package $package, $qty)
    {
        return $package->package_price * $qty;
    }
    
    public function calculatePackageWeightByQty(Package $package, $qty)
    {
        return $package->weight_gr * $qty;
    }
    #endregion
    
    #region SERVICE METHODS
    #endregion
}