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
    'uses' => 'SensorsController@index']);

Route::get('/sensors/add', 
        ['as' => 'sensors.add',
    'uses' => 'SensorsController@add']);
Route::post('/sensors/add', 
        ['as' => 'sensors.add',
    'uses' => 'SensorsController@add']);

Route::get('/sensors/{id}', 
        ['as' => 'sensors.show',
    'uses' => 'SensorsController@show']);

Route::get('/taps', 
        ['as' => 'taps.index',
    'uses' => 'TapsController@index']);

Route::get('/taps/add', 
        ['as' => 'taps.add',
    'uses' => 'TapsController@add']);

Route::post('/taps/add', 
        ['as' => 'taps.add',
    'uses' => 'TapsController@add']);

Route::get('/taps/{id}', 
        ['as' => 'taps.show',
    'uses' => 'TapsController@show']);

