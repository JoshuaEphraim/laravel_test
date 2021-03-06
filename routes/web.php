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

Route::get('/', 'FileController@show');
Route::post('/url','FileController@getFile');
Route::post('/delete','FileController@deleteFile');
Route::get('/storage/app/public/{name}','FileController@pushFile');
