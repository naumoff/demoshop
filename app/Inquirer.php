<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquirer extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'inquirers';
    protected $fillable = [
        'inquirer',
        'active'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function questions()
    {
        return $this->hasMany(Question::class,'inquirer_id','id');
    }
    #endregion
}
