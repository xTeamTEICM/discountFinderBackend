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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/helloWorld', 'helloWorldController@getHelloWorld');

Route::get('/shop','shopController@list');
Route::get('/shop/{id}', 'shopController@get');
Route::post('/shop','shopController@post');
Route::put('/shop','shopController@update');
Route::delete('/shop/{id}', 'shopController@delete');