<style>
	.table{max-width: 100%; overflow-x: auto; margin-bottom: 10px; }
	.lead,h2 {
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
		margin-bottom: 10px;
	}

	.lead td, .lead th {
		border: 1px solid #ddd;
		padding: 8px;
	}
	.lead tr:nth-child(even){background-color: #f2f2f2;}
	.lead tr:hover {background-color: #ddd;}
	.lead th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
		background-color: #007bff;
		color: white;
	}
	.lead th span{font-weight: normal;}
	.lead tr.bg-red{background-color: #dc3545;}
	.lead tr.bg-red td{color: #FFF;}
	.lead td.bg-green{color: #fff; background-color: #28a745;}
	.lead td.bg-red{color: #fff; background-color: #dc3545;}
</style>

<div class="table">
	<table class="lead">
		<tr><th colspan="2">CONTACT DETAILS</th></tr>
		<tr><td><strong>Name</strong></td><td>{{$lead['first_name']}} {{$lead['last_name']}}</td></tr>
		<tr><td><strong>Street</strong></td><td>{{$lead['street']}}</td></tr>
		<tr><td><strong>City</strong></td><td>{{$city}},California,{{$lead['zipcode']}}</td></tr>
		<tr><td><strong>Phone</strong></td><td>{{$lead['phone']}}</td></tr>
		<tr><td><strong>Email</strong></td><td>{{$lead['email']}}</td></tr>

		<tr><td><strong>Married</strong></td><td class=@if($lead['married']){{"bg-green"}}@endif>@if($lead['married']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Children</strong></td><td class=@if(isset($lead['children']) && $lead['children']){{"bg-green"}}@endif>@if(isset($lead['children']) && $lead['children']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Homeowner</strong></td><td>{{$lead['homeowner']}}</td></tr>
		<tr><td><strong>Bundled</strong></td><td  class=@if($lead['bundled']){{"bg-green"}}@endif>@if($lead['bundled']){{"Yes"}}@else{{"No"}}@endif</td></tr>
	</table>
</div>
<!-- Drivers Details -->
<div class="table">
	<table class="lead">
		<tr><th colspan="6">DRIVER DETAILS</th></tr>
		<tr>
			<td><strong>#</strong></td>
			<td><strong>Name</strong></td>
			<td><strong>Date of Birth</strong></td>
			<td><strong>Age</strong></td>
			<td><strong>Gender</strong></td>
			<td><strong>Drivers License Number</strong></td>
			<td><strong>State</strong></td>
		</tr>
		<tr>
			<td>1.</td>
			<td>{{$lead['first_name']}} {{$lead['last_name']}}</td> 
			<td>{{$lead['dob']}}</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['dob'])->diffForHumans(null,true) }} old
			</td>
			<td>{{$lead['gender']}}</td>
			<td>{{$lead['dl1']}}</td>
			<td>{{$states[$lead['state1']]}}</td>
		</tr>
		@if($lead['first_name2'])
		<tr>
			<td>2.</td>
			<td>{{$lead['first_name2']}} {{$lead['last_name2']}}</td> 
			<td>{{$lead['dob2']}}</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['dob2'])->diffForHumans(null,true) }} old
			</td>			
			<td>{{$lead['gender-2']}}</td>
			<td>{{$lead['dl2']}}</td>
			<td>{{$states[$lead['state2']]}}</td>
		</tr>
		@endif
		@if($lead['first_name3'])
		<tr>
			<td>3.</td>
			<td>{{$lead['first_name3']}} {{$lead['last_name3']}}</td> 
			<td>{{$lead['dob3']}}</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['dob3'])->diffForHumans(null,true) }} old
			</td>			
			<td>{{$lead['gender-3']}}</td>
			<td>{{$lead['dl3']}}</td>
			<td>{{$states[$lead['state3']]}}</td>
		</tr>
		@endif
		@if($lead['first_name4'])
		<tr>
			<td>4.</td>
			<td>{{$lead['first_name4']}} {{$lead['last_name4']}}</td> 
			<td>{{$lead['dob4']}}</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['dob4'])->diffForHumans(null,true) }} old
			</td>			
			<td>{{$lead['gender-4']}}</td>
			<td>{{$lead['dl4']}}</td>
			<td>{{$states[$lead['state4']]}}</td>
		</tr>
		@endif
		@if($lead['first_name5'])
		<tr>
			<td>5.</td>
			<td>{{$lead['first_name5']}} {{$lead['last_name5']}}</td> 
			<td>{{$lead['dob5']}}</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['dob5'])->diffForHumans(null,true) }} old
			</td>			
			<td>{{$lead['gender-5']}}</td>
			<td>{{$lead['dl5']}}</td>
			<td>{{$states[$lead['state5']]}}</td>
		</tr>
		@endif	
	</table>
