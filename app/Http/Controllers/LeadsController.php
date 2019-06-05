<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Helpers\CommonMethod;
use App\Models\Lead;


class LeadsController extends BaseController
{
	public function index(){
		
	}
	public function newLead(){
		$data['years'] = CommonMethod::getYears();
		$data['zipcodes'] = CommonMethod::getZipcodeInfo();
		// $data['carMakes'] = CommonMethod::getCarMakes();
		// $data['carModels'] = CommonMethod::getModels();
		$data['states'] = CommonMethod::getStates();
		$data['insuranceComp'] = CommonMethod::getInsuranceCompanies();
		return view('Lead.new',$data);
	}

	public function saveLead(Request $request){
		$lead = $request->all();
		$ip = $_SERVER['REMOTE_ADDR'];
		$city = CommonMethod::getZipcodeInfo($lead['zipcode']);
		$data = ['lead' => $lead,'ip' => $ip, 'city' => $city, 'states' => CommonMethod::getStates()];
		$this->storeLead($data);
		\Mail::send('Emails.Lead.new', $data,
		function ($message) {
			$message->to('allensaraf@gmail.com')->bcc('masisdavidian@gmail.com')->subject('New Lead - Insurance');
		});
		return view('Insurance.urls',$data);
		// return view('Insurance.view',$data);
	}

