<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'questions';
    protected $fillable = [
        'inquirer_id',
        'question',
        'url'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    public function inquirer()
    {
        return $this->belongsTo(Inquirer::class,'inquirer_id','id');
    }
    // many-to-many
    public function users()
    {
        return $this->belongsToMany(User::class,'question_user','question_id','user_id');
    }
    #endregion
}
