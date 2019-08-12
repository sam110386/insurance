<div class="table">
	<div class="row mb-10">
		<div class="col-xs-12 text-right">
			@if($updateStatus)
				<div class="pull-left">
					<form class="form-inline" action="{{route('lead.currentstatus.update',$lead['id'])}}" method="post">
						{!! csrf_field() !!}
						<div class="form-group">
							<select class="form-control" name="current_status">
								<option value="0" @if($lead['current_status']==0) selected @endif>New</option>
								<option value="1" @if($lead['current_status']==1) selected @endif>Processing</option>
								<option value="2" @if($lead['current_status']==2) selected @endif>Sold</option>
								<option value="3" @if($lead['current_status']==3) selected @endif>Not Eligible</option>
							</select>&nbsp;
							<input class="btn btn-primary" type="submit" name="submit" value="Update Status">
						</div>
					</form>
				</div>			
				<form action="{{route('lead.status.update',$lead['id'])}}" method="post">
					@if($lead['status'] === null)
					{!! csrf_field() !!}
					<input type="submit" name="approve" class="btn btn-success text-uppercase" value="Low Risk" />&nbsp;
					<input type="submit" name="deny" class="btn btn-danger text-uppercase" value="High Risk" />&nbsp;
					@endif
					<a href="{{route('leads.index')}}" class="btn btn-info "><i class="fa fa-list"></i> LIST</a>&nbsp;
					<a href="{{route('leads.edit',$lead['id'])}}" class="btn btn-default"><i class="fa fa-edit"></i> EDIT</a>					
				</form>
			@else
				<a href="{{route('leads.index')}}" class="btn btn-info "><i class="fa fa-list"></i> LIST</a>&nbsp;
			@endif
		</div>
	</div>
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
	<table class="lead-view">
		<tr><th colspan="2">CONTACT DETAILS</th></tr>
		<tr><td><strong>Name</strong></td><td>{{$lead['first_name']}} {{$lead['last_name']}}</td></tr>
		<tr><td><strong>Street</strong></td><td>{{$lead['street']}}</td></tr>
		<tr><td><strong>City</strong></td><td>{{$lead['city']}}, CA {{$lead['zip']}}</td></tr>
		<tr><td><strong>Phone</strong></td><td>{{$lead->phoneNumber($lead['phone'])}}</td></tr>
		<tr><td><strong>Email</strong></td><td><a href="mailto:{{$lead['email']}}">{{$lead['email']}}</a></td></tr>

		<tr><td><strong>Married</strong></td><td class=@if($lead['married']){{"bg-green"}}@endif>@if($lead['married']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Children</strong></td><td class=@if(isset($lead['children']) && $lead['children']){{"bg-green"}}@endif>@if(isset($lead['children']) && $lead['children']){{"Yes"}}@else{{"No"}}@endif</td></tr>
		<tr><td><strong>Homeowner</strong></td><td>@if($lead['homeowner'] == 'owner') Home Owner @else Renter @endif</td></tr>
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
				{{date('m-d-Y', strtotime($lead['fourth_driver_dob']))}}
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
				{{date('m-d-Y', strtotime($lead['fifth_driver_dob']))}}
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
		@if($lead['sixth_vehicle_year'])
		<tr>
			<td>6.</td>
			<td>{{$lead['sixth_vehicle_year']}}</td>
			<td>{{$lead['sixth_vehicle_make']}}</td>
			<td>{{$lead['sixth_vehicle_model']}}</td>
			<td>{{$lead['sixth_vehicle_trim']}}</td>
			<td>{{$lead['sixth_vehicle_vin']}}</td>
			<td>{{$lead['sixth_vehicle_owenership']}}</td>
			<td>{{$lead['sixth_vehicle_uses']}}</td>
			<td>{{$lead['sixth_vehicle_mileage']}}</td>
		</tr>
		@endif
		@if($lead['seventh_vehicle_year'])
		<tr>
			<td>7.</td>
			<td>{{$lead['seventh_vehicle_year']}}</td>
			<td>{{$lead['seventh_vehicle_make']}}</td>
			<td>{{$lead['seventh_vehicle_model']}}</td>
			<td>{{$lead['seventh_vehicle_trim']}}</td>
			<td>{{$lead['seventh_vehicle_vin']}}</td>
			<td>{{$lead['seventh_vehicle_owenership']}}</td>
			<td>{{$lead['seventh_vehicle_uses']}}</td>
			<td>{{$lead['seventh_vehicle_mileage']}}</td>
		</tr>
		@endif
		@if($lead['eighth_vehicle_year'])
		<tr>
			<td>8.</td>
			<td>{{$lead['eighth_vehicle_year']}}</td>
			<td>{{$lead['eighth_vehicle_make']}}</td>
			<td>{{$lead['eighth_vehicle_model']}}</td>
			<td>{{$lead['eighth_vehicle_trim']}}</td>
			<td>{{$lead['eighth_vehicle_vin']}}</td>
			<td>{{$lead['eighth_vehicle_owenership']}}</td>
			<td>{{$lead['eighth_vehicle_uses']}}</td>
			<td>{{$lead['eighth_vehicle_mileage']}}</td>
		</tr>
		@endif
		@if($lead['ninth_vehicle_year'])
		<tr>
			<td>9.</td>
			<td>{{$lead['ninth_vehicle_year']}}</td>
			<td>{{$lead['ninth_vehicle_make']}}</td>
			<td>{{$lead['ninth_vehicle_model']}}</td>
			<td>{{$lead['ninth_vehicle_trim']}}</td>
			<td>{{$lead['ninth_vehicle_vin']}}</td>
			<td>{{$lead['ninth_vehicle_owenership']}}</td>
			<td>{{$lead['ninth_vehicle_uses']}}</td>
			<td>{{$lead['ninth_vehicle_mileage']}}</td>
		</tr>
		@endif
		@if($lead['tenth_vehicle_year'])
		<tr>
			<td>10.</td>
			<td>{{$lead['tenth_vehicle_year']}}</td>
			<td>{{$lead['tenth_vehicle_make']}}</td>
			<td>{{$lead['tenth_vehicle_model']}}</td>
			<td>{{$lead['tenth_vehicle_trim']}}</td>
			<td>{{$lead['tenth_vehicle_vin']}}</td>
			<td>{{$lead['tenth_vehicle_owenership']}}</td>
			<td>{{$lead['tenth_vehicle_uses']}}</td>
			<td>{{$lead['tenth_vehicle_mileage']}}</td>
		</tr>
		@endif
	</table>
	<!-- Coverage Details -->
	<table class="lead-view">
		<tr><th colspan="2">COVERAGE DETAILS:</th></tr>
		<tr><td><strong>Bodily Injury Liability</strong></td><td>$<?= str_replace("-","k-$",$lead['body_injury']) ?>k</td></tr>
		<tr><td><strong>Property Damage</strong></td><td>${{($lead['property_damage']) ? $lead['property_damage'] : 0}}</td></tr>

		<tr><td><strong>Comprehensive Deductible</strong></td><td>${{$lead['deduct']}}</td></tr>
		<tr><td><strong>Collision Deductible</strong></td><td>${{($lead['collision_deductible']) ? $lead['collision_deductible'] : 0 }}</td></tr>		

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
			<td>@if(isset($lead['duration'])){{$lead['duration']}} Years @else{{"NA"}}@endif</td>
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
										<div class="media-left">
											<img class="media-object img-circle" src="{{Storage::disk('admin')->url(($note->user->avatar) ? $note->user->avatar : 'images/default-user.png' )}}" alt="...">
										</div>
										<div class="media-body">
											<span class="text-muted pull-right">
												<small class="text-muted">
													{{$note->created_at->diffForHumans()}}
												</small>
											</span>
											<strong class="text-success">
												{{$note->user->name}}
											</strong> &nbsp;&nbsp;&nbsp; 
											@if($showIp)
											<strong><i class="fa fa-map-marker"></i> {{$note->user_ip}}</strong>
											@endif
											<p>{!! $note->notes !!}</p>
										</div>
									</li>
								@endforeach
							@else
							<li>No note found.</li>
							@endif
						</ul>
						@if($addNotes)
						<form action="{{route('lead.notes.add',$lead['id'])}}" method="POST">
							<div class="form-group">
								{!! csrf_field() !!}
								<label for="note">Add Notes</label>
								<textarea id="note" name="notes" class="form-control editor" rows="3" placeholder="Enter notes..." required ></textarea>				
							</div>
							@if ($errors->any())
							{!! implode('', $errors->all('<p class="text-danger">:message</p>')) !!}
							@endif				
							<button type="submit" class="btn btn-primary">SAVE NOTES</button>
						</form>		
						@endif				
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- NOTES HTML END -->
</div>
<script>
	setTimeout(function(){
    	CKEDITOR.replace('note',{height:150,removeButtons: ''});
	},1000)
</script>