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
	Route::get('{provider}/redirect', 'Auth\AuthController@redirectToProvider');
	Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');
});

// authenticate required
Route::group(['middleware' => 'auth'], function()
{
	Route::get('/', 'HomeController@index');

	Route::get('auth/logout', 'Auth\AuthController@logout');

	//create user
	Route::get('newuser','User\UserController@getNewUser');

	Route::post('newuser','User\UserController@postNewUser');

	//check email and username

	Route::group(array('prefix'=>'check'),function(){
		Route::post('check-username','User\UserController@check_username');
		Route::post('check-email','User\UserController@check_email');
	});

	//load all users
	Route::get('all-user','User\UserController@getAllUser');

	Route::post('updateuser','User\UserController@postUpdateUser');
	Route::post('deleteuser','User\UserController@postDeleteUser');


	//thông tin người dùng
	Route::get('profile-user/{id}',array(
		'as' => 'profileuser','uses' =>'User\UserController@getProfileUser'
	));
	Route::post('profile-user','User\UserController@postProfileUser');

});

Route::get('/register', function() {

	$user = new App\User();
	$user->name = "Bean Nguyen";
	$user->email = "beanchanel@gmail.com";
	$user->password = Hash::make('admin');
	$user->username = "beannguyen";
	$user->group_id = 1;
	$user->active = 1;
	$user->save();

	return $user->all();

});

