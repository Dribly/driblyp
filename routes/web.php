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
        'uses' => 'UsersController@dashboard'])->middleware('auth');

Route::get('/profile',
    ['as' => 'users.profile',
        'uses' => 'UsersController@profile'])->middleware('auth');

Route::post('/profile',
    ['as' => 'user.update',
        'uses' => 'UsersController@profile'])->middleware('auth');

Route::get('/gardens',
    ['as' => 'gardens.index',
        'uses' => 'GardensController@index'])->middleware('auth');
Route::get('/gardens/add',
    ['as' => 'gardens.add',
        'uses' => 'GardensController@add'])->middleware('auth');
Route::post('/gardens/add',
    ['as' => 'gardens.add.post',
        'uses' => 'GardensController@add'])->middleware('auth');
Route::get('/gardens/{id}',
    ['as' => 'gardens.show',
        'uses' => 'GardensController@show'])->middleware('auth');

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
Route::post('/sensors/{id}/changestatus', 
        ['as' => 'sensors.changestatus',
    'uses' => 'SensorsController@changestatus'])->middleware('auth');
Route::post('/sensors/{id}/sendFakeValue', 
        ['as' => 'sensors.sendFakeValue',
    'uses' => 'SensorsController@sendFakeValue'])->middleware('auth');
Route::post('/sensors/{id}/connectToTap',
    ['as' => 'sensors.connectToTap',
        'uses' => 'SensorsController@connectToTap'])->middleware('auth');
Route::post('/sensors/{id}/detach',
    ['as' => 'sensors.detach',
        'uses' => 'SensorsController@detachFromTap'])->middleware('auth');

Route::get('/taps', 
        ['as' => 'taps.index',
    'uses' => 'TapsController@index'])->middleware('auth');
Route::get('/taps/add', 
        ['as' => 'taps.add',
    'uses' => 'TapsController@add'])->middleware('auth');
Route::post('/taps/add', 
        ['as' => 'taps.add',
    'uses' => 'TapsController@add'])->middleware('auth');
Route::post('/taps/{id}/changestatus',
    ['as' => 'taps.changestatus',
        'uses' => 'TapsController@changestatus'])->middleware('auth');
Route::post('/taps/{id}/sendFakeValue',
    ['as' => 'taps.sendFakeResponse',
        'uses' => 'TapsController@sendFakeResponse'])->middleware('auth');
Route::post('/taps/{id}/turntap',
    ['as' => 'taps.turntap',
        'uses' => 'TapsController@manualTurnOnOrOff'])->middleware('auth');
Route::get('/taps/{id}',
        ['as' => 'taps.show',
    'uses' => 'TapsController@show'])->middleware('auth');
Route::post('/taps/{id}/connectToSensor', 
        ['as' => 'taps.connectToSensor',
    'uses' => 'TapsController@connectToSensor'])->middleware('auth');
Route::post('/taps/{id}/detach',
    ['as' => 'taps.detach',
        'uses' => 'TapsController@detachFromSensor'])->middleware('auth');

Route::get('/json/taps/{id}/timeslots', ['as'=>'jsapi.taps.timeslots', 'uses'=>'TapsController@jsonGetTimeSlots'])->middleware('auth');
Route::post('/taps/{id}/storeTimeSlots',
    ['as' => 'taps.storeTimeSlots',
        'uses' => 'TapsController@storeTimeSlots']);//->middleware('auth');
Route::get('/v1/taps/{id}/timeslots', ['as'=>'taps.timeslots', 'uses'=>'TapsController@getTimeslots'])->middleware('auth');


