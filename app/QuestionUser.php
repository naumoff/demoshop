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
        'answer',
        'created_at'
    ];
    #endregion
    
    #region MAIN METHODS
    #endregion
    
    #region SCOPE METHODS
    public function scopeUser($query, User $user)
    {
        return $query->where('user_id','=',$user->id);
    }
    public function scopeInquirer($query, Inquirer $inquirer)
    {
        $questionIds = [];
        foreach ($inquirer->questions AS $question){
             $questionIds[] = $question->id;
        }
        return $query->whereIn('question_id',$questionIds);
    }
    #endregion
    
    #region RELATION METHODS
    public function question()
    {
        return $this->belongsTo(Question::class,'question_id','id');
    }
    #endregion
}