	private function storeLead($request=[]){
		$data = [];
		$lead = $request['lead'];
		$states = $request['states'];
		$data['first_name'] 				= $lead['first_name'];
		$data['last_name'] 					= $lead['last_name'];
		$data['street'] 					= $lead['street'];
		$data['city'] 						= $request['city'];
		$data['state'] 						= "California";
		$data['zip'] 						= $lead['zipcode'];
		$data['phone'] 						= $lead['phone'];
		$data['email'] 						= $lead['email'];

		if(isset($lead['married'])){
			$data['married'] = $lead['married'];
		}
		if(isset($lead['children'])){
			$data['children'] = $lead['children'];
		}

		$data['homeowner'] 					= $lead['homeowner'];
		$data['bundled'] 					= $lead['bundled'];
		$data['first_driver_first_name'] 	= $lead['first_name'];
		$data['first_driver_last_name'] 	= $lead['last_name'];
		$data['first_driver_dob'] 			= $lead['dob-year']. "-" . $lead['dob-month']. "-" .$lead['dob-date'];
		$data['first_driver_gender'] 		= $lead['gender'];
		$data['first_driver_dl'] 			= $lead['dl1'];
		$data['first_driver_state'] 		= $states[$lead['state1']];

		$data['second_driver_first_name'] 	= (isset($lead['first_name2'])) ? $lead['first_name2']  : "";
		$data['second_driver_last_name'] 	= (isset($lead['last_name2'])) ? $lead['last_name2']  : "";
		$data['second_driver_dob'] 			= (isset($lead['dob2-year']) && isset($lead['dob2-month']) && isset($lead['dob2-date']) ) ? $lead['dob2-year']. "-" . $lead['dob2-month']. "-" .$lead['dob2-date']  : null;
		$data['second_driver_gender'] 		= (isset($lead['gender-2'])) ? $lead['gender-2']  : "";
		$data['second_driver_dl'] 			= (isset($lead['dl2'])) ? $lead['dl2']  : "";
		$data['second_driver_state'] 		= (isset($lead['state2'])) ? $states[$lead['state2']]  : "";

		$data['third_driver_first_name'] 	= (isset($lead['first_name3'])) ? $lead['first_name3']  : "";
		$data['third_driver_last_name'] 	= (isset($lead['last_name3'])) ? $lead['last_name3']  : "";
		$data['third_driver_dob'] 			= (isset($lead['dob3-year']) && isset($lead['dob3-month']) && isset($lead['dob3-date']) ) ? $lead['dob3-year']. "-" . $lead['dob3-month']. "-" .$lead['dob3-date']  : null;
		$data['third_driver_gender'] 		= (isset($lead['gender-3'])) ? $lead['gender-3']  : "";
		$data['third_driver_dl'] 			= (isset($lead['dl3'])) ? $lead['dl3']  : "";
		$data['third_driver_state'] 		= (isset($lead['state3'])) ? $states[$lead['state3']]  : "";

		$data['fourth_driver_first_name'] 	= (isset($lead['first_name4'])) ? $lead['first_name4']  : "";
		$data['fourth_driver_last_name'] 	= (isset($lead['last_name4'])) ? $lead['last_name4']  : "";
		$data['fourth_driver_dob'] 			= (isset($lead['dob4-year']) && isset($lead['dob4-month']) && isset($lead['dob4-date']) ) ? $lead['dob4-year']. "-" . $lead['dob4-month']. "-" .$lead['dob4-date']  : null;
		$data['fourth_driver_gender'] 		= (isset($lead['gender-4'])) ? $lead['gender-4']  : "";
		$data['fourth_driver_dl'] 			= (isset($lead['dl4'])) ? $lead['dl4']  : "";
		$data['fourth_driver_state'] 		= (isset($lead['state4'])) ? $states[$lead['state4']]  : "";

		$data['fifth_driver_first_name'] 	= (isset($lead['first_name5'])) ? $lead['first_name5']  : "";
		$data['fifth_driver_last_name'] 	= (isset($lead['last_name5'])) ? $lead['last_name5']  : "";
		$data['fifth_driver_dob'] 			= (isset($lead['dob5-year']) && isset($lead['dob5-month']) && isset($lead['dob5-date']) ) ? $lead['dob5-year']. "-" . $lead['dob5-month']. "-" .$lead['dob5-date']  : null;
		$data['fifth_driver_gender'] 		= (isset($lead['gender-5'])) ? $lead['gender-5']  : "";
		$data['fifth_driver_dl'] 			= (isset($lead['dl5'])) ? $lead['dl5']  : "";
		$data['fifth_driver_state'] 		= (isset($lead['state5'])) ? $states[$lead['state5']]  : "";


		$data['first_vehicle_year'] 		= ($lead['vehicle-year']) ? $lead['vehicle-year'] : $lead['year'];

		if($lead['make-other']){
			$data['first_vehicle_make'] = $lead['make-other'];
		}elseif($lead['make-select']){
			$data['first_vehicle_make'] = $lead['make-select'];
		}else{
			$data['first_vehicle_make'] = $lead['make'];
		}

		$data['first_vehicle_model'] 		= ($lead['model1-other']) ? $lead['model1-other'] : $lead['model-1']; 
		$data['first_vehicle_trim'] 		= (isset($lead['trim-1'])) ? $lead['trim-1'] : "";
		$data['first_vehicle_vin'] 			= $lead['vin1'];
		$data['first_vehicle_owenership'] 	= $lead['ownership-vehicle-1'];
		$data['first_vehicle_uses'] 		= $lead['primary-use-vehicle-1'];
		$data['first_vehicle_mileage'] 		= $lead['miles-driven-per-year-vehicle-1'];


		if(isset($lead['vehicle2']) && $lead['vehicle2'] && $lead['miles-driven-per-year-vehicle-2'])
		{

			$data['second_vehicle_year'] = ($lead['vehicle-year-2']) ? $lead['vehicle-year-2'] : $lead['vehicle2-year'];
			if($lead['vehicle2-make-other']){
				$data['second_vehicle_make'] 		= $lead['vehicle2-make-other'];
			}elseif($lead['vehicle2-make-select']){
				$data['second_vehicle_make'] 		= $lead['vehicle2-make-select'];
			}else{
				$data['second_vehicle_make'] 		= $lead['vehicle2-make'];
			}

			$data['second_vehicle_model'] 		= ($lead['model2-other']) ? $lead['model2-other'] : $lead['model-2'];
			$data['second_vehicle_trim'] 		= (isset($lead['trim-2'])) ? $lead['trim-2'] : "";
			$data['second_vehicle_vin'] 		= $lead['vin2'];
			$data['second_vehicle_owenership'] 	= $lead['ownership-vehicle-2'];
			$data['second_vehicle_uses'] 		= $lead['primary-use-vehicle-2'];
			$data['second_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-2'];

		}	

		if(isset($lead['vehicle3']) && $lead['vehicle3'] && $lead['miles-driven-per-year-vehicle-3'])
		{

			$data['third_vehicle_year'] 		= ($lead['vehicle-year-3']) ? $lead['vehicle-year-3'] : $lead['vehicle3-year'];
			if($lead['vehicle3-make-other']){
				$data['third_vehicle_make'] 		= $lead['vehicle3-make-other'];
			}elseif($lead['vehicle3-make-select']){
				$data['third_vehicle_make'] 		= $lead['vehicle3-make-select'];
			}else{
				$data['third_vehicle_make'] 		= $lead['vehicle3-make'];
			}

			$data['third_vehicle_model'] 		= ($lead['model3-other']) ? $lead['model3-other'] : $lead['model-3'];
			$data['third_vehicle_trim'] 		= (isset($lead['trim-3'])) ? $lead['trim-3'] : "";
			$data['third_vehicle_vin'] 		= $lead['vin3'];
			$data['third_vehicle_owenership'] 	= $lead['ownership-vehicle-3'];
			$data['third_vehicle_uses'] 		= $lead['primary-use-vehicle-3'];
			$data['third_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-3'];
		}

		if(isset($lead['vehicle4']) && $lead['vehicle4'] && $lead['miles-driven-per-year-vehicle-4'])
		{

			$data['fourth_vehicle_year'] 		= ($lead['vehicle-year-4']) ? $lead['vehicle-year-4'] : $lead['vehicle4-year'];
			if($lead['vehicle4-make-other']){
				$data['fourth_vehicle_make'] 		= $lead['vehicle4-make-other'];
			}elseif($lead['vehicle4-make-select']){
				$data['fourth_vehicle_make'] 		= $lead['vehicle4-make-select'];
			}else{
				$data['fourth_vehicle_make'] 		= $lead['vehicle4-make'];
			}

			$data['fourth_vehicle_model'] 		= ($lead['model4-other']) ? $lead['model4-other'] : $lead['model-4'];
			$data['fourth_vehicle_trim'] 		= (isset($lead['trim-4'])) ? $lead['trim-4'] : "";
			$data['fourth_vehicle_vin'] 		= $lead['vin4'];
			$data['fourth_vehicle_owenership'] 	= $lead['ownership-vehicle-4'];
			$data['fourth_vehicle_uses'] 		= $lead['primary-use-vehicle-4'];
			$data['fourth_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-4'];

		}	

		if(isset($lead['vehicle5']) && $lead['vehicle5'] && $lead['miles-driven-per-year-vehicle-5'])
		{
			$data['fifth_vehicle_year'] 		= ($lead['vehicle-year-5']) ? $lead['vehicle-year-5'] : $lead['vehicle5-year'];
			if($lead['vehicle5-make-other']){
				$data['fifth_vehicle_make'] 		= $lead['vehicle5-make-other'];
			}elseif($lead['vehicle5-make-select']){
				$data['fifth_vehicle_make'] 		= $lead['vehicle5-make-select'];
			}else{
				$data['fifth_vehicle_make'] 		= $lead['vehicle5-make'];
			}

			$data['fifth_vehicle_model'] 		= ($lead['model5-other']) ? $lead['model5-other'] : $lead['model-5'];
			$data['fifth_vehicle_trim'] 		= (isset($lead['trim-5'])) ? $lead['trim-5'] : "";
			$data['fifth_vehicle_vin'] 		= $lead['vin5'];
			$data['fifth_vehicle_owenership'] 	= $lead['ownership-vehicle-5'];
			$data['fifth_vehicle_uses'] 		= $lead['primary-use-vehicle-5'];
			$data['fifth_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-5'];

		}


		$data['liability'] 					= "";
		$data['body_injury'] 				= $lead['bodily-injury'];
		$data['deduct'] 					= $lead['deductible'];
		$data['medical'] 					= $lead['medical'];
		$data['towing'] 					= $lead['towing'];
		$data['uninsured'] 					= $lead['uninsured'];
		$data['rental'] 					= $lead['rental'];
		$data['previous_insurance'] 		= $lead['previous-insurance'];
		$data['current_insurance'] 			= (isset($lead['current-insurance'])) ? $lead['current-insurance'] : "NA" ;
		$data['duration'] 					= (isset($lead['current-insurance-duration'])) ? $lead['current-insurance-duration'] : "NA";
		$data['at_fault'] 					= $lead['at_fault'];
		$data['tickets'] 					= $lead['tickets'];
		$data['dui'] 						= $lead['dui'];
		$data['quality_provides'] 			= $lead['quality'];
		$data['agent_in_person'] 			= $lead['agent_in_person'];
		$data['referrer'] 		= $lead['referrer'];
		$data['referrer_name'] 				= $lead['referrer_name'];
		$data['ip_address'] 				= $request['ip'];		
		return Lead::create($data);
	}


	public function validateZipcode(Request $request){
		return response()->json(['zipcode' => CommonMethod::getZipcodeInfo(90001)]);
	}
}
