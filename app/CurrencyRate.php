<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'currency_rates';
    static private $tableName = 'currency_rates';
    
    public $currentEurRubRate;
    #endregion
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    
        $this->currentEurRubRate = self::getEurRubRate();
    }
    
    #region MAIN METHODS
    public static function getEurRubRate()
    {
    
        $result =  \DB::table(self::$tableName)
            ->where('eur_rub','!=',null)
            ->latest()
            ->first();
        
        if($result != null){
            return $result->eur_rub;
        }else{
            return 0;
        }
    }
    
    public static function checkEntriesPresence()
    {
        return count(self::all());
    }
    #endregion
    
    #region SERVICE METHODS
    
    #endregion
}
