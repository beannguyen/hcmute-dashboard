<?php namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;


use App\User;
use App\UserMeta;
use View,
    Response,
    Validator,
    Input,
    Mail,
    Session;
class UserController extends Controller{

	public function getNewUser()
	{
		return   view('users/addnewuser');
	}

	public function postNewUser()
	{
		$value=array('username' => Input::get('username'),
					'password' => Input::get('password'),
					'email' => Input::get('email'));
		$rules=array(
		'username' => 'required|min:2',
		'password'=>'required|min:5',
		'email'=>'required|email',
		);
		if(!Validator::make(Input::all(),$rules)->fails())
		{
			if(! User::check_user(Input::get('username'))&& !User::check_email(Input::get('email')))
			{
				if(User::addUser(Input::all()))
				{
					return Redirect::to('all-user');
				}
				else
				{
					return Redirect::to('newuser')->with('error','Tạo tài khoản không thành công.');
				}
			}
			else
			{
				return Redirect::to('newuser')->with('error','Tạo tài khoản không thành công.');
			}
		}
	
	}
	public function check_username()
	{
		if(User::check_user(Input::get('username')))
		{
			return "false";
		}
		else
		{
			return "true";
		}
	}
	public function check_email()
	{
		if(User::check_email(Input::get('email')))
		{
			return "false";
		}
		else
		{
			return "true";
		}
	}


	public function getAllUser(){
		return view('users/alluser')->with('users', User::all());
	}

	public function postUpdateUser(){
		if(isset($_POST))
		{
			$username=$_POST['username'];
			$name=$_POST['name'];
			$email=$_POST['email'];
			$group_id=$_POST['group_id'];
			$arruser=array('username' => $username,
				'name'=>$name,
				'email'=>$email,
				'group_id'=>$group_id);
			if(User::updateUser($arruser))
			{
				return Redirect::to('all-user');
			}
			else
			{
				//
			}

		}
	}

	public function postDeleteUser(){
		if(isset($_POST['username']))
		{
			if(User::deleteUser($_POST['username']))
				return Redirect::to('all-user');
		}
	}

	public function getProfileUser($id){
		return view('users/profileuser')->with('id',$id);
	}

	public function postProfileUser(){
		if(isset($_POST))
		{
			$arrinput=Input::all();
			$idpost=(int)$arrinput['id'];



			if(isset($_FILES["avatar"]["tmp_name"])&&$_FILES["avatar"]["tmp_name"]!=null)
			{
				if (Input::file('avatar')->isValid()) {
			       // upload path
				  $destinationPath=public_path().'/images/profile_img/';
			      $extension = Input::file('avatar')->getClientOriginalExtension(); // getting image extension
			      $fileName = rand(11111,99999).'.'.$extension; // renameing image
			      Input::file('avatar')->move( $destinationPath, $fileName); // uploading file to given path
			     if(UserMeta::checkUserMeta($idpost,'avatar'))
			     {
			     	if(!UserMeta::updateUserMeta('avatarpath',$destinationPath.$fileName,$idpost))
			     	{
			     		return redirect('/profile-user/7?nav=settings')->with('errorprofile',"Upload ảnh đại diện không thành công.");
			     	}
			     }
			     else
			     {
			     	if(!UserMeta::addUserMeta('avatarpath',$destinationPath.$fileName,$idpost))
			     	{
			     		return redirect('/profile-user/7?nav=settings')->with('errorprofile',"Upload ảnh đại diện không thành công.");
			     	}
			     }
			      
				  
			    }
			    else {
			      // sending back with error message.
			      return redirect('/profile-user/7?nav=settings')->with('errorprofile',"Cài đặt người dùng không chính xác.");
			    }
			}
			

			foreach ($arrinput as $key => $value) {
				if($key!=""&&$value!="" && $key!="avatar" &&$key!="id" &&$key!="_token" &&$value!=null)
				{
					if(UserMeta::checkUserMeta($idpost,$key))
				    {
				     	if(!UserMeta::updateUserMeta($key,$value,$idpost))
				     	{
				     		return redirect('/profile-user/7?nav=settings')->with('errorprofile',"Cài đặt người dùng không chính xác.");
				     	}
				    }
			     	else
				    {
				     	if(!UserMeta::addUserMeta($key,$value,$idpost))
				     	{
				     		return redirect('/profile-user/7?nav=settings')->with('errorprofile',"Cài đặt người dùng không chính xác.");
				     	}
				    }
				}
				
			}
			//return Redirect::to('profile-user/'+$idpost);
			return Redirect::route('profileuser', array('id' => $idpost));
			
		}
	}
	
}