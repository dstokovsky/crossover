<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'ReportController@index');

Route::auth();

Route::get('/reports', 'ReportController@index');

Route::get('/reports/{report}', 'ReportController@view');

Route::post('/reports', 'ReportController@store');

Route::delete('/reports/{report}', 'ReportController@destroy');

Route::get('/users', 'UserController@index');

Route::get('/users/{user}', 'UserController@view');

Route::post('/users', 'UserController@store');

Route::delete('/users/{user}', 'UserController@destroy');
