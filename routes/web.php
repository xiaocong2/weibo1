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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/', 'StaticPagesController@home')->name('home');//主页
//Route::get('/help', 'StaticPagesController@help')->name('help');//帮助
//Route::get('/about', 'StaticPagesController@about')->name('about');//关于

Route::get('/','StaticPagesController@home')->name('home');//首页
Route::get('/help','StaticPagesController@help')->name('help');//帮助
Route::get('/about','StaticPagesController@about')->name('about');//关于

Route::get('signup', 'UsersController@create')->name('signup');//注册页面
Route::resource('users','UsersController');//用户操作（增删改查）

Route::get('login', 'SessionsController@create')->name('login');//显示登录页
Route::post('login', 'SessionsController@store')->name('login');//用户登录操作
Route::delete('logout', 'SessionsController@destroy')->name('logout');//退出登录