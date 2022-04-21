<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;

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
    return view('welcome');
});

Route::get('/api/products', [ProductController::class,'index']);

Route::get('/shop', [ShopController::class,'index'])->name('shop.index');

Route::post('/add-cart', [ShopController::class,'addCart'])->name('shop.addCart');
Route::post('/delete-cart', [ShopController::class,'deleteCart'])->name('shop.deleteCart');

Route::get('/cart', [ShopController::class,'cart'])->name('shop.cart');

Route::get('/order', [OrderController::class,'create'])->name('order.create');
Route::post('/api/orders', [OrderController::class,'store'])->name('order.store');