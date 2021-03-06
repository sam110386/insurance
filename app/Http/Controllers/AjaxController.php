<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Helpers\CommonMethod;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class AjaxController extends BaseController{

	/*
	** Get All Vehicle Years (Distinct)
	*/
	public function getYears(){
		return Vehicle::select('year')->distinct()->orderby('year','asc')->get();
	}

	/*
	** Get Makes by Year
	*/
	public function getMakes(Request $request){
		return Vehicle::select('make')->where('year',$request->year)->distinct()->orderby('make','asc')->get();
	}

	public function getAdminMake(Request $request){
		return [["id"=>1,"text"=>"hello"],["id"=>1,"text"=>"World"]];
		// return DB::select('select DISTINCT (make) as text  from `vehicles` where `year` =?',[$request->q]);
		// return Vehicle::select('make')->where('year', $request->q)->distinct()->get(['id', DB::raw('make as text')]);
	}

	/*
	** Get Models by Make
	*/
	public function getModels(Request $request){
		return Vehicle::select('vmodel')
		->where('year',$request->year)
		->where('make',$request->make)
		->distinct()
		->orderby('vmodel','asc')
		->get();
	}

	/*
	** Get Models by Make and Models
	*/
	public function getTrims(Request $request){
		return Vehicle::select('trim_1')
		->where('year',$request->year)
		->where('make',$request->make)
		->where('vmodel',$request->model)
		->distinct()
		->orderby('trim_1','asc')
		->get();
	}

}