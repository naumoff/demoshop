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
        if(\App\User::checkActiveAdmin()){
            return redirect('admin/home');
        }elseif(\App\User::checkActiveCustomer()){
            return redirect('customer/home');
        }
    }
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ADMIN DASHBOARD
Route::group(['prefix'=>'admin', 'middleware'=>'admin'], function(){
    Route::get('home','Admin\AdminController@index')->name('admin-home');
});

//CUSTOMER DASHBOARD
Route::group(['prefix'=>'customer', 'middleware'=>'customer'], function(){
    Route::get('home','Customer\CustomerController@index')->name('customer-home');
});