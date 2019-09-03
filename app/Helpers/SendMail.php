<?php 
namespace App\Helpers;
use Illuminate\Support\Facades\Config;

class SendMail {

	public static function adminLeadSubmitNotification($lead){
		return \Mail::send('Emails.Lead.admin', ['lead' => $lead],
			function ($message) {
				$message->to(Config::get('constants.admin_email'))->bcc(Config::get('constants.admin_bcc_email'))->subject('New Lead - Insurance');
			});		
	}



	public static function userLeadSubmitNotification($lead){
		return \Mail::send('Emails.Lead.user', ['user' => $lead->first_name],
			function ($message) use($lead) {
				$message->to($lead->email)->subject('New Lead Confirmation - Insurance');
			});
	}

	public static function bulkLeadEmail($lead,$email){
		\Mail::send('Admin.Lead.email', ['lead' => $lead],
			function ($message) use($email){
				$message->to($email)->subject('New Lead Notification - Insurance');
			});
	}


	public static function adminNewUserNotification($user){
		\Mail::send('Emails.Admin.new_user', ['user' => $user],
			function ($message){
				$message->to(Config::get('constants.admin_email'))->bcc(Config::get('constants.admin_bcc_email'))->subject('New User - Insurance');
			});
	}

	public static function userWelcomeNotification($user){
		\Mail::send('Emails.User.welcome', ['user' => $user],
			function ($message) use($user){
				$message->to($user->email)->subject('Welcome Email - Insurance');
			});		
	}


	public static function passwordResetUrlNotification($user,$url){
		if(!$user->email) return;
		\Mail::send('Emails.User.reset-password', ['name' => $user->name, "url" => $url ],
			function ($message) use($user){
				$message->to($user->email)->subject('Resest Password - Insurance');
			});		
	}


	public static function sendMailToMangerOnNewUser($group,$user){
		if(!$group->user->email) return;
		\Mail::send('Emails.Manager.new_user', ['user' => $user,'group' => $group],
			function ($message) use($group){
				$message->to($group->user->email)->subject('New User - ' . $group->name . '- Insurance');
			});
	}

}