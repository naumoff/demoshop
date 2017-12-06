<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCard extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'payment_cards';
    protected $fillable = [
        'holder_id',
        'bank',
        'card_number',
        'card_limit_eur',
        'active',
        'suspended'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function paymentPartner()
    {
        return $this->belongsTo(PaymentPartner::class,'holder_id','id');
    }
    #endregion
}
