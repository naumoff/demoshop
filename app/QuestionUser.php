<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionUser extends Model
{
    #region CLASS PROPERTIES
    protected $table = 'question_user';
    protected $fillable = [
        'question_id',
        'user_id',
        'answer'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    #endregion
    
    #region RELATION METHODS
    #endregion
}
