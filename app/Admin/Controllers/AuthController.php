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
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Facades\Admin as LoginAdmin;
use Illuminate\Support\Facades\Storage;


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

	public function getSetting(Content $content){
       return $content
        ->header('Edit Profile')
        ->description('')
        ->body($this->form()->edit(LoginAdmin::user()->id));		
	}

	public function form()
	{
		$userModel = config('admin.database.users_model');
		$permissionModel = config('admin.database.permissions_model');
		$roleModel = config('admin.database.roles_model');

		$form = new Form(new $userModel());
		$form->hidden('id');
		$form->text('name', trans('admin.first_name'))->rules('required');
		$form->text('last_name', trans('admin.last_name'));
		$form->mobile('phone', trans('admin.phone'))->options(['mask' => '999-999-9999'])->attribute(['style' => 'width:100%;']);
		$form->display('username', trans('admin.username'));
		$form->display('email', trans('admin.email'));
		$form->image('avatar', trans('admin.avatar'))->attribute(['accept'=>"image/*"]);
		$form->divide();
		$form->password('password', trans('admin.password'))->rules('required|confirmed');
		$form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')->default(function ($form) {
			return $form->model()->password;
		});

		$form->divide();

		$form->ignore(['password_confirmation','groups']);
		$form->saving(function (Form $form) {
			if ($form->password && $form->model()->password != $form->password) {
				$form->password = bcrypt($form->password);
			}
		});

		$form->tools(function (Form\Tools $tools) {
		    $tools->disableBackButton();
		    $tools->disableDelete();
		    $tools->disableView();
		    $tools->disableListButton();
		});
		$form->disableReset();
		$form->disableViewCheck();
		$form->disableEditingCheck();
		$form->disableCreatingCheck();
		$form->setAction(route('user.profile.update'));
		// $form->setAction(route('users.update',LoginAdmin::user()->id));

		return $form;
	}

	public function saveProfile(Request $request){
        $valid = request()->validate([
            'name' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);		
		$user  = AdminUser::findOrFail($request->id);
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->phone = $request->phone;
		$user->password = bcrypt($request->password);

		if($request->hasFile('avatar')){
			$uploadedFile = $request->file('avatar');
			if($uploadedFile->isValid()){
				$filename = time().$uploadedFile->getClientOriginalName();
				$disk =config('admin.upload.disk');
				$destination = (config('admin.upload.directory.image')) ?   config('admin.upload.directory.image') . '/' . $filename : $filename ;
				$file = Storage::disk($disk)->putFileAs('',$uploadedFile,$destination);
				$user->avatar = Storage::disk($disk)->url($file);
			}
		}

		if($user->update()){
            admin_success('Success','Profile has been updated');
            return back();
		}else{
            admin_error('Error','Profile not been updated.Please try again');
            return back();
		}
	}

}
