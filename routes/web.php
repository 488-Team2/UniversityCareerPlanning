<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



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

// Auth: 
Route::get('/', function () {
    return view('browse');
 })->middleware('auth');

Route::get('student/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Auth::routes();
Route::resource('users', App\Http\Controllers\UserController::class);

Route::get('/getCurrentUser', function() {
  return Auth::user()->load('roles');
});
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout' )->name('logout');

// Home Page:
Route::get('/home', function() {
  return view('homePage');
});

Route::get('/contact', function () {
  return view('contact');
});