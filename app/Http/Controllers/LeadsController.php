<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Helpers\CommonMethod;
use App\Helpers\SendMail;
use App\Models\Lead;
use App\Models\Affiliate;
use App\Models\AffiliateLead;



class LeadsController extends BaseController
{
	public function index(){
		
	}
	public function newLead(){
		$data['years'] = CommonMethod::getYears();
		$data['zipcodes'] = CommonMethod::getZipcodeInfo();
		$data['states'] = CommonMethod::getStates();
		$data['insuranceComp'] = CommonMethod::getInsuranceCompanies();
		return view('Lead.new',$data);
	}

	public function saveLead(Request $request){
		$lead = $request->all();
		$ip = $_SERVER['REMOTE_ADDR'];
		$city = CommonMethod::getZipcodeInfo($lead['zipcode']);
		$data = ['lead' => $lead,'ip' => $ip, 'city' => $city, 'states' => CommonMethod::getStates()];
		$lead = $this->storeLead($data);
		$lead = Lead::findOrFail($lead->id);
		$lead->phone =  $lead->phoneNumber($lead->phone);

		/* Email notification to admin  */
		SendMail::adminLeadSubmitNotification($lead->toArray());
		/* Email notification to user  */
		SendMail::userLeadSubmitNotification($lead);
		
		$redirect = $this->checkAndProcessAffiliateRecord($lead->id);
		if($redirect) return redirect()->away($redirect);

		return view('Insurance.urls',$data);
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
		$data['first_driver_dob'] 			= isset($lead['dob'])?date('Y-m-d',strtotime($lead['dob'])):null;
		$data['first_driver_gender'] 		= $lead['gender'];
		$data['first_driver_dl'] 			= $lead['dl1'];
		$data['first_driver_state'] 		= ($lead['state1'] == 'other') ? $lead['state1-other'] : $states[$lead['state1']];

		$data['second_driver_first_name'] 	= (isset($lead['first_name2'])) ? $lead['first_name2']  : "";
		$data['second_driver_last_name'] 	= (isset($lead['last_name2'])) ? $lead['last_name2']  : "";
		$data['second_driver_dob'] 			= isset($lead['dob2'])?date('Y-m-d',strtotime($lead['dob2'])):null;
		$data['second_driver_gender'] 		= (isset($lead['gender-2'])) ? $lead['gender-2']  : "";
		$data['second_driver_dl'] 			= (isset($lead['dl2'])) ? $lead['dl2']  : "";
		
		if(isset($lead['state2'])){
			$data['second_driver_state']  = ($lead['state2'] == 'other') ? $lead['state2-other'] : $states[$lead['state2']];
		}

		$data['third_driver_first_name'] 	= (isset($lead['first_name3'])) ? $lead['first_name3']  : "";
		$data['third_driver_last_name'] 	= (isset($lead['last_name3'])) ? $lead['last_name3']  : "";
		$data['third_driver_dob'] 			= isset($lead['dob3'])?date('Y-m-d',strtotime($lead['dob3'])):null;
		$data['third_driver_gender'] 		= (isset($lead['gender-3'])) ? $lead['gender-3']  : "";
		$data['third_driver_dl'] 			= (isset($lead['dl3'])) ? $lead['dl3']  : "";
		
		if(isset($lead['state3'])){
			$data['third_driver_state'] = ($lead['state3'] == 'other') ? $lead['state3-other'] : $states[$lead['state3']];
		}

		$data['fourth_driver_first_name'] 	= (isset($lead['first_name4'])) ? $lead['first_name4']  : "";
		$data['fourth_driver_last_name'] 	= (isset($lead['last_name4'])) ? $lead['last_name4']  : "";
		$data['fourth_driver_dob'] 			= isset($lead['dob4'])?date('Y-m-d',strtotime($lead['dob4'])):null;
		$data['fourth_driver_gender'] 		= (isset($lead['gender-4'])) ? $lead['gender-4']  : "";
		$data['fourth_driver_dl'] 			= (isset($lead['dl4'])) ? $lead['dl4']  : "";

		if(isset($lead['state4'])){
			$data['fourth_driver_state'] = ($lead['state4'] == 'other') ? $lead['state4-other'] : $states[$lead['state4']];
		}


		$data['fifth_driver_first_name'] 	= (isset($lead['first_name5'])) ? $lead['first_name5']  : "";
		$data['fifth_driver_last_name'] 	= (isset($lead['last_name5'])) ? $lead['last_name5']  : "";
		$data['fifth_driver_dob'] 			= isset($lead['dob5'])?date('Y-m-d',strtotime($lead['dob5'])):null;
		$data['fifth_driver_gender'] 		= (isset($lead['gender-5'])) ? $lead['gender-5']  : "";
		$data['fifth_driver_dl'] 			= (isset($lead['dl5'])) ? $lead['dl5']  : "";
		if(isset($lead['state5'])){
			$data['fifth_driver_state']  = ($lead['state5'] == 'other') ? $lead['state5-other'] : $states[$lead['state5']];
		}

		if($lead['vehicle-year'] && $lead['vehicle-year'] == 'other'){
			$data['first_vehicle_year'] = 	$lead['year1-other-input'];
		}elseif($lead['vehicle-year']){
			$data['first_vehicle_year'] = 	$lead['vehicle-year'];
		}else{
			$data['first_vehicle_year'] = 	$lead['year'];
		}

		if($lead['make-other']){
			$data['first_vehicle_make'] = $lead['make-other'];
		}elseif($lead['make-select']){
			$data['first_vehicle_make'] = $lead['make-select'];
		}else{
			$data['first_vehicle_make'] = $lead['make'];
		}

		$data['first_vehicle_model'] 		= ($lead['model1-other']) ? $lead['model1-other'] : $lead['model-1'];
		if(isset($lead['trim-1'])){
			$data['first_vehicle_trim'] = $lead['trim-1'];
		}elseif(isset($lead['trim-other-1'])){
			$data['first_vehicle_trim']= $lead['trim-other-1'];
		}else{
			$data['first_vehicle_trim'] = "";	
		}
		$data['first_vehicle_vin'] 			= $lead['vin1'];
		$data['first_vehicle_owenership'] 	= $lead['ownership-vehicle-1'];
		$data['first_vehicle_uses'] 		= $lead['primary-use-vehicle-1'];
		$data['first_vehicle_mileage'] 		= $lead['miles-driven-per-year-vehicle-1'];


		if(isset($lead['vehicle2']) && $lead['vehicle2'] && $lead['miles-driven-per-year-vehicle-2'])
		{

			// $data['second_vehicle_year'] = ($lead['vehicle-year-2']) ? $lead['vehicle-year-2'] : $lead['vehicle2-year'];

			if($lead['vehicle-year-2'] && $lead['vehicle-year-2'] == 'other'){
				$data['second_vehicle_year'] = 	$lead['year2-other-input'];
			}elseif($lead['vehicle-year-2']){
				$data['second_vehicle_year'] = 	$lead['vehicle-year-2'];
			}else{
				$data['second_vehicle_year'] = 	$lead['vehicle2-year'];
			}

			if($lead['vehicle2-make-other']){
				$data['second_vehicle_make'] 		= $lead['vehicle2-make-other'];
			}elseif($lead['vehicle2-make-select']){
				$data['second_vehicle_make'] 		= $lead['vehicle2-make-select'];
			}else{
				$data['second_vehicle_make'] 		= $lead['vehicle2-make'];
			}

			$data['second_vehicle_model'] 		= ($lead['model2-other']) ? $lead['model2-other'] : $lead['model-2'];

			if(isset($lead['trim-2'])){
				$data['second_vehicle_trim'] = $lead['trim-2'];
			}elseif(isset($lead['trim-other-2'])){
				$data['second_vehicle_trim']= $lead['trim-other-2'];
			}else{
				$data['second_vehicle_trim'] = "";	
			}

			$data['second_vehicle_vin'] 		= $lead['vin2'];
			$data['second_vehicle_owenership'] 	= $lead['ownership-vehicle-2'];
			$data['second_vehicle_uses'] 		= $lead['primary-use-vehicle-2'];
			$data['second_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-2'];

		}	

		if(isset($lead['vehicle3']) && $lead['vehicle3'] && $lead['miles-driven-per-year-vehicle-3'])
		{

			// $data['third_vehicle_year'] 		= ($lead['vehicle-year-3']) ? $lead['vehicle-year-3'] : $lead['vehicle3-year'];

			if($lead['vehicle-year-3'] && $lead['vehicle-year-3'] == 'other'){
				$data['third_vehicle_year'] = 	$lead['year3-other-input'];
			}elseif($lead['vehicle-year-3']){
				$data['third_vehicle_year'] = 	$lead['vehicle-year-3'];
			}else{
				$data['third_vehicle_year'] = 	$lead['vehicle3-year'];
			}

			if($lead['vehicle3-make-other']){
				$data['third_vehicle_make'] 		= $lead['vehicle3-make-other'];
			}elseif($lead['vehicle3-make-select']){
				$data['third_vehicle_make'] 		= $lead['vehicle3-make-select'];
			}else{
				$data['third_vehicle_make'] 		= $lead['vehicle3-make'];
			}

			$data['third_vehicle_model'] 		= ($lead['model3-other']) ? $lead['model3-other'] : $lead['model-3'];

			if(isset($lead['trim-3'])){
				$data['third_vehicle_trim'] = $lead['trim-3'];
			}elseif(isset($lead['trim-other-3'])){
				$data['third_vehicle_trim']= $lead['trim-other-3'];
			}else{
				$data['third_vehicle_trim'] = "";	
			}

			$data['third_vehicle_vin'] 		= $lead['vin3'];
			$data['third_vehicle_owenership'] 	= $lead['ownership-vehicle-3'];
			$data['third_vehicle_uses'] 		= $lead['primary-use-vehicle-3'];
			$data['third_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-3'];
		}

		if(isset($lead['vehicle4']) && $lead['vehicle4'] && $lead['miles-driven-per-year-vehicle-4'])
		{

			// $data['fourth_vehicle_year'] 		= ($lead['vehicle-year-4']) ? $lead['vehicle-year-4'] : $lead['vehicle4-year'];
			
			if($lead['vehicle-year-4'] && $lead['vehicle-year-4'] == 'other'){
				$data['fourth_vehicle_year'] = 	$lead['year4-other-input'];
			}elseif($lead['vehicle-year-4']){
				$data['fourth_vehicle_year'] = 	$lead['vehicle-year-4'];
			}else{
				$data['fourth_vehicle_year'] = 	$lead['vehicle4-year'];
			}

			if($lead['vehicle4-make-other']){
				$data['fourth_vehicle_make'] 		= $lead['vehicle4-make-other'];
			}elseif($lead['vehicle4-make-select']){
				$data['fourth_vehicle_make'] 		= $lead['vehicle4-make-select'];
			}else{
				$data['fourth_vehicle_make'] 		= $lead['vehicle4-make'];
			}

			$data['fourth_vehicle_model'] 		= ($lead['model4-other']) ? $lead['model4-other'] : $lead['model-4'];
			if(isset($lead['trim-4'])){
				$trim = $lead['trim-4'];
			}elseif(isset($lead['trim-other-4'])){
				$trim= $lead['trim-other-4'];
			}else{
				$trim = "";	
			}			
			$data['fourth_vehicle_trim'] 		= $trim;
			$data['fourth_vehicle_vin'] 		= $lead['vin4'];
			$data['fourth_vehicle_owenership'] 	= $lead['ownership-vehicle-4'];
			$data['fourth_vehicle_uses'] 		= $lead['primary-use-vehicle-4'];
			$data['fourth_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-4'];

		}	

		if(isset($lead['vehicle5']) && $lead['vehicle5'] && $lead['miles-driven-per-year-vehicle-5'])
		{
			// $data['fifth_vehicle_year'] 		= ($lead['vehicle-year-5']) ? $lead['vehicle-year-5'] : $lead['vehicle5-year'];
			
			if($lead['vehicle-year-5'] && $lead['vehicle-year-5'] == 'other'){
				$data['fifth_vehicle_year'] = 	$lead['year5-other-input'];
			}elseif($lead['vehicle-year-5']){
				$data['fifth_vehicle_year'] = 	$lead['vehicle-year-5'];
			}else{
				$data['fifth_vehicle_year'] = 	$lead['vehicle5-year'];
			}

			if($lead['vehicle5-make-other']){
				$data['fifth_vehicle_make'] 		= $lead['vehicle5-make-other'];
			}elseif($lead['vehicle5-make-select']){
				$data['fifth_vehicle_make'] 		= $lead['vehicle5-make-select'];
			}else{
				$data['fifth_vehicle_make'] 		= $lead['vehicle5-make'];
			}

			$data['fifth_vehicle_model'] 		= ($lead['model5-other']) ? $lead['model5-other'] : $lead['model-5'];

			if(isset($lead['trim-5'])){
				$trim = $lead['trim-5'];
			}elseif(isset($lead['trim-other-5'])){
				$trim= $lead['trim-other-5'];
			}else{
				$trim = "";	
			}			
			$data['fifth_vehicle_trim'] 		= $trim;
			$data['fifth_vehicle_vin'] 		= $lead['vin5'];
			$data['fifth_vehicle_owenership'] 	= $lead['ownership-vehicle-5'];
			$data['fifth_vehicle_uses'] 		= $lead['primary-use-vehicle-5'];
			$data['fifth_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-5'];

		}

		if(isset($lead['vehicle6']) && $lead['vehicle6'] && $lead['miles-driven-per-year-vehicle-6'])
		{
			// $data['sixth_vehicle_year'] 		= ($lead['vehicle-year-6']) ? $lead['vehicle-year-6'] : $lead['vehicle6-year'];

			if($lead['vehicle-year-6'] && $lead['vehicle-year-6'] == 'other'){
				$data['sixth_vehicle_year'] = 	$lead['year6-other-input'];
			}elseif($lead['vehicle-year-6']){
				$data['sixth_vehicle_year'] = 	$lead['vehicle-year-6'];
			}else{
				$data['sixth_vehicle_year'] = 	$lead['vehicle6-year'];
			}

			if($lead['vehicle6-make-other']){
				$data['sixth_vehicle_make'] 		= $lead['vehicle6-make-other'];
			}elseif($lead['vehicle6-make-select']){
				$data['sixth_vehicle_make'] 		= $lead['vehicle6-make-select'];
			}else{
				$data['sixth_vehicle_make'] 		= $lead['vehicle6-make'];
			}

			$data['sixth_vehicle_model'] 		= ($lead['model6-other']) ? $lead['model6-other'] : $lead['model-6'];
			if(isset($lead['trim-6'])){
				$trim = $lead['trim-6'];
			}elseif(isset($lead['trim-other-6'])){
				$trim= $lead['trim-other-6'];
			}else{
				$trim = "";	
			}			
			$data['sixth_vehicle_trim'] 		= $trim;

			$data['sixth_vehicle_vin'] 		= $lead['vin6'];
			$data['sixth_vehicle_owenership'] 	= $lead['ownership-vehicle-6'];
			$data['sixth_vehicle_uses'] 		= $lead['primary-use-vehicle-6'];
			$data['sixth_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-6'];

		}

		if(isset($lead['vehicle7']) && $lead['vehicle7'] && $lead['miles-driven-per-year-vehicle-7'])
		{
			// $data['seventh_vehicle_year'] 		= ($lead['vehicle-year-7']) ? $lead['vehicle-year-7'] : $lead['vehicle7-year'];
			if($lead['vehicle-year-7'] && $lead['vehicle-year-7'] == 'other'){
				$data['seventh_vehicle_year'] = 	$lead['year7-other-input'];
			}elseif($lead['vehicle-year-7']){
				$data['seventh_vehicle_year'] = 	$lead['vehicle-year-7'];
			}else{
				$data['seventh_vehicle_year'] = 	$lead['vehicle7-year'];
			}			
			if($lead['vehicle7-make-other']){
				$data['seventh_vehicle_make'] 		= $lead['vehicle7-make-other'];
			}elseif($lead['vehicle7-make-select']){
				$data['seventh_vehicle_make'] 		= $lead['vehicle7-make-select'];
			}else{
				$data['seventh_vehicle_make'] 		= $lead['vehicle7-make'];
			}

			$data['seventh_vehicle_model'] 		= ($lead['model7-other']) ? $lead['model7-other'] : $lead['model-7'];
			if(isset($lead['trim-7'])){
				$trim = $lead['trim-7'];
			}elseif(isset($lead['trim-other-7'])){
				$trim= $lead['trim-other-7'];
			}else{
				$trim = "";	
			}			
			$data['seventh_vehicle_trim'] 		= $trim;			
			$data['seventh_vehicle_vin'] 		= $lead['vin7'];
			$data['seventh_vehicle_owenership'] 	= $lead['ownership-vehicle-7'];
			$data['seventh_vehicle_uses'] 		= $lead['primary-use-vehicle-7'];
			$data['seventh_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-7'];

		}

		if(isset($lead['vehicle8']) && $lead['vehicle8'] && $lead['miles-driven-per-year-vehicle-8'])
		{
			// $data['eighth_vehicle_year'] 		= ($lead['vehicle-year-8']) ? $lead['vehicle-year-8'] : $lead['vehicle8-year'];

			if($lead['vehicle-year-8'] && $lead['vehicle-year-8'] == 'other'){
				$data['eighth_vehicle_year'] = 	$lead['year8-other-input'];
			}elseif($lead['vehicle-year-8']){
				$data['eighth_vehicle_year'] = 	$lead['vehicle-year-8'];
			}else{
				$data['eighth_vehicle_year'] = 	$lead['vehicle8-year'];
			}

			if($lead['vehicle8-make-other']){
				$data['eighth_vehicle_make'] 		= $lead['vehicle8-make-other'];
			}elseif($lead['vehicle8-make-select']){
				$data['eighth_vehicle_make'] 		= $lead['vehicle8-make-select'];
			}else{
				$data['eighth_vehicle_make'] 		= $lead['vehicle8-make'];
			}

			$data['eighth_vehicle_model'] 		= ($lead['model8-other']) ? $lead['model8-other'] : $lead['model-8'];

			if(isset($lead['trim-8'])){
				$trim = $lead['trim-8'];
			}elseif(isset($lead['trim-other-8'])){
				$trim= $lead['trim-other-8'];
			}else{
				$trim = "";	
			}			
			$data['eighth_vehicle_trim'] 		= $trim;
			$data['eighth_vehicle_vin'] 		= $lead['vin8'];
			$data['eighth_vehicle_owenership'] 	= $lead['ownership-vehicle-8'];
			$data['eighth_vehicle_uses'] 		= $lead['primary-use-vehicle-8'];
			$data['eighth_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-8'];

		}

		if(isset($lead['vehicle9']) && $lead['vehicle9'] && $lead['miles-driven-per-year-vehicle-9'])
		{
			// $data['ninth_vehicle_year'] 		= ($lead['vehicle-year-9']) ? $lead['vehicle-year-9'] : $lead['vehicle9-year'];
			if($lead['vehicle-year-9'] && $lead['vehicle-year-9'] == 'other'){
				$data['ninth_vehicle_year'] = 	$lead['year9-other-input'];
			}elseif($lead['vehicle-year-9']){
				$data['ninth_vehicle_year'] = 	$lead['vehicle-year-9'];
			}else{
				$data['ninth_vehicle_year'] = 	$lead['vehicle9-year'];
			}			
			if($lead['vehicle9-make-other']){
				$data['ninth_vehicle_make'] 		= $lead['vehicle9-make-other'];
			}elseif($lead['vehicle9-make-select']){
				$data['ninth_vehicle_make'] 		= $lead['vehicle9-make-select'];
			}else{
				$data['ninth_vehicle_make'] 		= $lead['vehicle9-make'];
			}

			$data['ninth_vehicle_model'] 		= ($lead['model9-other']) ? $lead['model9-other'] : $lead['model-9'];

			if(isset($lead['trim-9'])){
				$trim = $lead['trim-9'];
			}elseif(isset($lead['trim-other-9'])){
				$trim= $lead['trim-other-9'];
			}else{
				$trim = "";	
			}			
			$data['ninth_vehicle_trim'] 		= $trim;			
			$data['ninth_vehicle_vin'] 		= $lead['vin9'];
			$data['ninth_vehicle_owenership'] 	= $lead['ownership-vehicle-9'];
			$data['ninth_vehicle_uses'] 		= $lead['primary-use-vehicle-9'];
			$data['ninth_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-9'];

		}

		if(isset($lead['vehicle10']) && $lead['vehicle10'] && $lead['miles-driven-per-year-vehicle-10'])
		{
			// $data['tenth_vehicle_year'] 		= ($lead['vehicle-year-10']) ? $lead['vehicle-year-10'] : $lead['vehicle10-year'];
			if($lead['vehicle-year-10'] && $lead['vehicle-year-10'] == 'other'){
				$data['tenth_vehicle_year'] = 	$lead['year10-other-input'];
			}elseif($lead['vehicle-year-10']){
				$data['tenth_vehicle_year'] = 	$lead['vehicle-year-10'];
			}else{
				$data['tenth_vehicle_year'] = 	$lead['vehicle10-year'];
			}			
			if($lead['vehicle10-make-other']){
				$data['tenth_vehicle_make'] 		= $lead['vehicle10-make-other'];
			}elseif($lead['vehicle10-make-select']){
				$data['tenth_vehicle_make'] 		= $lead['vehicle10-make-select'];
			}else{
				$data['tenth_vehicle_make'] 		= $lead['vehicle10-make'];
			}

			$data['tenth_vehicle_model'] 		= ($lead['model10-other']) ? $lead['model10-other'] : $lead['model-10'];
			if(isset($lead['trim-10'])){
				$trim = $lead['trim-10'];
			}elseif(isset($lead['trim-other-10'])){
				$trim= $lead['trim-other-10'];
			}else{
				$trim = "";	
			}			
			$data['tenth_vehicle_trim'] 		= $trim;
			$data['tenth_vehicle_vin'] 		= $lead['vin10'];
			$data['tenth_vehicle_owenership'] 	= $lead['ownership-vehicle-10'];
			$data['tenth_vehicle_uses'] 		= $lead['primary-use-vehicle-10'];
			$data['tenth_vehicle_mileage'] 	= $lead['miles-driven-per-year-vehicle-10'];

		}										


		$data['liability'] 					= "";
		$data['body_injury'] 				= $lead['bodily-injury'];
		$data['property_damage'] 				= $lead['property-damage'];
		$data['collision_deductible'] 				= $lead['collision-deductible'];
		$data['deduct'] 					= $lead['deductible'];
		$data['medical'] 					= $lead['medical'];
		$data['towing'] 					= $lead['towing'];
		$data['uninsured'] 					= $lead['uninsured'];
		$data['rental'] 					= $lead['rental'];
		$data['previous_insurance'] 		= $lead['previous-insurance'];
		$data['current_insurance'] 			= (isset($lead['current-insurance'])) ? $lead['current-insurance'] : "NA" ;
		$otherInsurance = ($lead['current-insurance-other']) ? ' (' .$lead['current-insurance-other']. ")" : "";
		$data['current_insurance'] = ($data['current_insurance'] == 'Other') ? $data['current_insurance'] . $otherInsurance : $data['current_insurance'];

		$data['duration'] 					= (isset($lead['current-insurance-duration'])) ? $lead['current-insurance-duration'] : "NA";
		$data['at_fault'] 					= $lead['at_fault'];
		$data['tickets'] 					= $lead['tickets'];
		$data['dui'] 						= $lead['dui'];
		$data['quality_provides'] 			= $lead['quality'];
		$data['agent_in_person'] 			= $lead['agent_in_person'];
		$data['referrer'] 		= $lead['referrer'];
		$data['referrer_name'] 				= $lead['referrer_name'];
		$data['ip_address'] 				= $request['ip'];
		if($lead['at_fault'] == 1 || $lead['tickets']  == 1 || $lead['dui'] == 1){
			$data['status'] = 0;
		}
		return Lead::create($data);
	}


