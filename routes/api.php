<?php

use App\Http\Controllers\CareerSurveyQuestionController;
use App\Http\Controllers\CareerSurveyResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::post('submit', 'App\Http\Controllers\ContactFormController@submit');
Route::get('contacts', 'App\Http\Controllers\ContactFormController@index');

Route::get('/getCurrentUser', function () {
    return Auth::user()->load('roles');
});

//Route::resource('users', App\Http\Controllers\UserController::class);
Route::get('users', 'App\Http\Controllers\UserController@index');
Route::post('user/create', 'App\Http\Controllers\UserController@store');


// list of all degrees
Route::get('degrees', 'App\Http\Controllers\DegreeController@index');

// set of degrees from ID
Route::get('degrees/{ids}', 'App\Http\Controllers\DegreeController@set');
// set of degrees from Holland codes
Route::get('degrees/codes/{codes}', 'App\Http\Controllers\DegreeController@hollandCodeDegrees');

// Set of degree table columns
Route::get('/degreetags', 'App\Http\Controllers\DegreeController@getDegreeColumnNames');
// Handles post from /api/degreetags, Saving API import information in database
Route::post('/degreetags', 'App\Http\Controllers\DegreeApiImportInfoController@store');
// Returns collection of DegreeApiImportInfo data to be used to import degree data from an external resource
Route::get('/degreeimportdata', 'App\Http\Controllers\DegreeApiImportInfoController@index');
Route::post('degrees/import', 'App\Http\Controllers\DegreeApiImportInfoController@runImport');

// Deletes a specified data label from the database
Route::delete('/degreeimportdata', 'App\Http\Controllers\DegreeApiImportInfoController@delete');

// search degrees
Route::get('search/{keyword}', 'App\Http\Controllers\DegreeController@search');

// show detailed degree
Route::get('degree/{id}', 'App\Http\Controllers\DegreeController@show');

Route::delete('degree/{id}', 'App\Http\Controllers\DegreeController@destroy');

// list the states
Route::get('states', 'App\Http\Controllers\StateController@index');

// return state_code
Route::get('state/{stateName}', 'App\Http\Controllers\StateController@show');

// list the jobs
Route::get('jobs', 'App\Http\Controllers\jobController@index');

// return job_code
Route::get('job/{jobName}', 'App\Http\Controllers\JobController@show');

// return StateJob
Route::get('StateJob/{stateName}_{jobName}', 'App\Http\Controllers\AllStateJobController@show');

// create new state job
Route::post('StateJob/create', 'App\Http\Controllers\AllStateJobController@store');

Route::post('degree/create', 'App\Http\Controllers\DegreeController@store');
Route::get('degree/edit/{id}', 'App\Http\Controllers\DegreeController@edit');
Route::put('degree/update/{id}', 'App\Http\Controllers\DegreeController@update');
Route::delete('degree/delete/{id}', 'App\Http\Controllers\DegreeController@destroy');
Route::get('degreeDisplay', 'App\Http\Controllers\DegreeController@display');



//Get collection of survey questions
Route::get('/survey/questions', [CareerSurveyQuestionController::class, 'index']);

//Submit question responses to
Route::post('/survey', [CareerSurveyResponseController::class, 'store']);

//Get specific survey question
Route::get('/survey/question/{id}', [CareerSurveyQuestionController::class, 'show']);
