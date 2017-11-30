<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'currency_rates';
    static private $tableName = 'currency_rates';
    #endregion
    
    #region MAIN METHODS
    public static function getEurRubRate()
    {
        return \DB::table(self::$tableName)
            ->where('eur_rub','!=',null)
            ->latest()
            ->first()
            ->eur_rub;
    }
    #endregion
    
    #region SERVICE METHODS
    
    #endregion
}
