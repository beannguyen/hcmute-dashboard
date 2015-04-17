<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class UserMeta extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usersmeta';

	public static function addUserMeta($key="",$value="",$userid=0){

		if($key!=""&&$value!=""&&$userid!=0)
		{
			$timezone = +7;
			$datetime=gmdate("H:i:s | d-m-Y ", time() + 3600*($timezone+date("I")))."";
			 $usme=new UserMeta();
			 $usme->userid=$userid;
			 $usme->key=$key;
			 $usme->value=$value;
			 $usme->date_create=$datetime;
			 $usme->date_update=$datetime;
			 $usme->save();
			 return true;  

		}
		return false;
		
	}

	public static function checkUserMeta($id,$key){
		if(UserMeta::where('key', '=', $key)->where('userid','=',$id)->count())
		{
				return true;
		}
		else
		{
			return false;
		}
		
	}

	public static function updateUserMeta($key,$value,$id){
		if(UserMeta::where('key', '=', $key)->where('userid','=',$id)->count()>0)
		{
			$timezone = +7;
			$datetime=gmdate("H:i:s | d-m-Y ", time() + 3600*($timezone+date("I")))."";
			$user=UserMeta::where('key', '=', $key)->where('userid','=',$id)->first();
			$user->value=$value;
			$user->date_update=$datetime;
			$user->save();
			return true;
		}
		return false;
		
	}
	
	

	
	

}
