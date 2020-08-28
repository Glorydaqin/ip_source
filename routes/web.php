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
//admin
Route::any("admin/login","Admin\LoginController@login");
Route::get("admin/logout","Admin\LoginController@logout");
Route::get("admin/reset","Admin\LoginController@resetPassword");

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'auth.admin'],function () {

    Route::get("index", function () {
        return view("admin/index");
    });
    Route::get("home", "HomeController@index");
    Route::any("competitor/insert", "CompetitorController@insert");
    Route::any("competitor/store", "CompetitorController@store");
    Route::any("competitor/update", "CompetitorController@update");
    Route::any("catch_source/insert", "CatchSourceController@insert");
    Route::any("catch_source/store", "CatchSourceController@store");
    Route::any("catch_source/update", "CatchSourceController@update");
});


//api
Route::get('/get_ip/{competitor}', "ApiController@getIp")->where(['competitor'=>'\d+']);
Route::get('/set_ip/{competitor}/{ip}/{status}', "ApiController@setIp")->where(['competitor'=>'\d+','ip'=>'[\d\.\:]+']);
Route::get('/get_panel', "ApiController@getPanel");
