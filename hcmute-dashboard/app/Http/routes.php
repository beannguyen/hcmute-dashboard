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

Route::group(['middleware' => 'guest'], function() {

	Route::group(['prefix' => 'auth'], function() {
		Route::get('login', 'Auth\AuthController@login');
	});
	Route::post('/auth/login', array('before' => 'csrf_json', 'uses' => 'Auth\AuthController@loginAttempt'));

	// forgot password
	Route::post('auth/forgotpwd', 'Auth\PasswordController@postRemind');
	Route::get('/password/reset/{token}', 'Auth\PasswordController@getReset');
	Route::post('/password/reset', 'Auth\PasswordController@postReset');

	// oauth service provider
	Route::get('oauth/redirect', 'Auth\AuthController@redirectToProvider');
	Route::get('oauth/callback', 'Auth\AuthController@handleProviderCallback');
});

// authenticate required
Route::group(['middleware' => 'auth'], function()
{
	Route::get('/', 'WelcomeController@index');

	Route::get('auth/logout', 'Auth\AuthController@logout');
});

Route::get('/register', function() {

	$user = DB::table('users')->where('email', 'vmod.game@gmail.com')->first();

	return $user->id;
});

