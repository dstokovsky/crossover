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

Route::get('/', function(){
    return Auth::guest() ? redirect('login') : redirect('/reports');
});

Route::get('/home', function(){
    return redirect('/');
});

Route::auth();

Route::get('/reports', [
    'uses'        => 'ReportController@index',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator|patient',
    'can'          => 'view.report',
]);

Route::get('/reports/{report}/view', [
    'uses'        => 'ReportController@view',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator|patient',
    'can'          => 'view.report',
]);

Route::get('/reports/{report}/edit', [
    'uses'        => 'ReportController@edit',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
    'can'          => 'update.report',
]);

Route::get('/reports/{report}/pdf', [
    'uses'        => 'ReportController@toPdf',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator|patient',
    'can'          => 'export.pdf.report',
]);

Route::get('/reports/{report}/mail', [
    'uses'        => 'ReportController@toMail',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator|patient',
    'can'          => 'export.mail.report',
]);

Route::post('/reports/{report?}', [
    'uses'        => 'ReportController@store',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
    'can'          => 'create.report',
]);

Route::get('/reports/{report}/delete', [
    'uses'        => 'ReportController@destroy',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
    'can'          => 'delete.report',
]);

Route::get('/reports/{user}/send', [
    'uses'        => 'PatientController@send',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/operators', [
    'uses'        => 'OperatorController@index',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/operators/{user}/view', [
    'uses'        => 'OperatorController@view',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/operators/{user}/edit', [
    'uses'        => 'OperatorController@edit',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::post('/operators/{user?}', [
    'uses'        => 'OperatorController@store',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/operators/{user}/delete', [
    'uses'        => 'OperatorController@destroy',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/patients', [
    'uses'        => 'PatientController@index',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/patients/{user}/view', [
    'uses'        => 'PatientController@view',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/patients/{user}/edit', [
    'uses'        => 'PatientController@edit',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::post('/patients/{user?}', [
    'uses'        => 'PatientController@store',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/patients/{user}/delete', [
    'uses'        => 'PatientController@destroy',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/patients/{user}/send', [
    'uses'        => 'PatientController@send',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);

Route::get('/patients/autocomplete', [
    'uses'        => 'PatientController@autocomplete',
    'middleware'   => ['auth', 'acl'],
    'is'           => 'operator',
]);
