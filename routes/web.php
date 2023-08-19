<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Stock\StockController;

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
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
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

// Product Routes
Route::controller(StockController::class)->group(function() {
    Route::get('/stock/list', 'index')->name('stock.index');
    Route::get('/stock/create', 'create')->name('stock.create');
    Route::post('/stock/store', 'store')->name('stock.store');
    Route::get('/stock/edit/{id}', 'edit')->name('stock.edit');
    Route::post('/stock/update/{id}', 'update')->name('stock.update');
});



