<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 *
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;
		$this->subject = 'Your Password Reset Link'; //  < --JUST ADD THIS LINE
		$this->middleware('guest');
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

	public function postRemind(Request $request)
	{
		$response = $this->passwords->sendResetLink($request->only('email'), function($message) {
			$message->subject($this->subject);
		});

		switch ($response) {
			case PasswordBroker::RESET_LINK_SENT:
				Session::put('message', 'Một email đã gửi đến hộp thư của bạn, hãy nhấn vào đường link để tiến hành đổi mật khẩu');
				Session::put('email_to_reset', $request->only('email'));
				return redirect('auth/login');
			case PasswordBroker::INVALID_USER:

				Session::put('error', 'Email không tồn tại trên hệ thống');
				return redirect('auth/login');
			case PasswordBroker::INVALID_TOKEN:

				Session::put('error', 'Phiên truy cập bị từ chối, vui lòng thử lại');
				return redirect('auth/login');
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		if( !is_null($this->message) )
			$data['message'] = $this->message;
		if( !is_null($this->error) )
			$data['error'] = $this->error;

		$data['token'] = $token;
		return view('auth.reset')->with('data', $data);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = $this->passwords->reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);
			$user->save();
		});

		switch ($response)
		{
			case PasswordBroker::INVALID_PASSWORD:
				return redirect()->back()->with('error', 'Mật khẩu không hợp lệ');
			case PasswordBroker::INVALID_TOKEN:
				return redirect()->back()->with('error', 'Mã xác nhận không hợp lệ, vui lòng kiểm tra lại email');
			case PasswordBroker::INVALID_USER:
				return redirect()->back()->with('error', 'Email người dùng không hợp lệ');
			case PasswordBroker::PASSWORD_RESET:
				return redirect()->intended('/auth/login')->with('message', 'Đổi mật khẩu thành công, bạn có thể đăng nhập');
		}
	}
}
