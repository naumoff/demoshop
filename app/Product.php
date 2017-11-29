<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    #region CLASS PROPERTIES
    protected $dates = ['deleted_at'];
    #endregion
    
    #region MAIN METHODS

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
        dump($arrayIds);
        $query->whereIn('group_id',$arrayIds);
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
    #endregion
}
