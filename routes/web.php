<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Dealer\DealerController;
use App\Http\Controllers\Dealer\DealerOrderController;
use App\Http\Controllers\SubDealer\SubDealerController;
use App\Http\Controllers\SubDealer\SubDealerOrderController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Reports\ReportController;
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
Route::group(['middleware' => ['auth', 'checkSessionId']], function () {

    // User Authentication Routes
    Route::controller(LoginRegisterController::class)->group(function() {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::post('/logout', 'logout')->name('logout');
    });

    //Common Controller Routes

    Route::controller(CommonController::class)->group(function() {
        Route::get('/common/allneworders', 'index')->name('common.index');
        Route::get('/common/checkoutofstock', 'checkoutofstock')->name('common.checkoutofstock');
        Route::get('/newpasswordpage', 'newpasswordpage')->name('newpasswordpage');
        Route::post('/storenewpassword', 'storenewpassword')->name('storenewpassword');
    });


    Route::controller(UserController::class)->group(function() {
        Route::get('/user/list', 'index')->name('user.index');
        Route::get('/user/create', 'create')->name('user.create');
        Route::post('/user/store', 'store')->name('user.store');
        Route::get('/user/edit/{id}', 'edit')->name('user.edit');
        Route::post('/user/update/{id}', 'update')->name('user.update');
        Route::get('/user/destroy/{id}', 'destroy')->name('user.destroy');
        Route::get('/user/subdealer/{id}', 'subdealer')->name('user.subdealer');
        Route::get('/user/viewsubdelear', 'viewsubdelear')->name('user.viewsubdelear');
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
        Route::post('/dealerorder/placeorder', 'create')->name('dealerorder.create');
        Route::get('/dealerorder/allorderslist', 'show')->name('dealerorder.show');
        Route::get('/dealerorder/allsubdealerorderslist', 'showdealerorder')->name('dealerorder.showdealerorder');
        Route::get('/dealerorder/orderdetails/{id}', 'ordershow')->name('dealerorder.ordershow');
        Route::get('/dealerorder/subdealerorderdetails/{id}', 'subdealerordershow')->name('dealerorder.subdealerordershow');
        Route::get('/dealerorder/subdealerorderacceptedstatus/{id}', 'subdealerorderacceptedstatus')->name('dealerorder.subdealerorderacceptedstatus');
        Route::get('/dealerorder/subdealerordercancelstatus/{id}', 'subdealerordercancelstatus')->name('dealerorder.subdealerordercancelstatus');
        Route::get('/dealerorder/subdealerplaceorder/{orderid}', 'subdealerplaceorder')->name('dealerorder.subdealerplaceorder');
        
        
    });

    // Order Routes
    Route::controller(OrderController::class)->group(function() {
        Route::get('/order/list', 'index')->name('order.index');
        Route::get('/order/orderdetails/{id}', 'show')->name('order.show');
        Route::get('/suborder/list', 'suborderindex')->name('suborder.index');
        Route::get('/suborder/orderdetails/{id}', 'subordershow')->name('suborder.show');
        Route::post('/order/update/{id}', 'update')->name('order.update');
    });

    // Report Routes
    Route::controller(ReportController::class)->group(function() {
        Route::get('/report/stock', 'stockreport')->name('report.stock');
        Route::get('/report/dealer', 'dealerreport')->name('report.dealer');
        Route::match(array('GET','POST'),'/report/order', 'orderreport')->name('report.order');
        Route::post('/report/orderdatasubmit', 'orderdata')->name('report.orderdata');
        
    });

    // Sub Dealer Routes
    Route::controller(SubDealerController::class)->group(function() {
        Route::get('/subdealer/list', 'index')->name('subdealer.index');
    });

    // Sub Dealer Order Routes
    Route::controller(SubDealerOrderController::class)->group(function() {
        Route::get('/subdealerorder/orderlist', 'index')->name('subdealerorder.index');
        Route::post('/subdealerorder/store', 'store')->name('subdealerorder.store');
        Route::post('/subdealerorder/destroy', 'destroy')->name('subdealerorder.destroy');
        Route::post('/subdealerorder/placeorder', 'create')->name('subdealerorder.create');
        Route::get('/subdealerorder/allorderslist', 'show')->name('subdealerorder.show');
        Route::get('/subdealerorder/orderdetails/{id}', 'ordershow')->name('subdealerorder.ordershow');
        
    });


});