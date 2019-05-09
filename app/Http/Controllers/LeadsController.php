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
		$ip = $_SERVER['REMOTE_ADDR'];
		$city = CommonMethod::getZipcodeInfo($lead['zipcode']);
		$ignoreFields =["_token","first_name","last_name","street","zipcode","phone","email","dob-month","dob-date","dob-year","gender","dl1","state1","first_name2","last_name2","dob2-month","dob2-date","dob2-year","gender-2","dl2","state2","first_name3","last_name3","dob3-month","dob3-date","dob3-year","gender-3","dl3","state3","first_name4","last_name4","dob4-month","dob4-date","dob4-year","gender-4","dl4","state4","first_name5","last_name5","dob5-month","dob5-date","dob5-year","gender-5","dl5","state5","vehicle-year","year","make","make-other","make-select","model1-other","model-1","vin1","ownership-vehicle-1","primary-use-vehicle-1","miles-driven-per-year-vehicle-1","vehicle-year-2","vehicle2-year","vehicle2-make","vehicle2-make-other","vehicle2-make-select","model2-other","model-2","vin2","ownership-vehicle-2","primary-use-vehicle-2","miles-driven-per-year-vehicle-2","vehicle-year-3","vehicle3-year","vehicle3-make","vehicle3-make-other","vehicle3-make-select","model3-other","model-3","vin3","ownership-vehicle-3","primary-use-vehicle-3","miles-driven-per-year-vehicle-3","vehicle-year-4","vehicle4-year","vehicle4-make","vehicle4-make-other","vehicle4-make-select","model4-other","model-4","vin4","ownership-vehicle-4","primary-use-vehicle-4","miles-driven-per-year-vehicle-4","vehicle-year-5","vehicle5-year","vehicle5-make","vehicle5-make-other","vehicle5-make-select","model5-other","model-5","vin5","ownership-vehicle-5","primary-use-vehicle-5","miles-driven-per-year-vehicle-5","vehicle2","vehicle3","vehicle4","vehicle5"];
		$data = ['ignoreFields' => $ignoreFields, 'lead' => $lead,'ip' => $ip, 'city' => $city, 'states' => CommonMethod::getStates()];
		\Mail::send('Emails.Lead.new', $data,
		function ($message) {
			$message->to('masisdavidian@gmail.com')->subject('New Lead - Insurance');
		});
		return view('Insurance.urls',$data);
		// return view('Insurance.view',$data);
	}

	public function validateZipcode(Request $request){
		return response()->json(['zipcode' => CommonMethod::getZipcodeInfo(90001)]);
	}
}
