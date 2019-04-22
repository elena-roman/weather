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

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Route::group(['namespace' => 'Auth'], function () {
    Route::resource('/login', 'LoginController')
        ->only(['index', 'store']);

    Route::get('/logout', 'LoginController@destroy');
});

Route::group(['namespace' => 'Dashboard'], function () {
    Route::resource('/location', 'LocationController')
        ->only(['create', 'store', 'destroy'])->middleware('auth');
});