<?php
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
Route::group(['prefix' => 'v1'], function() {
       Route::group(['prefix' => 'account'], function() {
                Route::middleware('guest:api')->post('/register', 'API\AccountController@createAccount');
                Route::middleware('guest:api')->post('/login', 'API\AccountController@loginAccount');
                Route::middleware('auth:api')->post('/logout', 'API\AccountController@logoutAccount');
                Route::middleware('guest:api')->post('/refresh', 'API\AccountController@refreshAccount');
       });
       Route::group(['prefix' => 'profile'], function() {
                Route::middleware('auth:api')->get('/retrieve', 'API\ProfileController@retrieveAccount');
       });
       Route::group(['prefix' => 'property'], function() {
                Route::middleware('auth:api')->post('/new', 'API\PropertyController@createProperty');
                Route::middleware('auth:api')->get('/retrieve', 'API\PropertyController@retrieveProperty');
       });
       /*Route::group(['prefix' => 'room'], function() {
                Route::middlware('auth:api')->post('/new', 'API\RoomController@newRoom');
                Route::middlware('auth:api')->get('/retrieve', 'API\RoomController@retrieveRoom');
       });*/
});
