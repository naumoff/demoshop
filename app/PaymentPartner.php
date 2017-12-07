<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentPartner extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'payment_partners';
    protected $fillable = [
        'first_name',
        'last_name',
        'total_limit_eur',
        'total_cards_eur',
        'active',
        'suspended'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function paymentCards()
    {
        return $this->hasMany(PaymentCard::class,'holder_id','id');
    }
    #endregion
}
