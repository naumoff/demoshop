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
    public function scopeGetCards($query)
    {
        return $query->where('id','>',0);
    }
    
    public function scopeByHolderId($query, $holderId)
    {
        return $query->where('holder_id','=',$holderId);
    }
    
    public function scopeActive($query)
    {
        return $query->where('active','=',1);
    }
    #endregion
    
    #region RELATION METHODS
    public function paymentPartner()
    {
        return $this->belongsTo(PaymentPartner::class,
            'holder_id',
            'id');
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class,
            'payment_card_id',
            'id');
    }
    #endregion
}