</div>
<div class="table">
	<!-- Vehicles Details -->
	<table class="lead">
		<tr><th colspan="9">VEHICLE DETAILS</th></tr>
		<tr>
			<td><strong>#</strong></td>
			<td><strong>Year</strong></td>
			<td><strong>Make</strong></td>
			<td><strong>Model</strong></td>
			<td><strong>Trim</strong></td>
			<td><strong>Vin</strong></td>
			<td><strong>Ownership</strong></td>
			<td><strong>Uses</strong></td>
			<td><strong>Mileage</strong></td>
		</tr>
		<tr>
			<td>1.</td>
			<td>
				@if($lead['vehicle-year'])
				{{$lead['vehicle-year']}}
				@else
				{{$lead['year']}}
				@endif
			</td>
			<td>
				@if($lead['make-other'])
				{{$lead['make-other']}}
				@elseif($lead['make-select'])
				{{$lead['make-select']}}
				@else
				{{$lead['make']}}
				@endif
			</td>
			<td>
				@if($lead['model1-other'])
				{{$lead['model1-other']}}
				@else
				{{$lead['model-1']}}
				@endif
			</td>
			<td>
				@if(isset($lead['trim-1']))
					{{$lead['trim-1']}}
				@endif
			</td>
			<td>{{$lead['vin1']}}</td>
			<td>{{$lead['ownership-vehicle-1']}}</td>
			<td>{{$lead['primary-use-vehicle-1']}}</td>
			<td>{{$lead['miles-driven-per-year-vehicle-1']}}</td>
		</tr>
		@if($lead['vehicle2'] && $lead['miles-driven-per-year-vehicle-2'])
		<tr>
			<td>2.</td>
			<td>
				@if($lead['vehicle-year-2'])
				{{$lead['vehicle-year-2']}}
				@else
				{{$lead['vehicle2-year']}}
				@endif
			</td>
			<td>
				@if($lead['vehicle2-make-other'])
				{{$lead['vehicle2-make-other']}}
				@elseif($lead['vehicle2-make-select'])
				{{$lead['vehicle2-make-select']}}
				@else
				{{$lead['vehicle2-make']}}
				@endif
			</td>
			<td>
				@if($lead['model2-other'])
				{{$lead['model2-other']}}
				@else
				{{$lead['model-2']}}
				@endif
			</td>
			<td>
				@if(isset($lead['trim-2']))
					{{$lead['trim-2']}}
				@endif
			</td>			
			<td>{{$lead['vin2']}}</td>
			<td>{{$lead['ownership-vehicle-2']}}</td>
			<td>{{$lead['primary-use-vehicle-2']}}</td>
			<td>{{$lead['miles-driven-per-year-vehicle-2']}}</td>
		</tr>
		@endif
		@if(isset($lead['vehicle3']) && $lead['vehicle3']  && $lead['miles-driven-per-year-vehicle-3'])
		<tr>
			<td>3.</td>
			<td>
				@if($lead['vehicle-year-3'])
				{{$lead['vehicle-year-3']}}
				@else
				{{$lead['vehicle3-year']}}
				@endif
			</td>
			<td>
				@if($lead['vehicle3-make-other'])
				{{$lead['vehicle3-make-other']}}
				@elseif($lead['vehicle3-make-select'])
				{{$lead['vehicle3-make-select']}}
				@else
				{{$lead['vehicle3-make']}}
				@endif
			</td>
			<td>
				@if($lead['model3-other'])
				{{$lead['model3-other']}}
				@else
				{{$lead['model-3']}}
				@endif
			</td>
			<td>
				@if(isset($lead['trim-3']))
					{{$lead['trim-3']}}
				@endif
			</td>			
			<td>{{$lead['vin3']}}</td>
			<td>{{$lead['ownership-vehicle-3']}}</td>
			<td>{{$lead['primary-use-vehicle-3']}}</td>
			<td>{{$lead['miles-driven-per-year-vehicle-3']}}</td>
		</tr>
		@endif
		@if(isset($lead['vehicle4']) && $lead['vehicle4']  && $lead['miles-driven-per-year-vehicle-4'])
		<tr>
			<td>4.</td>
			<td>
				@if($lead['vehicle-year-4'])
				{{$lead['vehicle-year-4']}}
				@else
				{{$lead['vehicle4-year']}}
				@endif
			</td>
			<td>
				@if($lead['vehicle4-make-other'])
				{{$lead['vehicle4-make-other']}}
				@elseif($lead['vehicle4-make-select'])
				{{$lead['vehicle4-make-select']}}
				@else
				{{$lead['vehicle4-make']}}
				@endif
			</td>
			<td>
				@if($lead['model4-other'])
				{{$lead['model4-other']}}
				@else
				{{$lead['model-4']}}
				@endif
			</td>
			<td>
				@if(isset($lead['trim-4']))
					{{$lead['trim-4']}}
				@endif
			</td>			
			<td>{{$lead['vin4']}}</td>
			<td>{{$lead['ownership-vehicle-4']}}</td>
			<td>{{$lead['primary-use-vehicle-4']}}</td>
			<td>{{$lead['miles-driven-per-year-vehicle-4']}}</td>
		</tr>
		@endif
		@if(isset($lead['vehicle5']) && $lead['vehicle5']  && $lead['miles-driven-per-year-vehicle-5'])
		<tr>
			<td>5.</td>
			<td>
				@if($lead['vehicle-year-5'])
				{{$lead['vehicle-year-5']}}
				@else
				{{$lead['vehicle5-year']}}
				@endif
			</td>
			<td>
				@if($lead['vehicle5-make-other'])
				{{$lead['vehicle5-make-other']}}
				@elseif($lead['vehicle5-make-select'])
				{{$lead['vehicle5-make-select']}}
				@else
				{{$lead['vehicle5-make']}}
				@endif
			</td>
			<td>
				@if($lead['model5-other'])
				{{$lead['model5-other']}}
				@else
				{{$lead['model-5']}}
				@endif
			</td>
			<td>
				@if(isset($lead['trim-5']))
					{{$lead['trim-5']}}
				@endif
			</td>			
			<td>{{$lead['vin5']}}</td>
			<td>{{$lead['ownership-vehicle-5']}}</td>
			<td>{{$lead['primary-use-vehicle-5']}}</td>
			<td>{{$lead['miles-driven-per-year-vehicle-5']}}</td>
		</tr>
		@endif
	</table>
