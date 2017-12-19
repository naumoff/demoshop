<?php

//************* TESTING
use App\User;
use App\Events\CustomerRejected;
use Illuminate\Support\Facades\Storage;
use App\Services\PaymentPartnerSelectorService;

Route::get('test', function(){
    
    $order1 = \App\Order::find(1);
    $order2 = \App\Order::find(2);
    $order3 = \App\Order::find(3);
    
    dd($order1->paymentCard->paymentPartner->last_name);
    
//    $service1 = new PaymentPartnerSelectorService($order1);
//    $service2 = new PaymentPartnerSelectorService($order2);
//    $service3 = new PaymentPartnerSelectorService($order3);
//
//    $service1->setPaymentCardForOrder();
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

Route::get('/home', 'HomeController@index')
    ->name('home');

// ADMIN DASHBOARD
Route::group(['prefix'=>'admin', 'middleware'=>'admin'], function(){
    //General management
    Route::get('home','Admin\AdminController@index')
        ->name('admin-home');
    
    /**
     * User Management
     */
    Route::get('users','Admin\UsersController@index')
        ->name('admin-users');
    Route::get('users/approved','Admin\UsersController@showApproved');
    Route::get('users/pending','Admin\UsersController@showPending');
    Route::get('users/suspended','Admin\UsersController@showSuspended');
    Route::get('users/rejected','Admin\UsersController@showRejected');
    Route::get('users/all','Admin\UsersController@showAll');
    
    /**
     * Product Management
     */
    Route::get('products','Admin\ProductsController@index')
        ->name('admin-products');
    
    //categories
    Route::get('products/categories','Admin\ProductsController@showCategories')
        ->name('admin-categories'); //+
    Route::post('products/add-category','Admin\ProductsController@addCategory'); //+
    Route::patch('products/update-category', 'Admin\ProductsController@updateCategory'); //+
    
    //groups
    Route::get('products/{cat_id}/groups','Admin\ProductsController@showGroupsByCategory')
        ->name('admin-groups'); //+
    Route::post('products/add-group','Admin\ProductsController@addGroup'); //+
    Route::patch('products/update-group','Admin\ProductsController@updateGroup'); //+
    
    //products
    Route::get('products/{cat_id}/{group_id}/products','Admin\ProductsController@showProductsByCategoryByGroup')
        ->name('admin-products');
    
    Route::get('products/{cat_id}/create-product', 'Admin\ProductsController@createProduct'); // +
    Route::post('products/add-product', 'Admin\ProductsController@addProduct'); // +
    Route::get('products/{prod_id}/create-photo', 'Admin\ProductsController@createPhoto')
        ->name('admin-create-photo'); // -
    Route::post('products/add-photo', 'Admin\ProductsController@addPhoto')
        ->name('admin-add-photo'); // +
    
    Route::get('products/{prod_id}/edit-product','Admin\ProductsController@editProduct')
        ->name('admin-edit-product'); // +
    Route::patch('products/update-product','Admin\ProductsController@updateProduct'); // +
    Route::get('products/{prod_id}/edit-photo','Admin\ProductsController@editPhoto')
        ->name('admin-edit-product-photo'); // +
    
    //exchange rates
    Route::get('/products/create-currency-rate', 'Admin\ProductsController@createCurrencyRate');
    Route::post('/products/currency-rates', 'Admin\ProductsController@storeCurrencyRate');
    
    /**
     * Package Management
     */
    Route::resource('packages', 'Admin\PackagesController',['except'=>['show']]);
    
    Route::get('packages/{pack_id}/products/show','Admin\PackagesController@showPackageProductsList')
        ->name('admin-create-package-products');// +
    Route::get('packages/{pack_id}/products/show/{cat_id}/{group_id}','Admin\PackagesController@showProductsList')
        ->name('admin-add-product-to-package'); //-
    Route::post('packages/{pack_id}/products', 'Admin\PackagesController@storeProductsList');
    
    Route::patch('packages/{pack_id}/update-package-price', 'Admin\PackagesController@updatePackageRublePrice')
        ->name('admin-update-package-ruble-price');
    
    /**
     * Present Management
     */
    Route::resource('presents', 'Admin\PresentsController', ['except'=>['show']]);
    Route::get('presents/{present_id}/edit-photo', 'Admin\PresentsController@editPhoto');
    Route::delete('presents/{present_id}/delete-photo','Admin\PresentsController@deletePhoto');
    Route::patch('presents/{present_id}/add-photo','Admin\PresentsController@addPhoto')
        ->name('admin-present-add-photo');

    /**
     * Payment Partners Management
     */
    Route::resource('partners','Admin\PartnersController', ['except'=>['show']]);
    Route::get('partners/{part_id}/createPaymentCard', 'Admin\PartnersController@createPaymentCard')
        ->name('admin-partner-add-card');
    Route::post('partners/{part_id}/storePaymentCard', 'Admin\PartnersController@storePaymentCard')
        ->name('admin-partner-store-card');
    Route::patch('partners/payment-card/{paymentCard}', 'Admin\PartnersController@updatePaymentCard')
        ->name('admin-partner-update-card');
    
    /**
     * Sales Management
     */
    //orders
    Route::get('sales/orders/not-paid', 'Admin\OrdersController@notPaidOrders');
    Route::get('sales/orders/paid', 'Admin\OrdersController@paidOrders');
    Route::get('sales/orders/dispatched', 'Admin\OrdersController@dispatchedOrders');
    Route::get('sales/orders/overdue', 'Admin\OrdersController@paymentOverdueOrders');
    Route::get('sales/orders/{order}/edit','Admin\OrdersController@orderEdit')
        ->name('admin-order-edit');
    
    //delivery
    Route::get('sales','Admin\AdminController@sales');
    Route::resource('sales/deliveries', 'Admin\DeliveryRatesController',
        ['only'=>['index','store','update','destroy']]);

    /**
     * AJAX requests
     */
    //AJAX requests
    Route::post('/category/status', 'Admin\ProductsController@changeCategoryStatus');
    Route::post('/group/status', 'Admin\ProductsController@changeGroupStatus');
    Route::post('/product/status', 'Admin\ProductsController@changeProductStatus'); // +
    Route::post('/product-action/status', 'Admin\ProductsController@changeProductActionStatus'); // +
    Route::post('/package/status', 'Admin\PackagesController@changePackageStatus');
    Route::post('/present/status', 'Admin\PresentsController@changePresentStatus');
    
    Route::patch('/partner/active', 'Admin\PartnersController@changePartnerActivity');
    Route::patch('/partner/current', 'Admin\PartnersController@changePartnerCurrent');
    Route::patch('/card/active', 'Admin\PartnersController@changeCardActivity');
    
    Route::post('/category/delete', 'Admin\ProductsController@deleteCategory');
    Route::post('/group/delete', 'Admin\ProductsController@deleteGroup');
    Route::post('/product/delete', 'Admin\ProductsController@deleteProduct'); // +
    Route::post('/photo/delete', 'Admin\ProductsController@deletePhoto'); // +
    Route::delete('/package-product/delete', 'Admin\PackagesController@deleteProductFromPackage')
        ->name('admin-delete-product-from-package');
    Route::delete('/partner-card/delete', 'Admin\PartnersController@deletePaymentCardFromPartner');
    
    Route::get('/photo/{prod_id}/{color_code}', 'Admin\ProductsController@formGroupLoaderForProductPhoto'); //-
});

//CUSTOMER DASHBOARD
Route::group(['prefix'=>'customer', 'middleware'=>'customer'], function(){
    Route::get('home','Customers\CustomerController@index')->name('customer-home');
});