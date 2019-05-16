<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Helpers\CommonMethod;


class LeadsController extends BaseController
{
	public function new(){
		$data['zipcodes'] = CommonMethod::getZipcodeInfo();
		$data['carMakes'] = CommonMethod::getCarMakes();
		$data['carModels'] = CommonMethod::getModels();
		$data['states'] = CommonMethod::getStates();
		$data['insuranceComp'] = ["21st Century","AIG","Allstate","Country Financial","Esurance","Farmers Ins","Geico","Liberty Mutual","MetLife","Nationwide","Progressive","State Farm","Other"];
		return view('Lead.new',$data);
	}

	public function create(Request $request){
		$lead = $request->all();
		$ip = $_SERVER['REMOTE_ADDR'];
		$city = CommonMethod::getZipcodeInfo($lead['zipcode']);
		$data = ['lead' => $lead,'ip' => $ip, 'city' => $city, 'states' => CommonMethod::getStates()];
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
