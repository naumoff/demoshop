<?php

//************* TESTING
Route::get('test', function(){
    dump(\App\User::getLoggedUserRole());
    dump(\App\User::getLoggedUserStatus());
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()){
        if(Auth::user()->id != config('lists.user_status.approved.en')){
            return redirect('home');
        }else{
            return redirect('home');
        }
    }
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ADMIN DASHBOARD
Route::group(['prefix'=>'admin', 'middleware'=>'admin'], function(){
    Route::get('users','Admin\UserManagementController@index');
});

//CUSTOMER DASHBOARD
Route::group(['prefix'=>'customer', 'middleware'=>'customer'], function(){
    Route::get('customer',function(){
       dd('customer');
    });
});