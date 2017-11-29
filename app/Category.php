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
        $categories = self::where('active', '=', 1)
            ->orderBy('category', 'asc')
            ->get();
        
        foreach ($categories AS $category) {
            $item = $category->groups()->where('active', '=', 1)->first();
            if($item !== null){
                return $category->id;
            };
        }
        return null;
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
