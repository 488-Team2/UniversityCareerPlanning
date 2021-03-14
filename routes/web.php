<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/degrees/{ids}', function ($ids) {
    return view('degreeIDs', ['ids'=>$ids]);
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});

Route::get('/degrees', function () {
    return view('degrees');
});

Route::get('/degree/{id}', function ($id) {
    return view('degreeDetails', ['id'=>$id]);
});

Route::get('/degreeSearch/{keywords}', function ($keywords) {
    return view('degreeSearch', ['keywords'=>$keywords]);
});
