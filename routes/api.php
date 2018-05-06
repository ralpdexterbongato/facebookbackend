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

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('/user/{id}', 'AuthController@getProfileData');
    Route::post('me', 'AuthController@me');
    Route::post('register','AuthController@Register');
    Route::get('/send/{id}','EmailController@sendVerificationCode');
    Route::get('/verification','VerificationController@verifyme');
    Route::resource('/post','PostController');
    Route::get('/profile/{id}','PostController@profilePost');
    Route::get('/profile-new/{id}','PostController@getMyNewlySubmitted');
    Route::post('/addfriend','UserFriendsController@storeRequest');
    Route::post('/acceptfriend','UserFriendsController@acceptRequest');
});
