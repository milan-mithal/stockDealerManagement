<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Dealer\DealerController;
use App\Http\Controllers\Dealer\DealerOrderController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Common\CommonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// User Authentication Routes
Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/forgotpassword', 'forgotpassword')->name('forgotpassword');
    Route::post('/forgotpasswordauthenticate', 'forgotpasswordauthenticate')->name('forgotpasswordauthenticate');
    Route::post('/store', 'store')->name('store');
    Route::get('/', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});

// User Authentication Routes
Route::middleware('checkstatus')->group(function () {

    // User Authentication Routes
    Route::controller(LoginRegisterController::class)->group(function() {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::post('/logout', 'logout')->name('logout');
    });

    //Common Controller Routes

    Route::controller(CommonController::class)->group(function() {
        Route::get('/common/allneworders', 'index')->name('common.index');
        Route::get('/common/checkoutofstock', 'checkoutofstock')->name('common.checkoutofstock');
    });


    Route::controller(UserController::class)->group(function() {
        Route::get('/user/list', 'index')->name('user.index');
        Route::get('/user/create', 'create')->name('user.create');
        Route::post('/user/store', 'store')->name('user.store');
        Route::get('/user/edit/{id}', 'edit')->name('user.edit');
        Route::post('/user/update/{id}', 'update')->name('user.update');
        Route::get('/user/destroy/{id}', 'destroy')->name('user.destroy');
    });

    // Product Routes
    Route::controller(ProductController::class)->group(function() {
        Route::get('/product/list', 'index')->name('product.index');
        Route::get('/product/create', 'create')->name('product.create');
        Route::post('/product/store', 'store')->name('product.store');
        Route::get('/product/edit/{id}', 'edit')->name('product.edit');
        Route::post('/product/update/{id}', 'update')->name('product.update');
        Route::get('/product/destroy/{id}', 'destroy')->name('product.destroy');
    });

    // Stock Routes
    Route::controller(StockController::class)->group(function() {
        Route::get('/stock/list', 'index')->name('stock.index');
        Route::get('/stock/create', 'create')->name('stock.create');
        Route::post('/stock/store', 'store')->name('stock.store');
        Route::get('/stock/edit/{id}', 'edit')->name('stock.edit');
        Route::post('/stock/update/{id}', 'update')->name('stock.update');
    });

    // Dealer Routes
    Route::controller(DealerController::class)->group(function() {
        Route::get('/dealer/list', 'index')->name('dealer.index');
    });

    // Dealer Order Routes
    Route::controller(DealerOrderController::class)->group(function() {
        Route::post('/dealerorder/store', 'store')->name('dealerorder.store');
        Route::post('/dealerorder/destroy', 'destroy')->name('dealerorder.destroy');
        Route::get('/dealerorder/orderlist', 'index')->name('dealerorder.index');
        Route::get('/dealerorder/placeorder', 'create')->name('dealerorder.create');
        Route::get('/dealerorder/allorderslist', 'show')->name('dealerorder.show');
        Route::get('/dealerorder/orderdetails/{id}', 'ordershow')->name('dealerorder.ordershow');
        
    });

    // Order Routes
    Route::controller(OrderController::class)->group(function() {
        Route::get('/order/list', 'index')->name('order.index');
        Route::get('/order/orderdetails/{id}', 'show')->name('order.show');
        Route::post('/order/update/{id}', 'update')->name('order.update');
    });
});




