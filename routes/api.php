<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// URL API Endpoints
Route::name('api')->group(function () {
    Route::get('top', 'Shortify\Urls@top')->name('top');
    Route::post('/urls', ['uses' => 'Shortify\Urls@store', 'as' => '.store']);
    Route::get('urls/{code}', ['uses' => 'Shortify\Urls@show', 'as' => '.show']);
    Route::delete('urls/{code}', ['uses' => 'Shortify\Urls@delete', 'as' => '.delete']);
});