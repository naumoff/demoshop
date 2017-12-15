<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'orders';
    protected $fillable = [
        'present_id',
        'payment_card_id',
        'invoice_number',
        'order_number',
        'delivery_track_number',
        'user_id',
        'user_first_name',
        'user_last_name',
        'user_email',
        'user_phone',
        'user_country',
        'user_city',
        'user_street',
        'user_building_number',
        'user_apartment_number',
        'user_post_index',
        'order_weight',
        'order_delivery_cost',
        'order_goods_cost',
        'order_total_invoice_amount',
        'order_status',
        'invoice_status'
    ];
    #endregion
    
    #region MAIN METHODS
    public static function getLastInvoiceNumber()
    {
        return 1;
    }
    
    #endregion
    
    #region SCOPE METHODS
    public function scopeNotPaid($query)
    {
        return $query
            ->where('order_status','=',config('lists.order_status.payment_expectation.en'));
    }
    
    public function scopePaid($query)
    {
        return $query
            ->where('order_status','=',config('lists.order_status.order_processing.en'));
    }
    
    public function scopeDispatched($query)
    {
        return $query
            ->where('order_status','=', config('lists.order_status.order_sent.en'));
    }
    public function scopeOverdue($query)
    {
        return $query
            ->where('invoice_status','=',config('lists.invoice_status.invoice_expired.en'));
    }
    public function scopeValid($query)
    {
        return $query
            ->where('invoice_status','=',config('lists.invoice_status.invoice_valid.en'));
    }
    #endregion
    
    #region RELATION METHODS
    public function user()
    {
        return $this->belongsTo(User::class,
            'user_id',
            'id');
    }
    
    //many-to-many
    public function products()
    {
        return $this->belongstoMany(Product::class,
            'order_product',
            'order_id',
            'product_id')
            ->withPivot('id','qty','cost','weight');
    }
    
    //many-to-many
    public function packages()
    {
        return $this->belongsToMany(Package::class,
            'order_package',
            'order_id',
            'package_id')
            ->withPivot('id','qty','cost','weight');
    }
    
    public function present()
    {
        return $this->belongsTo(Present::class,
            'present_id',
            'id');
    }
    
    public function paymentCard()
    {
        return $this->belongsTo(PaymentCard::class,
            'payment_card_id',
            'id');
    }
    
    #endregion
}
