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
    Route::post('/login',[AuthController::class,'login']);
});

Route::get('/posts',[PostController::class,'index']);
Route::post('/posts',[PostController::class,'store']);
Route::put('/posts/{id}',[PostController::class,'update']);
Route::delete('/posts/{id}',[PostController::class,'destroy']);
Route::get('/posts/{id}',[PostController::class,'show']);








// Route::group(['namespace'=>'Api\Auth'], function(){
//     Route::post('/login', 'AuthController@login');
//     Route::post('/logout', 'AuthenticationController@logout')->middleware('auth:api');
//     Route::post('/register', 'RegisterController@register');
//     Route::post('/forgot', 'ForgotPasswordController@forgot');
//     Route::post('/reset', 'ForgotPasswordController@reset');
// });
