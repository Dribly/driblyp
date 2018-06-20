<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', 
        ['as' => 'users.dashboard',
    'uses' => 'UsersController@dashboard']);

Route::get('/sensors', 
        ['as' => 'sensors.index',
    'uses' => 'SensorsController@index'])->middleware('auth');
Route::get('/sensors/add', 
        ['as' => 'sensors.add',
    'uses' => 'SensorsController@add'])->middleware('auth');
Route::post('/sensors/add', 
        ['as' => 'sensors.add',
    'uses' => 'SensorsController@add'])->middleware('auth');
Route::get('/sensors/{id}', 
        ['as' => 'sensors.show',
    'uses' => 'SensorsController@show'])->middleware('auth');

Route::get('/taps', 
        ['as' => 'taps.index',
    'uses' => 'TapsController@index']);
Route::get('/taps/add', 
        ['as' => 'taps.add',
    'uses' => 'TapsController@add']);
Route::post('/taps/add', 
        ['as' => 'taps.add',
    'uses' => 'TapsController@add']);
Route::post('/taps/{id}/changestatus', 
        ['as' => 'taps.changestatus',
    'uses' => 'TapsController@changestatus']);
Route::get('/taps/{id}', 
        ['as' => 'taps.show',
    'uses' => 'TapsController@show']);



Route::get('/mqttsubscriber', 
        ['as' => 'mqtt.monitor',
    'uses' => 'MQTTController@monitor']);

Route::get('/mqttsendmessage', 
        ['as' => 'mqtt.sendmessage',
    'uses' => 'MQTTController@sendmessage']);

Route::get('/mqttiframe', 
        ['as' => 'mqtt.mqttiframe',
    'uses' => 'MQTTController@iframe']);

