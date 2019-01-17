<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
	public function new(){
		$data['makes'] = ["ACURA","ALFA ROMEO","ASTON MARTIN","AUDI","BENTLEY","BMW",
		"BUICK","CADILLAC","CHEVROLET","CHRYSLER","DODGE","FERRARI","FIAT","FORD"];
		$data['models'] = ["Dodge Challenger","Dodge Challenger GT","Dodge Challenger SRT","Dodge Challenger SRT8","Dodge Charger","Dodge Charger AWD","Dodge Charger SRT","Dodge Charger SRT8","Dodge Dart","Dodge Dart Aero","Dodge Dart GT","Dodge Durango AWD","Dodge Durango RWD","Dodge Durango SRT AWD","Dodge Grand Caravan","Dodge Journey","Dodge Journey AWD","Dodge Viper","Dodge Viper SRT"];
		$data['insuranceComp'] = ["21st Century","AIG","Allstate","Country Financial","Esurance","Farmers Ins","Geico","Liberty Mutual","MetLife","Nationwide","Progressive","State Farm","Other"];
		return view('Lead.new',$data);
	}

	public function create(Request $request){
		// echo "<pre>"; print_r($request->all());echo "</pre>";
		$data = [];
		return view('Insurance.urls',$data);
	}
}
