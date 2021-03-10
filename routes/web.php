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
Route::get('/home', function () {
    return view('home');
});
Route::get('/homeLogin', function () {
    return view('homeLogin');
});
Route::get('/contact', function () {
    return view('contact');
});

Route::get('/degrees/{ids}', function () {
    return view('degrees');
});
//Add Degree page routes

// Home page routes 
Route::get('/home', function () {    return view('home'); });
Route::get('/homeLogin', function () {  return view('homeLogin'); });

//Add Degree page
Route::get('/apiDegree', function () {    return view('apiDegree'); });

Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/degrees', function () {
    return view('degrees');
});
Route::get('/degree/{id}', function () {
    return view('degreeDetails');
});
