<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return Auth::user();
});

Route::get('users', function(){
    return User::all();
});

Route::group(['namespace'=>'Api\Auth'], function(){
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:api');
});

Route::get('/posts',[PostController::class,'index'])->middleware('auth:api');
Route::post('/posts',[PostController::class,'store'])->middleware('auth:api');
Route::put('/posts/{id}',[PostController::class,'update'])->middleware('auth:api');
Route::delete('/posts/{id}',[PostController::class,'destroy'])->middleware('auth:api');
Route::get('/posts/{id}',[PostController::class,'show'])->middleware('auth:api');

// Po @ nie działa
// Route::group(['namespace'=>'Api\Auth'], function(){
//     Route::post('/login', 'AuthController@login');
//     Route::post('/logout', 'AuthenticationController@logout')->middleware('auth:api');
//     Route::post('/register', 'RegisterController@register');
//     Route::post('/forgot', 'ForgotPasswordController@forgot');
//     Route::post('/reset', 'ForgotPasswordController@reset');
// });

// Route::group([
//     'prefix' => 'products',
//     'middleware' => 'auth:api'
// ], function () {
//     Route::get('/all', [ProductController::class, 'getAll'])->middleware(['products:PRODUCT_ACCESS']);
// });
