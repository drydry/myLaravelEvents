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

Route::get('/home', function () {
    return view('events.index');
});

Route::get('/', 'Auth\AuthController@getLogin');

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

	Route::get('/events', function () {
	    return view('events.index');
	});

	Route::get('/eventsTypes', function () {
	    return view('event-types.index');
	});

	// Bookings
	Route::get('/events/{id}/bookings', function () {
		return view('bookings.index');
	});

	// Events
	Route::get('events/create/{id?}', 'EventsController@create'); 
	Route::get('events/show/{id}', 'EventsController@show');
	Route::get('events/edit/{id}', 'EventsController@edit');
	// Event types
	Route::get('eventsTypes/create', 'EventTypesController@create');
	Route::get('eventsTypes/show/{id}', 'EventTypesController@show');
	Route::get('eventsTypes/edit/{id}', 'EventTypesController@edit');
	
	
	// Specific routes for posting
	Route::group(array('prefix' => 'api'), function(){
		// Events
		Route::get('events', 'EventsController@index');
		Route::post('events/store', 'EventsController@store');
		Route::post('events/update/{id}', 'EventsController@update');
		Route::post('events/delete/{id}', 'EventsController@destroy');
		// Booking
		Route::get('events/{id}/bookings', 'BookingsController@index');
		Route::post('events/book/{id}', 'BookingsController@store');
		Route::post('events/unbook/{id}', 'BookingsController@destroy');
		Route::post('bookings/kick/{id}', 'BookingsController@kick');
		// Event types
		Route::get('eventTypes', 'EventTypesController@index');
		Route::post('eventTypes/store', 'EventTypesController@store');
		Route::post('eventTypes/delete/{id}', 'EventTypesController@destroy');
		Route::post('eventTypes/update/{id}', 'EventTypesController@update');
	});
});