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

Route::get('/', function () {
    return view('auth.login');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Authenticated routes...
Route::group(['middleware' => 'auth'], function () {

	Route::get('/', function () {
	    return view('events.index');
	});

	// Events routes...
	Route::get('events/create', 'EventsController@create');
	Route::get('events/show/{id}', 'EventsController@show');
	Route::get('events/edit/{id}', 'EventsController@edit');
	
	// Specific routes for posting
	Route::group(array('prefix' => 'api'), function(){
		// Events
		Route::get('events', 'EventsController@index');
		Route::post('events/store', 'EventsController@store');
		Route::post('events/update/{id}', 'EventsController@update');
		Route::post('events/delete/{id}', 'EventsController@destroy');
		// Booking
		Route::post('events/book/{id}', 'BookingsController@store');
	});
});