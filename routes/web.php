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

//API
Route::get('user', 'Api\UserController@user');
Route::post('index', 'Api\UserController@index');
Route::post('indexadd', 'Api\UserController@indexadd');
//中间件
//Route::get('reg', 'Api\IndexController@reg')->Middleware('request');
Route::get('log', 'Login\LoginController@log');//用户登录展示
Route::post('log_cookie', 'Login\LoginController@log_cookie');  //用户登录
Route::post('login', 'Api\RegController@login');  //用户登录
Route::post('reg', 'Api\RegController@reg');  //用户注册
Route::get('my', 'Api\RegController@my')->Middleware(['checktoken' , 'request']);  //用户中心

//资源路由
Route::resource('goods',\Goods\GoodsController::class);


Route::get('Oss', 'Oss\OssController@Oss');  //OSS测试上传文件
Route::get('Oss2', 'Oss\OssController@Oss2');  //OSS测试上传图片
Route::get('Oss_video', 'Video\VideoController@Oss_video');  //本地视频转移到OSS
