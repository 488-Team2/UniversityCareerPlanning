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

// list degrees
Route::get('degrees', 'App\Http\Controllers\DegreeController@index');

// show detailed degree
Route::get('degree/{id}', 'DegreeController@show');

// create new degree
Route::post('degree', 'DegreeController@store');

// update degree
Route::put('degree', 'DegreeController@store');

// delete degree
Route::delete('degree', 'DegreeController@destroy');