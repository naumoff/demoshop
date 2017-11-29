<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    
    #region CLASS PROPERTIES
    protected $dates = ['deleted_at'];
    #endregion
    
    #region MAIN METHODS
    public static function getFirstActiveGroupId($categoryId)
    {
        $group = self::where('category_id','=',$categoryId)
            ->where('active','=',1)
            ->orderBy('group','asc')
            ->first();
        
        if($group == null){
            return null;
        }else{
            return $group->id;
        }
    }
    #endregion
    
    #region SCOPES METHODS
    public function scopeGetGroups($query)
    {
        return $query->where('id','>',0);
    }
    
    public function scopeByCategoryId($query, $categoryId)
    {
        return $query->where('category_id','=',$categoryId);
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
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class,'group_id', 'id');
    }
    #endregion
}
