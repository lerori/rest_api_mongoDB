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
Route::get('/task/{id}', 'TaskController@all'); //Queries with filters

Route::post('save', 'TaskController@saveTask'); //New task

Route::get('show/{task}', 'taskController@showTask'); //task by id
 
Route::put('update/{task}','taskController@updateTask'); //update task
 
Route::delete('delete/{task}', 'taskController@deleteTask'); //delete task