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

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

//se auto to group vazoume opoio endpoint theloume na einai authedicate me to token tou xrhsth
//an dn dwsei to token sto header  tou vgazei mnm Unauthenticated
// enalaktika ginetai kai opws poio pano sto enpoint   /user
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('get-details', 'API\PassportController@getDetails');


});