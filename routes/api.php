<?php

use Illuminate\Http\Request;

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

// Sample route
Route::get('/helloWorld', 'helloWorldController@getHelloWorld');

// Auth Routes
Route::post('register', 'AuthApi\RegisterController@register');
Route::post('login', 'AuthApi\LoginController@login');
Route::post('refresh', 'AuthApi\LoginController@refresh');
Route::group(['middleware' => 'auth:api'], function(){

    Route::post('logout', 'AuthApi\LoginController@logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

// Shops Routes
Route::get('/shop','shopController@list');
Route::get('/shop/{id}', 'shopController@get');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user/shop', 'shopController@myList');
    Route::get('/user/shop/{id}', 'shopController@myGet');
    Route::post('/shop', 'shopController@post');
    Route::put('/shop', 'shopController@update');
    Route::delete('/shop/{id}', 'shopController@delete');
});

//Custom category controllers
Route::get('/category','categoryController@list');
Route::get('/category/{id}','categoryController@get');
Route::post('/category','categoryController@post');
Route::put('/category','categoryController@update');
Route::delete('/category/{title}','categoryController@remove');

//find discounts
Route::middleware('auth:api')->post('/user/findDiscounts','findDiscountsController@list');


