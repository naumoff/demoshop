<?php

//************* TESTING
use App\User;
use App\Events\CustomerRejected;
Route::get('test', function(){
    $category = \App\Category::find(3);
    $category->delete();
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
    //General management
    Route::get('home','Admin\AdminController@index')->name('admin-home');
    
    //User management
    Route::get('users','Admin\UsersController@index')->name('admin-users');
    Route::get('users/approved','Admin\UsersController@showApproved');
    Route::get('users/pending','Admin\UsersController@showPending');
    Route::get('users/suspended','Admin\UsersController@showSuspended');
    Route::get('users/rejected','Admin\UsersController@showRejected');
    Route::get('users/all','Admin\UsersController@showAll');
    
    //Product management
    Route::get('products','Admin\ProductsController@index')->name('admin-products');
    Route::get('products/categories','Admin\ProductsController@showCategories');
});

//CUSTOMER DASHBOARD
Route::group(['prefix'=>'customer', 'middleware'=>'customer'], function(){
    Route::get('home','Customer\CustomerController@index')->name('customer-home');
});