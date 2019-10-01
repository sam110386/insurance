<?php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Encore\Admin\Auth\Database\Administrator;


class AdminUsersController extends Controller
{
	public function getUserApi(Request $request){
		$role = $request->get('q');
		return $this->getUsersByRole([$role]);
	}

	public function getUsersByRole($role = ['manager','associate','vendor']){
        return Administrator::whereHas('roles',  function ($query) use($role) {
            $query->whereIn('slug', $role);
        })->get(['id','name as text']);
    }

}