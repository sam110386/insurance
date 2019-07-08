<style>
	.table{font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;max-width: 100%; overflow-x: auto; background-color: #FFF; padding: 15px; border:1px solid #cfcfcf; margin-bottom: 20px;}
	.lead-view,h2 {
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
		margin-bottom: 15px;
	}

	.lead-view td, .lead-view th {
		border: 1px solid #ddd;
		padding: 8px;
	}
	.lead-view tr:nth-child(even){background-color: #f2f2f2;}
	.lead-view tr:hover {background-color: #ddd;}
	.lead-view th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
		background-color: #007bff;
		color: white;
	}
	.lead-view th span{font-weight: normal;}
	.lead-view tr.bg-red{background-color: #dc3545;}
	.lead-view tr.bg-red td{color: #FFF;}
	.lead-view td.bg-green{color: #fff; background-color: #28a745;}
	.lead-view td.bg-red{color: #fff; background-color: #dc3545;}
	.mb-10{margin-bottom: 10px;}
	.alert{padding: 15px; margin-bottom: 10px;}
	.alert-success.light-bg {
		color: #3c763d !important;
		background-color: #dff0d8 !important;
		border-color: #d6e9c6;
	}	
	.alert-danger.light-bg {
		color: #a94442 !important;
		background-color: #f2dede !important;
		border-color: #ebccd1;
	}
	.p-10{padding: 10px;}

	.comment-wrapper .media-list .media img {
		width:64px;
		height:64px;
		border:2px solid #e5e7e8;
	}

	.comment-wrapper .media-list .media {
		border-bottom:1px dashed #efefef;
		margin-bottom:25px;
	}
	.pull-right{float: right;}
	.panel-primary > .panel-heading {
		color: #fff;
		background-color: #337ab7;
		border-color: #337ab7;
	}
	.panel-heading {
		padding: 10px 15px;
		border-bottom: 1px solid transparent;
		border-bottom-color: transparent;
		border-top-left-radius: 3px;
		border-top-right-radius: 3px;
	}
	.panel {
		margin-bottom: 20px;
		background-color: #fff;
		border: 1px solid transparent;
		border-top-color: transparent;
		border-right-color: transparent;
		border-bottom-color: transparent;
		border-left-color: transparent;
		border-radius: 4px;
		-webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
		box-shadow: 0 1px 1px rgba(0,0,0,.05);
	}	
	.panel-primary {border-color: #337ab7;}
	.media-list {list-style: none; padding-left: 0;}
	.panel-body {padding: 15px;}	
</style>

<div class="table">
	<table class="lead-view">
		<tr><th colspan="2">CONTACT DETAILS</th></tr>
		<tr><td><strong>Name</strong></td><td>{{$lead['first_name']}} {{$lead['last_name']}}</td></tr>
		<tr><td><strong>Street</strong></td><td>{{$lead['street']}}</td></tr>
		<tr><td><strong>City</strong></td><td>{{$lead['city']}},California,{{$lead['zip']}}</td></tr>
		<tr><td><strong>Phone</strong></td><td>{{$lead['phone']}}</td></tr>
		<tr><td><strong>Email</strong></td><td>{{$lead['email']}}</td></tr>

		<tr><td><strong>Married</strong></td><td class=@if($lead['married']){{"bg-green"}}@endif>@if($lead['married']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Children</strong></td><td class=@if(isset($lead['children']) && $lead['children']){{"bg-green"}}@endif>@if(isset($lead['children']) && $lead['children']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Homeowner</strong></td><td>{{$lead['homeowner']}}</td></tr>
		<tr><td><strong>Bundled</strong></td><td  class=@if($lead['bundled']){{"bg-green"}}@endif>@if($lead['bundled']){{"Yes"}}@else{{"No"}}@endif</td></tr>
	</table>
	<!-- Drivers Details -->
	<table class="lead-view">
		<tr><th colspan="7">DRIVER DETAILS</th></tr>
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
			<td>{{$lead['first_driver_first_name']}} {{$lead['first_driver_last_name']}}</td> 
			<td>
				{{date('m-d-Y', strtotime($lead['first_driver_dob']))}}
			</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['first_driver_dob'])->diffForHumans(null,true) }} old
			</td>
			<td>{{$lead['first_driver_gender']}}</td>
			<td>{{$lead['first_driver_dl']}}</td>
			<td>{{$lead['first_driver_state']}}</td>
		</tr>
		@if($lead['second_driver_first_name'])
		<tr>
			<td>2.</td>
			<td>{{$lead['second_driver_first_name']}} {{$lead['second_driver_last_name']}}</td> 
			<td>
				{{date('m-d-Y', strtotime($lead['second_driver_dob']))}}
			</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['second_driver_dob'])->diffForHumans(null,true) }} old
			</td>
			<td>{{$lead['second_driver_gender']}}</td>
			<td>{{$lead['second_driver_dl']}}</td>
			<td>{{$lead['second_driver_state']}}</td>
		</tr>
		@endif	
		@if($lead['third_driver_first_name'])
		<tr>
			<td>3.</td>
			<td>{{$lead['third_driver_first_name']}} {{$lead['third_driver_last_name']}}</td> 
			<td>
				{{date('m-d-Y', strtotime($lead['third_driver_dob']))}}
			</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['third_driver_dob'])->diffForHumans(null,true) }} old
			</td>
			<td>{{$lead['third_driver_gender']}}</td>
			<td>{{$lead['third_driver_dl']}}</td>
			<td>{{$lead['third_driver_state']}}</td>
		</tr>
		@endif
		@if($lead['fourth_driver_first_name'])
		<tr>
			<td>4.</td>
			<td>{{$lead['fourth_driver_first_name']}} {{$lead['fourth_driver_last_name']}}</td> 
			<td>
				{{date('m-d-Y', strtotime($lead['fourth_driver_dob']))}} <br>
			</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['fourth_driver_dob'])->diffForHumans(null,true) }} old
			</td>
			<td>{{$lead['fourth_driver_gender']}}</td>
			<td>{{$lead['fourth_driver_dl']}}</td>
			<td>{{$lead['fourth_driver_state']}}</td>
		</tr>
		@endif
		@if($lead['fifth_driver_first_name'])
		<tr>
			<td>5.</td>
			<td>{{$lead['fifth_driver_first_name']}} {{$lead['fifth_driver_last_name']}}</td> 
			<td>
				{{date('m-d-Y', strtotime($lead['fifth_driver_dob']))}} <br>
			</td>
			<td>
				{{ $diff = Carbon\Carbon::parse($lead['fifth_driver_dob'])->diffForHumans(null,true) }} old
			</td>	
			<td>{{$lead['fifth_driver_gender']}}</td>
			<td>{{$lead['fifth_driver_dl']}}</td>
			<td>{{$lead['fifth_driver_state']}}</td>
		</tr>
		@endif							
	</table>
	<!-- Vehicles Details -->
	<table class="lead-view">
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
			<td>{{$lead['first_vehicle_year']}}</td>
			<td>{{$lead['first_vehicle_make']}}</td>
			<td>{{$lead['first_vehicle_model']}}</td>
			<td>{{$lead['first_vehicle_trim']}}</td>
			<td>{{$lead['first_vehicle_vin']}}</td>
			<td>{{$lead['first_vehicle_owenership']}}</td>
			<td>{{$lead['first_vehicle_uses']}}</td>
			<td>{{$lead['first_vehicle_mileage']}}</td>
		</tr>
		@if($lead['second_vehicle_year'])
		<tr>
			<td>2.</td>
			<td>{{$lead['second_vehicle_year']}}</td>
			<td>{{$lead['second_vehicle_make']}}</td>
			<td>{{$lead['second_vehicle_model']}}</td>
			<td>{{$lead['second_vehicle_trim']}}</td>
			<td>{{$lead['second_vehicle_vin']}}</td>
			<td>{{$lead['second_vehicle_owenership']}}</td>
			<td>{{$lead['second_vehicle_uses']}}</td>
			<td>{{$lead['second_vehicle_mileage']}}</td>
		</tr>
		@endif
		@if($lead['third_vehicle_year'])
		<tr>
			<td>3.</td>
			<td>{{$lead['third_vehicle_year']}}</td>
			<td>{{$lead['third_vehicle_make']}}</td>
			<td>{{$lead['third_vehicle_model']}}</td>
			<td>{{$lead['third_vehicle_trim']}}</td>
			<td>{{$lead['third_vehicle_vin']}}</td>
			<td>{{$lead['third_vehicle_owenership']}}</td>
			<td>{{$lead['third_vehicle_uses']}}</td>
			<td>{{$lead['third_vehicle_mileage']}}</td>
		</tr>
		@endif
		@if($lead['fourth_vehicle_year'])
		<tr>
			<td>4.</td>
			<td>{{$lead['fourth_vehicle_year']}}</td>
			<td>{{$lead['fourth_vehicle_make']}}</td>
			<td>{{$lead['fourth_vehicle_model']}}</td>
			<td>{{$lead['fourth_vehicle_trim']}}</td>
			<td>{{$lead['fourth_vehicle_vin']}}</td>
			<td>{{$lead['fourth_vehicle_owenership']}}</td>
			<td>{{$lead['fourth_vehicle_uses']}}</td>
			<td>{{$lead['fourth_vehicle_mileage']}}</td>
		</tr>
		@endif		
		@if($lead['fifth_vehicle_year'])
		<tr>
			<td>5.</td>
			<td>{{$lead['fifth_vehicle_year']}}</td>
			<td>{{$lead['fifth_vehicle_make']}}</td>
			<td>{{$lead['fifth_vehicle_model']}}</td>
			<td>{{$lead['fifth_vehicle_trim']}}</td>
			<td>{{$lead['fifth_vehicle_vin']}}</td>
			<td>{{$lead['fifth_vehicle_owenership']}}</td>
			<td>{{$lead['fifth_vehicle_uses']}}</td>
			<td>{{$lead['fifth_vehicle_mileage']}}</td>
		</tr>
		@endif		
	</table>
	<!-- Coverage Details -->
	<table class="lead-view">
		<tr><th colspan="2">COVERAGE DETAILS:</th></tr>
		<tr><td><strong>Bodily Injury Liability</strong></td><td>$<?= str_replace("-","k-$",$lead['body_injury']) ?>k</td></tr>
		<tr><td><strong>Comprehensive Deductible</strong></td><td>${{$lead['deduct']}}</td></tr>
		<tr><td><strong>Medical Coverage</strong></td><td>${{$lead['medical']}}</td></tr>
		<tr><td><strong>Road Side &amp; Towing</strong></td><td>@if($lead['towing']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Uninsured Motorist</strong></td><td>@if($lead['uninsured']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Rental Car</strong></td><td>@if($lead['rental']){{"Yes"}}@else{{"No"}}@endif</td></tr>
	</table>

	<!-- History Details -->
	<table class="lead-view">
		<tr><th colspan="2">HISTORY DETAILS</th></tr>
		<tr>
			<td><strong>Previous Insurance</strong></td>
			<td class=@if(!$lead['previous_insurance']){{"bg-red"}}@endif>@if($lead['previous_insurance']){{"Yes"}}@else{{"No"}}@endif</td>
		</tr>
		<tr>
			<td><strong>Current Insurance</strong></td>
			<td>{{$lead['current_insurance']}}</td>
		</tr>
		<tr>
			<td><strong>Duration</strong></td>
			<td>@if(isset($lead['duration'])){{$lead['duration']}}Years @else{{"NA"}}@endif</td>
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
	<!-- Preference Details: -->
	<table class="lead-view">
		<tr><th colspan="2">PREFERENCE DETAILS:</th></tr>
		<tr><td><strong>Quality Provides</strong></td><td>{!! ucwords(str_replace('-', ' ', $lead['quality_provides'])) !!}</td></tr>
		<tr><td><strong>Agent In Person</strong></td><td>@if($lead['agent_in_person']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Referrer</strong></td><td>{!! ucwords(str_replace('-', ' ', $lead['referrer'])) !!}</td></tr>
		<tr><td><strong>Referrer Name</strong></td><td>{{$lead['referrer_name']}}</td></tr>
	</table>
	<table class="lead-view">
		<th>
			<strong>IP:</strong>
			<span>{{$lead['ip_address']}}</span>
		</th>
		<th>
			<strong>DATE:</strong>
			<span>{{ $lead['created_at']->format('Y M d') }}</span>
		</th>
		<th>
			<strong>TIME:</strong>
			<span>{{ $lead['created_at']->format('h:i:s A') }}</span>
		</th>
	</table>
	
	<!-- RISK HTML START -->
	@if($lead['status'] === 1)
	<div class="alert alert-success light-bg fa-lg" role="alert">
		<strong><i class="fa fa-check"></i> Low Risk</strong> 
	</div>
	@elseif($lead['status'] ===0)
	<div class="alert alert-danger light-bg fa-lg" role="alert">
		<strong><i class="fa fa-warning"></i> High Risk</strong>
	</div>
	@endif
	<!-- RISK HTML END -->

	<!-- NOTES HTML START -->
	<div class="row bootstrap snippets">
		<div class="col-md-12 ">
			<div class="comment-wrapper">
				<div class="panel panel-primary">
					<div class="panel-heading bg-primary">
						<i class="fa fa-stack-exchange"></i> Admin Notes.
						<span class="pull-right"> Total Notes {{count($lead->notes)}}</span>
					</div>
					<div class="panel-body">
						<ul class="media-list">
							@if(count($lead->notes))
							@foreach($lead->notes as $note)
							<li class="media">
								<div class="media-body">
									<span class="text-muted pull-right">
										<small class="text-muted">
											{{$note->created_at->diffForHumans()}}
										</small>
									</span>
									<strong class="text-success">{{$note->user->name}}</strong>@<strong>{{$note->user_ip}}</strong>
									<p>{!! $note->notes !!}</p>
								</div>
							</li>
							@endforeach
							@else
							<li>No note found.</li>
							@endif
						</ul>						
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- NOTES HTML END -->
</div>