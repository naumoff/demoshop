<?php

//************* TESTING
use App\User;
use App\Events\CustomerRejected;
use Illuminate\Support\Facades\Storage;
use App\Services\PaymentPartnerSelectorService;

Route::get('test', function(){
    
    $order1 = \App\Order::find(10);
    $order2 = \App\Order::find(2);
    $order3 = \App\Order::find(3);


    $service1 = new PaymentPartnerSelectorService($order1);
//    $service2 = new PaymentPartnerSelectorService($order2);
//    $service3 = new PaymentPartnerSelectorService($order3);
//
    $service1->setPaymentCardForOrder();
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

/**
 * ****************************************************************************
 * *                         ADMIN DASHBOARD                                  *
 * ****************************************************************************
 */

Route::group(['prefix'=>'admin', 'middleware'=>'admin'], function(){
    //General management
    Route::get('home','Admin\AdminController@index')
        ->name('admin-home');
    
    /**
     * **********************
     * * USER MANAGEMENT    *
     * **********************
     */
    Route::get('users','Admin\UsersController@index')
        ->name('admin-users');
    Route::get('users/approved','Admin\UsersController@showApproved');
    Route::get('users/pending','Admin\UsersController@showPending');
    Route::get('users/suspended','Admin\UsersController@showSuspended');
    Route::get('users/rejected','Admin\UsersController@showRejected');
    Route::get('users/all','Admin\UsersController@showAll');
    
    /**
     * **********************
     * * PRODUCT MANAGEMENT *
     * **********************
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
    
    //AJAX requests for PRODUCTS
    Route::post('/category/status', 'Admin\ProductsController@changeCategoryStatus');
    Route::post('/group/status', 'Admin\ProductsController@changeGroupStatus');
    Route::post('/product/status', 'Admin\ProductsController@changeProductStatus');
    Route::post('/product-action/status', 'Admin\ProductsController@changeProductActionStatus');
    
    Route::post('/category/delete', 'Admin\ProductsController@deleteCategory');
    Route::post('/group/delete', 'Admin\ProductsController@deleteGroup');
    Route::post('/product/delete', 'Admin\ProductsController@deleteProduct');
    Route::post('/photo/delete', 'Admin\ProductsController@deletePhoto');
    
    Route::get('/photo/{prod_id}/{color_code}', 'Admin\ProductsController@formGroupLoaderForProductPhoto');
    
    /**
     * **********************
     * * PACKAGE MANAGEMENT *
     * **********************
     */
    Route::resource('packages', 'Admin\PackagesController',['except'=>['show']]);
    
    Route::get('packages/{pack_id}/products/show','Admin\PackagesController@showPackageProductsList')
        ->name('admin-create-package-products');// +
    Route::get('packages/{pack_id}/products/show/{cat_id}/{group_id}','Admin\PackagesController@showProductsList')
        ->name('admin-add-product-to-package'); //-
    Route::post('packages/{pack_id}/products', 'Admin\PackagesController@storeProductsList');
    
    Route::patch('packages/{pack_id}/update-package-price', 'Admin\PackagesController@updatePackageRublePrice')
        ->name('admin-update-package-ruble-price');
    //AJAX requests for PACKAGES
    Route::post('/package/status', 'Admin\PackagesController@changePackageStatus');
    Route::delete('/package-product/delete', 'Admin\PackagesController@deleteProductFromPackage')
        ->name('admin-delete-product-from-package');
    
    /**
     * **********************
     * * PRESENT MANAGEMENT *
     * **********************
     */
    Route::resource('presents', 'Admin\PresentsController', ['except'=>['show']]);
    Route::get('presents/{present_id}/edit-photo', 'Admin\PresentsController@editPhoto');
    Route::delete('presents/{present_id}/delete-photo','Admin\PresentsController@deletePhoto');
    Route::patch('presents/{present_id}/add-photo','Admin\PresentsController@addPhoto')
        ->name('admin-present-add-photo');
    //AJAX requests for PRESENTS
    Route::post('/present/status', 'Admin\PresentsController@changePresentStatus');

    /**
     * ***********************
     * * PARTNERS MANAGEMENT *
     * ***********************
     */
    Route::resource('partners','Admin\PartnersController', ['except'=>['show']]);
    Route::get('partners/{part_id}/createPaymentCard', 'Admin\PartnersController@createPaymentCard')
        ->name('admin-partner-add-card');
    Route::post('partners/{part_id}/storePaymentCard', 'Admin\PartnersController@storePaymentCard')
        ->name('admin-partner-store-card');
    Route::patch('partners/payment-card/{paymentCard}', 'Admin\PartnersController@updatePaymentCard')
        ->name('admin-partner-update-card');
    
    //AJAX requests for PARTNERS
    Route::patch('/partner/active', 'Admin\PartnersController@changePartnerActivity');
    Route::patch('/partner/current', 'Admin\PartnersController@changePartnerCurrent');
    Route::patch('/card/active', 'Admin\PartnersController@changeCardActivity');
    Route::delete('/partner-card/delete', 'Admin\PartnersController@deletePaymentCardFromPartner');
    
    /**
     * **********************
     * * SALES MANAGEMENT   *
     * **********************
     */
    //orders
    Route::get('sales/orders/not-paid', 'Admin\OrdersController@notPaidOrders');
    Route::get('sales/orders/paid', 'Admin\OrdersController@paidOrders');
    Route::get('sales/orders/dispatched', 'Admin\OrdersController@dispatchedOrders');
    Route::get('sales/orders/overdue', 'Admin\OrdersController@paymentOverdueOrders');
    Route::get('sales/orders/{order}/edit','Admin\OrdersController@orderEdit')
        ->name('admin-order-edit');

    //load inclusions
    Route::get('sales/orders/{order}/products', 'Admin\OrdersController@loadProductsForOrder')
        ->name('admin-load-order-products');
    Route::get('sales/orders/{order}/packages', 'Admin\OrdersController@loadPackagesForOrder')
        ->name('admin-load-order-packages');
    Route::get('sales/orders/{order}/present', 'Admin\OrdersController@loadPresentForOrder')
        ->name('admin-load-order-present');
    Route::get('sales/orders/{order}/partner', 'Admin\OrdersController@loadPartnerForOrder')
        ->name('admin-load-order-partner');

    Route::get('sales/orders/{order}/address', 'Admin\OrdersController@loadReceptorForOrder')
        ->name('admin-load-order-address');
    Route::patch('/sales/orders/receptor/{order}', 'Admin\OrdersController@updateOrderReceptor')
        ->name('admin-load-order-receptor-update');

    Route::get('sales/orders/{order}/status', 'Admin\OrdersController@loadStatusForOrder')
        ->name('admin-load-order-status');
    Route::patch('/sales/orders/status/{order}', 'Admin\OrdersController@updateOrderStatus')
        ->name('admin-load-order-status-update');
    
    //delivery
    Route::get('sales','Admin\AdminController@sales');
    Route::resource('sales/deliveries', 'Admin\DeliveryRatesController',
        ['only'=>['index','store','update','destroy']]);
    
    //AJAX requests for ORDERS
    Route::delete('/orders/{order}','Admin\OrdersController@deleteOrder')
        ->name('admin-delete-order');
});

/**
 * ****************************************************************************
 * *                         CUSTOMER AREA                                    *
 * ****************************************************************************
 */
Route::group(['prefix'=>'customer', 'middleware'=>'customer'], function(){
    Route::get('home','Customers\CustomerController@index')->name('customer-home');
});