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
Route::get('add','TaskController@create');

Route::post('add','TaskController@store');

Route::get('task','TaskController@index');

Route::get('edit/{id}','TaskController@edit');

Route::post('edit/{id}','TaskController@update');

Route::delete('{id}','TaskController@destroy');

Route::get('seed', 'TaskController@seed'); //Seeder