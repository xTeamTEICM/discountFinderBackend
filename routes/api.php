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

// Auth
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('refresh', 'Auth\LoginController@refresh');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});

// Category
Route::get('category', 'CategoryController@list');
Route::get('category/{id}', 'CategoryController@get');
Route::post('category', 'CategoryController@post');
Route::put('category/{id}', 'CategoryController@update');
Route::delete('category/{id}', 'CategoryController@remove');

// Shop
Route::get('shop', 'ShopController@list');
Route::get('shop/{id}', 'ShopController@get');
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user/shop', 'ShopController@myList');
    Route::get('user/shop/{id}', 'ShopController@myGet');
    Route::get('user/shop/{id}/discounts', 'ShopController@myDiscounts');
    Route::post('shop', 'ShopController@post');
    Route::put('shop/{id}', 'ShopController@update');
    Route::delete('shop/{id}', 'ShopController@delete');
});

// Discount
Route::get('discount', 'DiscountController@list');
Route::get('discount/{id}', 'DiscountController@get');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('discount', 'DiscountController@post');
    Route::put('discount/{id}', 'DiscountController@put');
    Route::delete('discount/{id}', 'DiscountController@delete');
});

// Requested Discounts
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('requestedDiscount', 'RequestedDiscountController@list');
    Route::get('requestedDiscount/{id}', 'RequestedDiscountController@get');
    Route::post('requestedDiscount', 'RequestedDiscountController@post');
    Route::put('requestedDiscount/{id}', 'RequestedDiscountController@put');
    Route::delete('requestedDiscount/{id}', 'RequestedDiscountController@delete');
});

// Find Discounts
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('discount/find/{distance}', 'FindDiscountsController@list');
    Route::get('discount/top/{distance}', 'FindDiscountsController@TopList');
});

// FCM DeviceToken
Route::group(['middleware' => 'auth:api'], function () {
    Route::put('/user/deviceToken', 'DeviceTokenController@setDeviceToken');
});

// Location
Route::group(['middleware' => 'auth:api'], function () {
    Route::put('/user/deviceLocation', 'UpdateUserLocationController@update');
    Route::get('/user/deviceLocation', 'UpdateUserLocationController@get');
});
