<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['password', 'remember_token']; 

	
	public static function addUser($info=array()){
		if(sizeof($info)>0)
		{
				$timezone = +7;
				$datetime=gmdate("H:i:s | d-m-Y ", time() + 3600*($timezone+date("I")))."";
				$user=new User();
				$user->username=$info['username'];
				$user->password=Hash::make($info['password']);
				$user->email=$info['email'];
				$user->name=$info['fullname'];
				$user->date_create=$datetime;
				$user->date_update=$datetime;
				$user->group_id='0';
				$user->save();
				return true;
				//Session::put('register_success',Input::get('username')." đã đăng kí thành công");
				//return view('thanh cong');
		}
		return false;
	}
	public static function check_user($user)
	{
		if(User::where('username','=',$user)->count()>0)
			return true;
		else
			return false;
	}
	public static function check_email($email)
	{
		if(User::where('email','=',$email)->count()>0)
			return true;
		else
			return false;
	}

	public static function updateUser($arrupdate=array())
	{
		if(sizeof($arrupdate)>0)
		{
			$timezone = +7;
			$datetime=gmdate("H:i:s | d-m-Y ", time() + 3600*($timezone+date("I")))."";
			$user=User::where('username','=',$arrupdate['username'])->firstOrFail();
			$user->username=$arrupdate['username'];
			$user->name=$arrupdate['name'];
			$user->email=$arrupdate['email'];
			$user->group_id=$arrupdate['group_id'];
			$user->date_update=$datetime;
			$user->save();
			return true;	
		}
		else
		{
			return false;
		}
		

	}
	public static function deleteUser($username)
	{
		if(User::where('username','=',$username)->count()>0)
		{
			$user=User::where('username','=',$username)->firstOrFail();
			$user->delete();
			return true;
		}
		else
		{
			return false;
		}
		
	}

}