	public static function checkAndProcessAffiliateRecord($leadId){
		if(!request()->has('s1') && !request()->has('s2') && !request()->has('s3') && !request()->has('s4') && !request()->has('s5')) return false;

		$s1 = false;
		$s2 = false;
		$s3 = false;
		$s4 = false;
		$s5 = false;
		if(request()->has('s1')) $s1= true;
		if(request()->has('s2')) $s2= true;
		if(request()->has('s3')) $s3= true;
		if(request()->has('s4')) $s4= true;
		if(request()->has('s5')) $s5= true;

		$affiliate = Affiliate::where('s1',$s1)->where('s2',$s2)->where('s3',$s3)->where('s4',$s4)->where('s5',$s5)->first();
		if(!$affiliate) return false;

		$data = [
			'affiliate_id' => $affiliate->id,
			'lead_id' => $leadId,
		];
		if(AffiliateLead::create($data)){
			if(!$affiliate->postback_url || trim($affiliate->postback_url) == "") return false;
			if(request()->has('s1')){
				$redirect = str_replace("{SUBID}", request()->s1, $affiliate->postback_url) ; 
			}
			$redirect = str_replace("{PAYOUT}", $affiliate->payout_amount, $redirect) ; 
			// $redirect =  (strpos($affiliate->postback_url, '?') !== false) ? $affiliate->postback_url . "&payout=".$affiliate->payout_amount : $affiliate->postback_url . "?payout=".$affiliate->payout_amount;
			return $redirect;
		}
		return false;
	}
	public function validateZipcode(Request $request){
		return response()->json(['zipcode' => CommonMethod::getZipcodeInfo(90001)]);
	}
}
