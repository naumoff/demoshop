<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    #region CLASS PROPERTIES
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'group_id',
        'product_ru',
        'product_de',
        'description',
        'pictures',
        'price_eur',
        'price_rub_auto',
        'price_rub_manual',
        'price_with_discount',
        'discount_start',
        'discount_end',
        'discount_active',
        'weight_gr',
        'active'
    ];

    #endregion
    
    #region MAIN METHODS
    public function updatePriceRubAuto($EurRubRate)
    {
        $this->price_rub_auto = $this->price_eur * $EurRubRate;
    }
    
    #endregion
    
    #region SCOPE METHODS
    public function scopeGetProducts($query)
    {
        return $query->where('id','>',0);
    }
    
    public function scopeByCategoryId($query, $category_id)
    {
        $groupIds = Group::where('category_id','=',$category_id)
            ->get(['id'])
            ->toArray();
        
        $arrayIds = array_flatten($groupIds);

        $query->whereIn('group_id',$arrayIds);
    }
    
    public function scopeExcludeProductIds($querry, $productIds)
    {
        return $querry->whereNotIn('id',$productIds);
    }
    
    public function scopeByGroupId($query, $group_id)
    {
        return $query->where('group_id','=',$group_id);
    }
    
    public function scopeActive($query)
    {
        return $query->where('active','=',1);
    }
    
    public function scopeNonActive($query)
    {
        return $query->where('active','=',0);
    }
    #endregion
    
    #region RELATION METHODS
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }
    
    public function colors()
    {
        return $this->belongsTo(Color::class,'color_product');
    }
    
    public function packages()
    {
        return $this->belongsTo(Package::class, 'color_product');
    }
    
    public function orders()
    {
        return $this->belongsToMany(Order::class,
            'order_product',
            'product_id',
            'order_id');
    }
    
    #endregion
}
