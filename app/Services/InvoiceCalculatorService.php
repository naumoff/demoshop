<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 06.12.2017
 * Time: 17:33
 */

namespace App\Services;


class InvoiceCalculatorService
{
    #region MAIN METHODS
    public function calculateProductCostByQty($productId, $qty)
    {
        $cost = 1;
        return $cost;
    }
    
    public function calculateProductWeightByQty($productId, $qty)
    {
        $weight = 1;
        return $weight;
    }
    #endregion
    
    #region SERVICE METHODS
    #endregion
}