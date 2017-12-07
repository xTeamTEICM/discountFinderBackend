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
Route::post('logout', 'AuthApi\LoginController@logout');
Route::get('/user', function (Request $request) {
    return $request->user();
});

// Shops Routes
Route::get('/shop','shopController@list');
Route::get('/shop/{id}', 'shopController@get');

Route::get('/user/shop', 'shopController@myList');
Route::get('/user/shop/{id}', 'shopController@myGet');
Route::post('/shop', 'shopController@post');
Route::put('/shop', 'shopController@update');
Route::delete('/shop/{id}', 'shopController@delete');

//Custom category controllers
Route::get('/category','categoryController@list');
Route::get('/category/{id}','categoryController@get');
Route::post('/category','categoryController@post');
Route::put('/category','categoryController@update');
Route::delete('/category/{title}','categoryController@remove');

//find discounts
Route::post('/user/findDiscounts', 'findDiscountsController@list');


// Requested Discount Routes
Route::get('/requestedDiscount', 'requestedDiscountController@list');
Route::get('/requestedDiscount/{id}', 'requestedDiscountController@get');
Route::post('/requestedDiscount', 'requestedDiscountController@post');
Route::put('/requestedDiscount/{id}', 'requestedDiscountController@put');
Route::delete('/requestedDiscount/{id}', 'requestedDiscountController@delete');

//Discount Controller Routes
Route::get('/discount','discountController@list');
Route::get('/discount/{id}','discountController@get');
Route::post('/discount','discountController@post');
Route::put('/discount/{id}','discountController@put');
Route::delete('discount/{id}','discountController@delete');