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


Route::post('register', 'API\RegisterController@register');
Route::post('login', 'API\LoginController@login');
Route::post('refresh', 'API\LoginController@refresh');



Route::group(['middleware' => 'auth:api'], function(){

    Route::post('logout', 'API\LoginController@logout');

});