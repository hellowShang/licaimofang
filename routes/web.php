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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// get方法
Route::get('/test1', 'Controller\TestController@testGet');

// post方法
Route::post('/test2', 'Controller\TestController@testPost');

// 发送邮件
Route::get('/send', 'Controller\TestController@SendEmail');

Route::get('/test3', 'Controller\TestController@test3');
Route::get('/home', 'HomeController@index')->name('home');
