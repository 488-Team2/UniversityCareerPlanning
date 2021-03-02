<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// list of all degrees
Route::get('degrees', 'App\Http\Controllers\DegreeController@index');

// search degrees
Route::get('search/{keyword}', 'App\Http\Controllers\DegreeController@search');

// show detailed degree
Route::get('degree/{id}', 'App\Http\Controllers\DegreeController@show');
/*
// create new degree
Route::post('degree', 'App\Http\Controllers\DegreeController@store');

// update degree
Route::put('degree', 'App\Http\Controllers\DegreeController@store');

// delete degree
Route::delete('degree', 'App\Http\Controllers\DegreeController@destroy');
*/

Route::post('degree/create', 'App\Http\Controllers\DegreeController@store');
Route::get('degree/edit/{id}', 'App\Http\Controllers\DegreeController@edit');
Route::put('degree/update/{id}', 'App\Http\Controllers\DegreeController@update');
Route::delete('degree/delete/{id}', 'App\Http\Controllers\DegreeController@destroy');
Route::get('degreeDisplay', 'App\Http\Controllers\DegreeController@display');


