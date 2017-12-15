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
    public static function getLastPartnerId()
    {
        $lastPartnerId = self::orderBy('id','desc')->first();
        if($lastPartnerId === null){
            return 0;
        }else{
            return $lastPartnerId->id;
        }
    }
    #endregion
    
    #region SCOPE METHODS
    public function scopeActive($query)
    {
        return $query->where('active','=',1);
    }
    public function scopeOrderBySequence($query)
    {
        return $query->orderBy('sequence','asc');
    }
    public function scopeCurrent($query)
    {
        return $query->where('current','=',1);
    }
    public function scopeNext($query, $pastPartnerSequence, $pastPartnerId){
        return $query->where('id','!=',$pastPartnerId)
            ->where('sequence','>=', $pastPartnerSequence);
    }
    public function scopeWithinEurLimit($query, $orderAmountInEur)
    {
        return $query->where('total_limit_eur','>',$orderAmountInEur);
    }
    
    #endregion
    
    #region RELATION METHODS
    public function paymentCards()
    {
        return $this->hasMany(PaymentCard::class,'holder_id','id');
    }
    #endregion
}
