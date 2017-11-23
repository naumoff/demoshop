<?php

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

//Route::post('/registration-request', )

Route::get('/home', 'HomeController@index')->name('home');


//************* TESTING
Route::get('test', function(){
   dump(config('lists.secret_words_status'));
   dump(config('roles'));
   dump(config('lists.user_status'));
   dump(config('roles'));
   
   dump(\App\Role::getRoleId(config('roles.admin.en')));
   
   
});