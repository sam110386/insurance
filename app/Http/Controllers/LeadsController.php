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
		return view('Lead.new',$data);
	}
}
