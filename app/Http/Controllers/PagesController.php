<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

/**
 * Static Pages Controller
 */
class PagesControllers extends BaseController
{
	public function getPage(){
		return view('Pages.privacy');
	}
}