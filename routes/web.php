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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'TaskController@index');

Route::post('/create','TaskController@store');
Route::post('/edit','TaskController@update');
Route::post('/done','TaskController@done');
Route::post('/undo','TaskController@undo');
Route::post('/delete', 'TaskController@delete');
