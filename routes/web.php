<?php

//************* TESTING
use App\User;
use App\Events\CustomerRejected;
Route::get('test', function(){
    
    $result = Storage::disk('products')->files('/');
    dump($result);
    
    $url = Storage::disk('products')->url($result[0]);
    dump($url);
    
    $rawContent1 = Storage::disk('products')->get("images (1).jpg");
    dump($rawContent1);
    
});

Route::get('test/{id}', 'Admin\ProductsController@deleteCategoryTest');

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
    
    /**
     * User Management
     */
    Route::get('users','Admin\UsersController@index')->name('admin-users');
    Route::get('users/approved','Admin\UsersController@showApproved');
    Route::get('users/pending','Admin\UsersController@showPending');
    Route::get('users/suspended','Admin\UsersController@showSuspended');
    Route::get('users/rejected','Admin\UsersController@showRejected');
    Route::get('users/all','Admin\UsersController@showAll');
    
    /**
     * Product Management
     */
    Route::get('products','Admin\ProductsController@index')->name('admin-products');
    
    //categories
    Route::get('products/categories','Admin\ProductsController@showCategories')->name('admin-categories'); //+
    Route::post('products/add-category','Admin\ProductsController@addCategory'); //+
    Route::patch('products/update-category', 'Admin\ProductsController@updateCategory'); //+
    
    //groups
    Route::get('products/{cat_id}/groups','Admin\ProductsController@showGroupsByCategory')->name('admin-groups'); //+
    Route::post('products/add-group','Admin\ProductsController@addGroup'); //+
    Route::patch('products/update-group','Admin\ProductsController@updateGroup'); //+
    
    //products
    Route::get('products/{cat_id}/{group_id}/products','Admin\ProductsController@showProductsByCategoryByGroup');
    
    Route::get('products/{cat_id}/create-product', 'Admin\ProductsController@createProduct'); // -
    Route::post('products/add-product', 'Admin\ProductsController@addProduct'); // -
    
    Route::get('products/{prod_id}/edit-product','Admin\ProductsController@editProduct'); // -
    Route::patch('products/update-product','Admin\ProductsController@updateProduct'); // -
    
    //AJAX requests
    Route::post('/category/status', 'Admin\ProductsController@changeCategoryStatus');
    Route::post('/group/status', 'Admin\ProductsController@changeGroupStatus');
    Route::post('/product/status', 'Admin\ProductsController@changeProductStatus'); // +
    Route::post('/product-action/status', 'Admin\ProductsController@changeProductActionStatus'); // +
    
    Route::post('/category/delete', 'Admin\ProductsController@deleteCategory');
    Route::post('/group/delete', 'Admin\ProductsController@deleteGroup');
    Route::post('/product/delete', 'Admin\ProductsController@deleteProduct'); // +
});

//CUSTOMER DASHBOARD
Route::group(['prefix'=>'customer', 'middleware'=>'customer'], function(){
    Route::get('home','Customers\CustomerController@index')->name('customer-home');
});