</div>
<!-- Coverage Details -->
<div class="table">
	<table class="lead">
		<tr><th colspan="2">COVERAGE DETAILS:</th></tr>
		<tr><td><strong>Liability</strong></td><td>NA</td></tr>
		<tr><td><strong>Body Injury ($)</strong></td><td>{{$lead['bodily-injury']}}</td></tr>
		<tr><td><strong>Deduct ($)</strong></td><td>{{$lead['deductible']}}</td></tr>
		<tr><td><strong>Medical ($)</strong></td><td>{{$lead['medical']}}</td></tr>
		<tr><td><strong>Towing</strong></td><td>@if($lead['towing']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Uninsured</strong></td><td>@if($lead['uninsured']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Rental</strong></td><td>@if($lead['rental']){{"Yes"}}@else{{"No"}}@endif</td></tr>
	</table>
</div>
<!-- History Details -->
<div class="table">
	<table class="lead">
		<tr><th colspan="2">HISTORY DETAILS</th></tr>
		<tr>
			<td><strong>Previous Insurance</strong></td>
			<td class=@if(!$lead['previous-insurance']){{"bg-red"}}@endif>@if($lead['previous-insurance']){{"Yes"}}@else{{"No"}}@endif</td>
		</tr>
		<tr>
			<td><strong>Current Insurance</strong></td>
			<td>@if(isset($lead['current-insurance'])){{$lead['current-insurance']}}@else{{"NA"}}@endif</td>
		</tr>
		<tr>
			<td><strong>Duration</strong></td>
			<td>@if(isset($lead['current-insurance-duration'])){{$lead['current-insurance-duration']}} Years @else{{"NA"}}@endif</td>
		</tr>
		<tr >
			<td><strong>At Fault</strong></td>
			<td @if($lead["at_fault"]) class="bg-red" @endif>@if($lead['at_fault']){{"Yes"}}@else{{"No"}}@endif</td>
		</tr>
		<tr>
			<td><strong>Tickets</strong></td>
			<td @if($lead["tickets"]) class="bg-red" @endif>@if($lead['tickets']){{"Yes"}}@else{{"No"}}@endif</td>
		</tr>
		<tr>
			<td><strong>DUI</strong></td>
			<td @if($lead["dui"]) class="bg-red" @endif>@if($lead['dui']){{"Yes"}}@else{{"No"}}@endif</td>
		</tr>
	</table>
</div>
<!-- Preference Details: -->
<div class="table">
	<table class="lead">
		<tr><th colspan="2">PREFERENCE DETAILS:</th></tr>
		<tr><td><strong>Quality Provides</strong></td><td>{!! ucwords(str_replace('-', ' ', $lead['quality'])) !!}</td></tr>
		<tr><td><strong>Agent In Person</strong></td><td>@if($lead['agent_in_person']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Referrer</strong></td><td>{{$lead['referrer']}}</td></tr>
		<tr><td><strong>Referrer Name</strong></td><td>{{$lead['referrer_name']}}</td></tr>
	</table>
</div>
<div class="table">
	<table class="lead">
		<th>
			<strong>IP:</strong>
			<span>{{$ip}}</span>
		</th>
		<th>
			<strong>DATE:</strong>
			<span>{{ now()->format('Y M d') }}</span>
		</th>
		<th>
			<strong>TIME:</strong>
			<span>{{ now()->format('h:i:s A') }}</span>
		</th>
	</table>
</div>