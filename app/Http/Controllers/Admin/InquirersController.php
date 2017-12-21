<?php

namespace App\Http\Controllers\Admin;

use App\Inquirer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    #endregion
    
    #region AJAX INCLUSIONS
    public function loadQuestionsForInquirer(Inquirer $inquirer)
    {
        dd('questions');
    }
    
    public function loadUsersForInquirer(Inquirer $inquirer)
    {
        dd('users');
    }
    #endregion
}
