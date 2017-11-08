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


//Route::get('/helloWorld', 'helloWorldController@getHelloWorld');
//Custom category controllers
Route::get('/category','categoryController@list');
Route::get('/category/{id}','categoryController@get');
Route::post('/category','categoryController@post');
Route::put('/category','categoryController@update');
Route::delete('/category/{id}','categoryController@remove');