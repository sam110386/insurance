<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\CommonMethod;


class LeadsController extends Controller
{
	public function new(){
		$data['zipcodes'] = CommonMethod::getZipcodeInfo();
		$data['carMakes'] = CommonMethod::getCarMakes();
		$data['carModels'] = CommonMethod::getModels();
		$data['states'] = CommonMethod::getStates();
		
		$data['makes'] = ["ACURA","ALFA ROMEO","ASTON MARTIN","AUDI","BENTLEY","BMW",
		"BUICK","CADILLAC","CHEVROLET","CHRYSLER","DODGE","FERRARI","FIAT","FORD"];
		$data['models'] = ["Dodge Challenger","Dodge Challenger GT","Dodge Challenger SRT","Dodge Challenger SRT8","Dodge Charger","Dodge Charger AWD","Dodge Charger SRT","Dodge Charger SRT8","Dodge Dart","Dodge Dart Aero","Dodge Dart GT","Dodge Durango AWD","Dodge Durango RWD","Dodge Durango SRT AWD","Dodge Grand Caravan","Dodge Journey","Dodge Journey AWD","Dodge Viper","Dodge Viper SRT"];
		$data['insuranceComp'] = ["21st Century","AIG","Allstate","Country Financial","Esurance","Farmers Ins","Geico","Liberty Mutual","MetLife","Nationwide","Progressive","State Farm","Other"];
		return view('Lead.new',$data);
	}

	public function create(Request $request){
		$lead = $request->all();
		// dd(\Config::get('mail'));
		// echo "<pre>"; print_r($lead);echo "</pre>";
		\Mail::send('Emails.Lead.new', ['lead' => $lead],
		function ($message) {
			$message->to('masisdavidian@gmail.com')->subject('New Lead - Insurance');
		});
		$data = ['lead' => $lead];
		return view('Insurance.urls',$data);
	}

	public function validateZipcode(Request $request){
		return response()->json(['zipcode' => CommonMethod::getZipcodeInfo(90001)]);
	}
}
