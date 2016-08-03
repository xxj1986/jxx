<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
// 认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 注册路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['middleware' => 'auth','namespace'=>'Home','prefix'=>'home'], function () {
    Route::get('/', 'HomeController@index');
});

Route::group(['middleware' => 'auth','namespace'=>'Admin','prefix'=>'admin'], function () {
    Route::get('dashboard','DashboardController@index');
    //用户管理
    Route::resource('users','UsersController');
    //会员卡管理
    Route::get('members/records','MembersController@showRecords');
    Route::get('members/checkMember/{mobile}','MembersController@checkMember');
    Route::resource('members','MembersController');
    //角色管理
    Route::resource('roles','RolesController');
    //项目管理
    Route::resource('projects','ProjectsController');
    //流水管理
    Route::get('statements/daily','StatementsController@daily');
    Route::resource('statements','StatementsController');

});