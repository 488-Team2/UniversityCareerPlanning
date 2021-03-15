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

Route::get('/degrees', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/adminlogin', function () {
    return view('adminlogin');
});
Route::get('/register', function () {
    return view('register');
});
<<<<<<< Updated upstream

=======
Route::get('/degrees', function () {
    return view('degrees');
});
Route::get('/degree/{id}', function () {
    return view('degreeDetails');
});
Route::get('/uniadmindash', function () {
    return view('uniadmindash');
});
Route::get('/depadmindash', function () {
    return view('depadmindash');
});
>>>>>>> Stashed changes
