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

Route::get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => 'api/v1'], function () {
    Route::get('/sensor-update/{id}',
        ['as' => 'sensors.dataupdate',
            'uses' => 'SensorsController@ApiUpdate'])->middleware('auth:api');
});
Route::get('/v1/login', 'Api\\UserController@login');
Route::get('/v1/me', 'Api\\UserController@details')->middleware('auth:api');;
//Route::get('/v1/taps/{id}/timeslots', ['as'=>'api.taps.timeslots', 'uses'=>'TapsController@apiGetTimeslots'])->middleware('auth:api');
//Route::get('/v1/taps/{id}/timeslots-js', ['as'=>'jsapi.taps.timeslots', 'uses'=>'TapsController@getTimeslots'])->middleware('auth');
//Route::get('/v1/taps', 'TapsController@apiIndex')->middleware('auth:api');
Route::post('taps', 'TapsController@store');
Route::get('taps/{id}', 'TapsController@show');
Route::put('taps/{project}', 'TapsController@markAsCompleted');
