<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

/**
 * Static Pages Controller
 */
class PagesControllers extends Controller
{
	public function getPage(){
		return view('Pages.privacy');
	}
}