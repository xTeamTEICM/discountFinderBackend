<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| AuthApi Routes
|--------------------------------------------------------------------------
|
| Here is where you can register AuthApi routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your AuthApi!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/helloWorld', 'helloWorldController@getHelloWorld');


Route::post('register', 'AuthApi\RegisterController@register');
Route::post('login', 'AuthApi\LoginController@login');
Route::post('refresh', 'AuthApi\LoginController@refresh');



Route::group(['middleware' => 'auth:api'], function(){

    Route::post('logout', 'AuthApi\LoginController@logout');

});