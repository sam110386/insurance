<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Helpers\SendMail;
/**
 * Static Pages Controller
 */

class PagesControllers extends BaseController
{
	public function getPage(Request $request){
		$currentPath = Route::getFacadeRoot()->current()->uri();
		return view('Pages.'.$currentPath);
	}


	public function contactpost(Request $request){
		$lead = $request->all();
		SendMail::sendMailToMangerOnContactUs($lead->toArray());
		return redirect()->route('thankyou');
	}
}