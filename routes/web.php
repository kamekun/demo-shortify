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

// URL Web Endpoints
Route::get('/top', 'Shortify\Urls@top');
Route::get('{shortify}',[ 'Shortify\urls@transfer', 'as' => 'transfer'] )->where('shortify', '[A-Za-z]+');
