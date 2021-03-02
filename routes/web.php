<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\DegreeController;


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

//Add Degree page routes
/*Route::get('/create', function () {  return view('degree.createDegree'); });
Route::get('/allDegrees', function () {  return view('degree.indexDegree'); });
Route::get('/edit/{id}', function () {  return view('degree.editDegree'); })->name('edit');
*/

// Home page routes 
Route::get('/home', function () {    return view('home'); });
Route::get('/homeLogin', function () {  return view('homeLogin'); });

//Add Degree page
Route::get('/apiDegree', function () {    return view('apiDegree'); });

Route::get('/degrees', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
