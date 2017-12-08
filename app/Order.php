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
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function user()
    {
        return $this->belongsTo(User::class,
            'user_id',
            'id');
    }
    
    public function products()
    {
        return $this->belongstoMany(Product::class,
            'order_product',
            'order_id',
            'product_id');
    }
    
    public function packages()
    {
        return $this->belongsToMany(Package::class,
            'order_package',
            'order_id',
            'package_id');
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