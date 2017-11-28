<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    #region CLASS PROPERTIES
    protected $dates = ['deleted_at'];
    #endregion
    
    #region MAIN METHODS
    public static function getFirstActiveCategoryId()
    {
        $category_id = self::where('active','=',1)
            ->orderBy('category', 'asc')
            ->first()->id;
        return $category_id;
    }
    #endregion
    
    #region SCOPE METHODS
    public function scopeGetCategories($query)
    {
        return $query->where('id','>',0);
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
    public function groups()
    {
        return $this->hasMany(
            Group::class,
            'category_id',
            'id');
    }
    
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            Group::class);
    }
    #endergion
}
