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

Route::get('/', ['as'=>'home', 'middleware'=>'auth', 'uses'=>'HomeController@index']);
Route::get('/home', ['as'=>'home.info', 'middleware'=>'auth', 'uses'=>'HomeController@info']);

// 用户信息
Route::group(['namespace' => 'Auth'], function() {
    Route::get('/login', ['as'=>'login', 'uses'=>'LoginController@index']);
    Route::post('/login', ['uses'=>'LoginController@login']);
    Route::get('/logout', ['as'=>'logout', 'uses'=>'LoginController@logout']);
    // Route::post('/user', 'UserController@index');
});

// 常规页
Route::group(['prefix'=>'general', 'middleware'=>'auth', 'namespace' => 'General'], function() {
    Route::get('/info', ['as'=>'info', 'uses'=>'InfoController@index']);
    Route::post('/info/update', ['as'=>'info.update', 'uses'=>'InfoController@update']);
    Route::post('/info/passwd', ['as'=>'info.passwd', 'uses'=>'InfoController@passwd']);

    Route::get('/car', ['as'=>'car', 'uses'=>'CarController@index']);
    Route::post('/car/add', ['as'=>'car.add', 'uses'=>'CarController@add']);
    Route::post('/car/update', ['as'=>'car.update', 'uses'=>'CarController@update']);

    Route::get('/driver', ['as'=>'driver', 'uses'=>'DriverController@index']);
    Route::post('/driver/add', ['as'=>'driver.add', 'uses'=>'DriverController@add']);
    Route::post('/driver/update', ['as'=>'driver.update', 'uses'=>'DriverController@update']);
});

// 系统设置页
Route::group(['prefix'=>'setting', 'middleware'=>'auth', 'namespace' => 'Setting'], function() {
    Route::get('/role', ['as'=>'role', 'uses'=>'RoleController@index']);
    Route::post('/role/add', ['as'=>'role.add', 'uses'=>'RoleController@add']);
    Route::post('/role/update', ['as'=>'role.update', 'uses'=>'RoleController@update']);

    Route::get('/user', ['as'=>'user', 'uses'=>'UserController@index']);
    Route::post('/user/add', ['as'=>'user.add', 'uses'=>'UserController@add']);
    Route::post('/user/update', ['as'=>'user.update', 'uses'=>'UserController@update']);

    Route::get('/menu', 'MenuController@index');
});