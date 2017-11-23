<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    #region MAIN METHODS
    public function index()
    {
        return view('admin.users-home');
    }
    
    public function showApproved()
    {
        return view('admin.users-approved');
    }
    
    public function showPending()
    {
        return view('admin.users-pending');
    }
    
    public function showSuspended()
    {
        return view('admin.users-suspended');
    }
    
    public function showRejected()
    {
        return view('admin.users-rejected');
    }
    
    public function showAll()
    {
        return view('admin.users-all');
    }
    #endregion
    
    #region SERVICE METHODS
    
    #endregion
}
