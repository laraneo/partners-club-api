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

Route::prefix('api')->group(function () {
    Route::post('/login', 'PassportController@login');
    Route::post('/register', 'PassportController@register');
    Route::middleware('auth:api')->group(function () {
        Route::get('/product', 'ProductController@index');
        Route::get('/product/{id}', 'ProductController@show');
        Route::put('/product/{id}', 'ProductController@update');
        Route::delete('/product/{id}', 'ProductController@destroy');
        Route::post('/product', 'ProductController@store');
        });
});
