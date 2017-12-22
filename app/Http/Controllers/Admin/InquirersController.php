<?php

namespace App\Http\Controllers\Admin;

use App\Inquirer;
use App\Question;
use App\QuestionUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class InquirersController extends Controller
{
    #region MAIN METHODS

    public function index()
    {
        $inquirers = Inquirer::with('questions.users')->paginate(15);

        return view('admin.inquirers.inquirers',['inquirers'=>$inquirers]);
    }

    public function create()
    {
        dd(2);
    }

    public function store(Request $request)
    {
        dd(3);
    }

    public function show(Inquirer $inquirer)
    {
        return view('admin.inquirers.show-inquirer',[
            'inquirer'=>$inquirer
        ]);
    }

    public function edit($id)
    {
        dd(5);
    }

    public function update(Request $request, $id)
    {
        dd(6);
    }

    public function destroy($id)
    {
        dd(7);
    }
    
    //show answers of all users for one question
    public function showAnswersForOneQuestion(Inquirer $inquirer, Question $question)
    {
//        dd($question->users);

        return view('admin.inquirers.question-users',[
            'inquirer'=>$inquirer,
            'question'=>$question
        ]);
    }
    //show answers of one user for one inquirer
    public function showAnswersForOneUser(Inquirer $inquirer, User $user)
    {
        $questionUser = QuestionUser::user($user)->inquirer($inquirer)->get();
        return view('admin.inquirers.user-answers',[
            'inquirer'=>$inquirer,
            'user'=>$user,
            'questionUser'=>$questionUser
        ]);
    }
    #endregion
    
    #region AJAX INCLUSIONS
    public function loadQuestionsForInquirer(Inquirer $inquirer)
    {
        $questions = $inquirer->questions;
        return view('inclusions.admin.inquirers.questions',[
            'questions'=>$questions
        ]);
    }
    
    public function loadUsersForInquirer(Inquirer $inquirer)
    {
        $users = $inquirer->questions->first()->users;
        return view('inclusions.admin.inquirers.users',[
            'users'=>$users,
            'inquirer'=>$inquirer
        ]);
    }

    public function getUserAnswersForInquirer(Inquirer $inquirer, User $user)
    {
        $questionUser = QuestionUser::user($user)->inquirer($inquirer)->get();
        dd($collection);
    }
    #endregion

    #region SERVICE METHODS
    private function getInquirerCompletionDate(Inquirer $inquirer, User $user)
    {
        $completedAt = $inquirer
            ->questions()
            ->first()
            ->question_users()
            ->where('user_id','=',$user->id)
            ->first()
            ->created_at;
        return $completedAt;
    }
    #endregion
}
