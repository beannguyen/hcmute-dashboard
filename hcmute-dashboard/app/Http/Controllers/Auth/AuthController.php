<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
		$this->message = null;
		$this->error = null;

		// get message from reset password
		if ( Session::has('message') ) {

			$this->message = Session::get('message');
			Session::forget('message');
		}

		// get message from reset password
		if ( Session::has('error') ) {

			$this->error = Session::get('error');
			Session::forget('error');
		}
	}

	public function login()
	{
		$data['page_title'] = "Đăng nhập vào hệ thống";

		if( !is_null($this->message) )
			$data['message'] = $this->message;
		if( !is_null($this->error) )
			$data['error'] = $this->error;

		return view('auth.login')->with('data', $data);
	}

	public function loginAttempt()
	{
		$remember = Input::get('remember');

		if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password'), 'active' => 1], $remember))
		{
			return redirect()->intended('/');
		} else {
			return redirect()->intended('/auth/login')->with('error', 'Tên truy cập hoặc mật khẩu không đúng');
		}
	}

	public function redirectToProvider()
	{
		return Socialite::with('google')->redirect();
	}

	public function handleProviderCallback()
	{
		$user = Socialize::with('google')->user();

		if ( !is_null($user) ) {
			$count = User::where('email', $user->getEmail())->count();
			if ( $count > 0 ) {
				// user already exists
				$usr = DB::table('users')->where('email', 'vmod.game@gmail.com')->first();
				// log user into system
				Auth::loginUsingId($usr->id);

				return redirect()->intended('/');
			} else {
				// user not exists, register new user
				return redirect()->intended('dashboard')->with('error', '<strong>Email không tồn tại trong hệ thống<strong><br /><em>Vui lòng liên hệ quản trị viên để biết thêm chi tiết!</em>');
			}
		}

		// $user->token;
	}

	public function logout()
	{
		Auth::logout();
		return redirect()->intended('/auth/login')->with('message', 'Logged out!!');
	}

}
