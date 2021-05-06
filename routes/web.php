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

// Saved session
Route::get('/sessions', function () {
    return view('loadSession');
});

//Any routes you want to lock behind a login put into this routing group
Route::middleware('auth')->group(function () {
    Route::get('/student/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::get('/admin/dashboard/import', [App\Http\Controllers\AdminController::class, 'displayImport']);
});

// Home Page:
Route::get('/', function () {
    return view('homePage');
});

Route::get('/home', function () {
    return view('homeLogin');
});

Route::get('/degrees/{ids}', function ($ids) {
    return view('degreeIDs', ['ids' => $ids]);
});
//Add Degree page routes

// Home page routes
//Route::get('/home', function () {    return view('home'); });
//Route::get('/homeLogin', function () {  return view('homeLogin'); });

//Add Degree page
Route::get('/apiDegree', function () {
    return view('apiDegree');
});


Auth::routes();
//Route::resource('users', App\Http\Controllers\UserController::class);
Route::get('/getCurrentUser', function () {
    return Auth::user()->load('roles');
});

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/degrees', function () {
    return view('degrees');
});
Route::get('/survey', function () {
    return view('survey');
});

Route::get('/degree/{id}', function ($id) {
    return view('degreeDetails', ['id' => $id]);
});

Route::get('/degreeSearch/{keywords}', function ($keywords) {
    return view('degreeSearch', ['keywords' => $keywords]);
});

