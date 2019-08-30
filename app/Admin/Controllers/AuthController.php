<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Hash;
use DB;

use App\Models\AdminUser;
use App\Helpers\SendMail;

class AuthController extends BaseAuthController
{

	public function forgotPassword(){
		if ($this->guard()->check()) {
			return redirect($this->redirectPath());
		}

		return view('Admin.forgot-password');
	}

	public function sendPasswordResetToken(Request $request)
	{
		if ($this->guard()->check()) {
			return redirect($this->redirectPath());
		}		
		$validatedData = $request->validate([
			'email' => 'required|email',
		]);

		$user = AdminUser::where ('email', $request->email)->first();
		if ( !$user ) return redirect()->back()->withErrors(['email' => 'Email not exist!']);

		$token = str_random(64);
		$data = [
			'email' => $request->email,
			'token' => $token,
			'created_at' => Carbon::now()
		];
		if(DB::table('password_resets')->insert($data)){
			SendMail::passwordResetUrlNotification($user,route('password-reset',$token));
			return redirect()->back()->with(['message' => 'We have sent an email with password reset link.Please check you email inbox.']);
		}else{
			return redirect()->back()->withErrors(['email' => 'Something went wrong! Please try again.']);
		}


	}
	public function passwordResetView($token){
		if ($this->guard()->check()) {
			return redirect($this->redirectPath());
		}		
		$tokenData = DB::table('password_resets')->where('token', $token)->first();

		if ( !$tokenData ) return redirect()->route('admin.home');
		return view('Admin.reset-password',['token'=>$token]);
	}

	public function passwordReset(Request $request,$token){
		if ($this->guard()->check()) {
			return redirect($this->redirectPath());
		}
		$validatedData = $request->validate([
			'password' => 'required|confirmed',
			'password_confirmation' =>'required'
		]);


		$password = $request->password;
		$tokenData = DB::table('password_resets')
		->where('token', $token)->first();

		$user = AdminUser::where('email', $tokenData->email)->first();
		if ( !$user ) return redirect()->route('admin.login')->with(['error' => 'Email id not exist.Please try again by going to forgot password']);

		$user->password = Hash::make($password);
		$user->update(); 

		DB::table('password_resets')->where('email', $user->email)->delete();
		return redirect()->route('admin.login')->with(['message' => 'Password has been updated successfuly.']);
	}
}
