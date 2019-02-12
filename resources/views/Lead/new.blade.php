@extends('Layouts.frontend')
@push('scripts')
<script type="text/javascript">
	var zipcodes = @json($zipcodes);
	var carModels = @json($carModels);
</script>
@endpush
@section('content')
<form class="lead-form" action="{{route('save-lead')}}" method="POST">
	{{ csrf_field() }}
	<div id="zipcode-container" class="container pt-5 pb-5">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<div class="form-group">
					<label for="zipcode" class="font-weight-bold h3 mb-3">Compare Your Cheapest Car Insurance Rates</label>
					<input type="text" class="form-control form-control-lg text-center" id="zipcode" name="zipcode" placeholder="Enter Your Zipcode">
				</div>
				<div class="form-group">
					<a data-href="year" data-pos="1" class="zipcode-submit btn btn-lg btn-warning btn-block change-question">Get Your Quotes</a>
				</div>
			</div>
		</div>
	</div>
	<div id="year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-12 col-md-10 offset-md-1">
				<p>
					<a data-href="zipcode" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle</h3>
				<h4 class="mb-2">Year</h4>
				<div class="form-group choices row">
					@for ($i = 0; $i < 40; $i++)
					<label for="year-{{ now()->year - $i }}" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="make" data-current="year">
						{{ now()->year - $i }}
						<input type="radio" class="d-none" name="year" value="{{ now()->year - $i }}" id="year-{{ now()->year - $i }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
			</div>
		</div>
	</div>
	<div id="make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle <span class="h4">- Make</span></h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">
							@foreach ($carMakes['popular'] as $k => $popular)
							<label for="make-{{$loop->iteration}}" class="h4 col-12 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="models" data-current="make" data-vehicle="1">
								{{$popular}}
								<input type="radio" class="d-none" name="make" value="{{$k}}" id="make-{{$loop->iteration}}" />
								<i class="fa fa-angle-right"></i>
							</label>
							@endforeach
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="form-control form-control-lg" name="make-select">
								@foreach ($carMakes['all'] as $k => $make)
								<option value="{{$k}}">{{$make}}</option>
								@endforeach
								<option value="other">Other</option>
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="1">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="models-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="make" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle</h3>
				<h4 class="mb-2">Model</h4>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group choices row models-1"></div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="model1-other" class="h4">Other</label>
							<input type="text" class="form-control form-control-lg mb-3 optional" name="model1-other" id="model1-other">
							<a data-href="vin1" class="vehicle-next btn btn-lg btn-warning" data-vehicle="1">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="vin1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="vin1" id="vin">
							<a data-href="vehicle2" data-current="vin1"  class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="vehicle2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Add Second Vehicle? (Save Additional 20%)</h4>
				<div class="form-group choices row">
					<label for="vehicle2-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="vehicle2-year" data-current="vehicle2">
						Yes
						<input type="radio" class="d-none" name="vehicle2" value="1" id="vehicle2-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="vehicle2-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle2" >
						No
						<input type="radio" class="d-none" name="vehicle2" value="0" id="vehicle2-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle2-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle</h3>
				<h4 class="mb-2">Year</h4>
				<div class="form-group choices row">
					@for ($i = 0; $i < 40; $i++)
					<label for="vehicle2-year-{{ now()->year - $i }}" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="vehicle2-make" data-current="vehicle2-year">
						{{ now()->year - $i }}
						<input type="radio" class="d-none" name="vehicle2-year" value="{{ now()->year - $i }}" id="vehicle2-year-{{ now()->year - $i }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle2-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle <span class="h4">- Make</span></h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">
							@foreach ($carMakes['popular'] as $k => $popular)
							<label for="vehicle2-make-{{$loop->iteration}}" class="h4 col-12 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="vehicle2-models" data-current="vehicle2-make" data-vehicle="2">
								{{$popular}}
								<input type="radio" class="d-none" name="vehicle2-make" value="{{$k}}" id="vehicle2-make-{{$loop->iteration}}" />
								<i class="fa fa-angle-right"></i>
							</label>
							@endforeach
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="form-control form-control-lg" name="vehicle2-make-select">
								@foreach ($carMakes['all'] as $k => $make)
								<option value="{{$k}}">{{$make}}</option>
								@endforeach
								<option value="other">Other</option>
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle2-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle2-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="2">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle2-models-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle2-make" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle</h3>
				<h4 class="mb-2">Model</h4>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group choices row models-2"></div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="model2-other" class="h4">Other</label>
							<input type="text" class="form-control form-control-lg mb-3 optional" name="model2-other" id="model2-other">
							<a data-href="vin2" class="vehicle-next btn btn-lg btn-warning" data-vehicle="2">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="vin2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle2-models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="vin2">
							<a data-href="previous-insurance" data-current="vin2"  class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="previous-insurance-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Have you had auto insurance in the past 30 days?</h4>
				<div class="form-group choices row">
					<label for="vehicle2-yes" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="current-insurance" data-current="previous-insurance">
						Yes
						<input type="radio" class="d-none" name="previous-insurance" value="1" id="previous-insurance-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="vehicle2-yes" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="married" data-current="previous-insurance">
						No
						<input type="radio" class="d-none" name="previous-insurance" value="0" id="previous-insurance-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="current-insurance-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Current Auto Insurance</h4>
				<div class="form-group choices row">
					@foreach ($insuranceComp as $company)
					<label for="company-{{$loop->iteration}}" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="current-insurance-duration" data-current="current-insurance">
						{{$company}}
						<input type="radio" class="d-none" name="current-insurance" value="{{$company}}" id="company-{{$loop->iteration}}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endforeach					
				</div>
			</div>
		</div>
	</div>	
	<div id="current-insurance-duration-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">How long have you continuously had auto insurance?</h4>
				<div class="form-group choices row">
					<label for="duration-1" class="h4 col-12 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="married" data-current="current-insurance-duration">
						Less than a year
						<input type="radio" class="d-none" name="current-insurance-duration" value="0-1" id="duration-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="duration-2" class="h4 col-12 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="married" data-current="current-insurance-duration">
						1 to 2 years
						<input type="radio" class="d-none" name="current-insurance-duration" value="1-2" id="duration-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="duration-3" class="h4 col-12 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="married" data-current="current-insurance-duration">
						2 to 3 years
						<input type="radio" class="d-none" name="current-insurance-duration" value="2-3" id="duration-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="duration-4" class="h4 col-12 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="married" data-current="current-insurance-duration">
						4+ years
						<input type="radio" class="d-none" name="current-insurance-duration" value="4+" id="duration-4" />
						<i class="fa fa-angle-right"></i>
					</label>		
				</div>
			</div>
		</div>
	</div>
	<!-- Not Showing for now-->
	<div id="gender-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Gender?</h4>
				<div class="form-group choices row">
					<label for="gender-male" class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" data-href="married" data-current="gender">
						Male
						<input type="radio" class="d-none" name="gender" value="male" id="gender-male" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="gender-female" class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" data-href="married" data-current="gender">
						Female
						<input type="radio" class="d-none" name="gender" value="female" id="gender-female" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="gender-non-binary" class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" data-href="married" data-current="gender">
						Non-Binary
						<input type="radio" class="d-none" name="gender" value="non-binary" id="gender-non-binary" />
						<i class="fa fa-angle-right"></i>
					</label>												
				</div>
			</div>
		</div>
	</div>

	<div id="married-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Married?</h4>
				<div class="form-group choices row">
					<label for="married-yes" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="homeowner" data-current="married">
						Yes
						<input type="radio" class="d-none" name="married" value="1" id="married-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="married-no" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="homeowner" data-current="married">
						No
						<input type="radio" class="d-none" name="married" value="0" id="married-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>

	<!-- Not showing for now  -->
	<div id="credit-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Credit Score?</h4>
				<div class="form-group choices row">
					<label for="credit-1" class="h4 col-6 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2" data-href="homeowner" data-current="credit">
						Not Sure (that's okay!)
						<input type="radio" class="d-none" name="credit" value="0" id="credit-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="credit-2" class="h4 col-6 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2" data-href="homeowner" data-current="credit">
						Poor (below 580)
						<input type="radio" class="d-none" name="credit" value="1-579" id="credit-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="credit-3" class="h4 col-6 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2" data-href="homeowner" data-current="credit">
						Fair/Average (580-679)
						<input type="radio" class="d-none" name="credit" value="580-679" id="credit-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="credit-4" class="h4 col-6 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2" data-href="homeowner" data-current="credit">
						Good (680-719)
						<input type="radio" class="d-none" name="credit" value="680-719" id="credit-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="credit-5" class="h4 col-6 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2" data-href="homeowner" data-current="credit">
						Excellent (720+)
						<input type="radio" class="d-none" name="credit" value="720+" id="credit-5" />
						<i class="fa fa-angle-right"></i>
					</label>															
				</div>
			</div>
		</div>
	</div>

	<div id="homeowner-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Do you own/rent?</h4>
				<div class="form-group choices row">
					<label for="owner" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="owner-bundled" data-current="homeowner">
						Own
						<input type="radio" class="d-none" name="homeowner" value="owner" id="owner" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="renter" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="renter-bundled" data-current="homeowner">
						Rent
						<input type="radio" class="d-none" name="homeowner" value="renter" id="renter" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="owner-bundled-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Would you like to also receive home insurance policy quotes? You may be able to bundle and save even more on your auto policy.</h4>
				<div class="form-group choices row">
					<label for="bundled-1" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="policy-detail" data-current="owner-bundled">
						Yes
						<input type="radio" class="d-none" name="bundled" value="1" id="bundled-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="bundled-2" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="policy-detail" data-current="owner-bundled">
						No
						<input type="radio" class="d-none" name="bundled" value="0" id="bundled-2" />
						<i class="fa fa-angle-right"></i>
					</label>	
				</div>
			</div>
		</div>
	</div>
	<div id="renter-bundled-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Would you like to also receive renters insurance policy quotes? You may be able to bundle and save even more on your auto policy.</h4>
				<div class="form-group choices row">
					<label for="bundled-1" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="policy-detail" data-current="renter-bundled">
						Yes
						<input type="radio" class="d-none" name="bundled" value="1" id="bundled-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="bundled-2" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="policy-detail" data-current="renter-bundled">
						No
						<input type="radio" class="d-none" name="bundled" value="0" id="bundled-2" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div id="policy-detail-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Has anyone on this policy had:</h4>

				<h4 class="mb-2">
					An at-fault accident in the past <strong>three (3) years?</strong>
				</h4>
				<div class="form-group choices row">
					<label for="at-fault-yes" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="at_fault" value="1" id="at-fault-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="at-fault-no" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2 bg-warning">
						No
						<input type="radio" class="d-none" name="at_fault" value="0" id="at-fault-no" checked="checked" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>

				<h4 class="mb-2">
					<strong>Two (2) or more tickets</strong> in the past <strong>three (3) years?</strong>
				</h4>
				<div class="form-group choices row">
					<label for="tickets-yes" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="tickets" value="1" id="tickets-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="tickets-no" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2 bg-warning">
						No
						<input type="radio" class="d-none" name="tickets" value="0" id="tickets-no" checked="checked" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>

				<h4 class="mb-2">
					A DUI conviction in the past <strong>three (3) years?</strong>
				</h4>
				<div class="form-group choices row">
					<label for="dui-yes" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="dui" value="1" id="dui-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="dui-no" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2 bg-warning">
						No
						<input type="radio" class="d-none" name="dui" value="0" id="dui-no" checked="checked" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>
				<div class="form-group row">
					<a data-href="extra"  data-current="policy-detail" class="next-question btn btn-lg btn-warning">CONTINUE</a>
				</div>								
			</div>
		</div>
	</div>

	<div id="extra-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-2">Uninsured</h4>						
						<div class="form-group choices row">
							<label for="at-fault-yes" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 bg-warning">
								Yes
								<input type="radio" class="d-none" name="uninsured" value="1" id="at-fault-yes"  checked="checked"  />
								<i class="fa fa-angle-right"></i>
							</label>
							<label for="at-fault-no" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2">
								No
								<input type="radio" class="d-none" name="uninsured" value="0" id="at-fault-no"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>
						<h4 class="mb-2">Towing</h4>						
						<div class="form-group choices row">
							<label for="at-fault-yes" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 bg-warning">
								Yes
								<input type="radio" class="d-none" name="towing" value="1" id="at-fault-yes"  checked="checked"  />
								<i class="fa fa-angle-right"></i>
							</label>
							<label for="at-fault-no" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 ">
								No
								<input type="radio" class="d-none" name="towing" value="0" id="at-fault-no"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>
						<h4 class="mb-2">Rental</h4>						
						<div class="form-group choices row">
							<label for="at-fault-yes" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 bg-warning">
								Yes
								<input type="radio" class="d-none" name="rental" value="1" id="at-fault-yes"  checked="checked"  />
								<i class="fa fa-angle-right"></i>
							</label>
							<label for="at-fault-no" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 ">
								No
								<input type="radio" class="d-none" name="rental" value="0" id="at-fault-no"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>												
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label class="h4">Bodily Injury</label>
							<select class="form-control form-control-lg" name="bodily-injury">
								<option value="15-30">$15/$30</option>
								<option value="25-50">$25/$50</option>
								<option value="30-60">$30/$60</option>
								<option value="50-100">$50/$100</option>
								<option value="100-200">$100/$200</option>
								<option value="250-500">$250/$500</option>
							</select>
						</div>						
						<div class="form-group">
							<label class="h4">Deductible</label>
							<select class="form-control form-control-lg" name="deductible">
								<option value="250">$250</option>
								<option value="500">$500</option>
								<option value="1000">$1000</option>
							</select>
						</div>						
						<div class="form-group">
							<label class="h4">Medical</label>
							<select class="form-control form-control-lg" name="bodily-injury">
								<option value="0">$0</option>
								<option value="5000">$5000</option>
								<option value="10000">$10000</option>
							</select>
						</div>						
					</div>					
				</div>
				<div class="form-group row">
					<a data-href="referral" data-current="extra" class="next-question btn btn-lg btn-warning">CONTINUE</a>
				</div>								
			</div>
		</div>
	</div>

	<div id="referral-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">				
						<div class="form-group">
							<label class="h4">What is the most important quality you look for when choosing an auto insurer?</label>
							<select class="form-control form-control-lg" name="quality">
								<option value="provides-quality-service">Provides quality service</option>
								<option value="guidance-with-insurance-decisions">Guidance with insurance decisions</option>
								<option value="provides-a-local-presence">Provides a local presence</option>
								<option value="is-a-reputable-company">Is a reputable company</option>
								<option value="provides-general-representatives-for-customer-care">Provides general representatives for customer care</option>
								<option value="offers-a-low-price-and-discounts">Offers a low price and discounts</option>
								<option value="provides-24/7-access-to-insurance-information">Provides 24/7 access to insurance information</option>
								<option value="provides-an-accountable-point-of-contact">Provides an accountable point of contact</option>
								<option value="offers-a-thorough-review-of-the-coverage">Offers a thorough review of the coverage</option>
								<option value="provides-hassle-free-process">Provides hassle-free process</option>
								<option value="offers-face-to-face-interaction">Offers face-to-face interaction</option>
							</select>
						</div>
						<h4 class="mb-2">Will it be important to you to be able to speak to your local agent in person?</h4>						
						<div class="form-group choices row">
							<label for="at-fault-yes" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 bg-warning">
								Yes
								<input type="radio" class="d-none" name="agent_in_person" value="1" id="at-fault-yes"  checked="checked"  />
								<i class="fa fa-angle-right"></i>
							</label>
							<label for="at-fault-no" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 ">
								No
								<input type="radio" class="d-none" name="agent_in_person" value="0" id="at-fault-no"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>

					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label class="h4">How did you hear about us?</label>
							<select class="form-control form-control-lg" name="referrer">
								<option value="friend-or-family">Friend or Family</option>
								<option value="auto-dealer">Auto Dealer</option>
								<option value="other">Other</option>
							</select>
						</div>						
						<div class="form-group">
							<label class="h4">Referrer Name</label>
							<input type="text" name="referrer_name" class="form-control form-control-lg">
						</div>						
					</div>					
				</div>
				<div class="form-group row">
					<a data-href="dob-month" data-current="referral" class="next-question btn btn-lg btn-warning">CONTINUE</a>
				</div>								
			</div>
		</div>
	</div>


	<div id="dob-month-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Birth Month</h3>
				<div class="form-group months row">
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						January
						<input type="radio" class="d-none" name="dob_month" value="1"/>
						<i class="fa fa-angle-right"></i>
					</label>
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						February
						<input type="radio" class="d-none" name="dob_month" value="2"/>
						<i class="fa fa-angle-right"></i>
					</label>
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						March
						<input type="radio" class="d-none" name="dob_month" value="3"/>
						<i class="fa fa-angle-right"></i>
					</label>
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						April
						<input type="radio" class="d-none" name="dob_month" value="4"/>
						<i class="fa fa-angle-right"></i>
					</label>															
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						May
						<input type="radio" class="d-none" name="dob_month" value="5"/>
						<i class="fa fa-angle-right"></i>
					</label>															
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						June
						<input type="radio" class="d-none" name="dob_month" value="6"/>
						<i class="fa fa-angle-right"></i>
					</label>															
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						July
						<input type="radio" class="d-none" name="dob_month" value="7"/>
						<i class="fa fa-angle-right"></i>
					</label>															
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						August
						<input type="radio" class="d-none" name="dob_month" value="8"/>
						<i class="fa fa-angle-right"></i>
					</label>															
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						September
						<input type="radio" class="d-none" name="dob_month" value="9"/>
						<i class="fa fa-angle-right"></i>
					</label>															
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						October
						<input type="radio" class="d-none" name="dob_month" value="10"/>
						<i class="fa fa-angle-right"></i>
					</label>															
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						November
						<input type="radio" class="d-none" name="dob_month" value="11"/>
						<i class="fa fa-angle-right"></i>
					</label>															
					<label class="h4 col-6 col-sm-4 col-md-3 col-lg-2 pl-2 pr-2" >
						December
						<input type="radio" class="d-none" name="dob_month" value="12"/>
						<i class="fa fa-angle-right"></i>
					</label>															
				</div>
			</div>
		</div>
	</div>	
	<div id="dob-date-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dob-month" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Birth Date</h3>
				<div class="form-group">
					<input type="hidden" name="dob_date" id="dob_date">
					<div id="dob_picker"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="dob-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dob-date" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="col-3 col-xs-12">
					<div class="form-group">
						<label for="dob_year" class="font-weight-bold h3 mb-3 text-warning">Birth Year</label>
						<input type="text" class="form-control form-control-lg" id="dob_year" name="dob_year" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-3">
						<a class="dob-year-submit btn btn-lg btn-warning next-question">CONTINUE</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="name-email-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dob-year" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-6 col-xs-12 ">
						<div class="form-group">
							<label for="first_name" class="font-weight-bold h5 mb-3 text-warning">First Name</label>
							<input type="text" class="form-control form-control-lg" id="first_name" name="first_name">
						</div>
					</div>
					<div class="col-6 col-xs-12">
						<div class="form-group">
							<label for="last_name" class="font-weight-bold h5 mb-3 text-warning">Last Name</label>
							<input type="text" class="form-control form-control-lg" id="last_name" name="last_name">
						</div>
					</div>
					<div class="col-6 col-xs-12">
						<div class="form-group">
							<label for="email" class="font-weight-bold h5 mb-3 text-warning">Email</label>
							<input type="text" class="form-control form-control-lg" id="email" name="email">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-3">
							<a class="name-email-submit btn btn-lg btn-warning next-question">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="last-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name-email" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12"><h3><span class="first-name-label"></span>, Last Step!</h3></div>
				</div>
				<div class="row">
					<div class="col-6 col-xs-12 ">
						<div class="form-group">
							<label for="street" class="font-weight-bold h5 mb-3 text-warning">Street Address</label>
							<input type="text" class="form-control form-control-lg" id="street" name="street">
						</div>
					</div>
					<div class="col-6 col-xs-12">
						<div class="form-group">
							<label for="phone" class="font-weight-bold h5 mb-3 text-warning">Phone Number</label>
							<input type="text" class="form-control form-control-lg" id="phone" name="phone">
						</div>
					</div>
					<div class="col-12 col-xs-12">
						<label class="h4 font-weight-bold text-warning">LOS ANGELES, CA 90001</label>
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<a href="javascript:;" class="final-submit btn btn-lg btn-block btn-success">Get My Auto Quotes</a>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						By clicking "Get My Auto Quotes" I provide my electronic signature and express written consent to telemarketing calls, text messages, emails, and postal mail from this Web site, our marketing and re-marketing network, and up to eight insurance companies or their affiliates at the phone number (including wireless number), email address, and postal address provided by me. I consent to calls and text messages transmitting insurance quotes, or seeking related additional information from me, using an Automatic Telephone Dialing System or prerecorded or artificial voices. I understand that my signature is not a condition of purchasing any property, goods, or services and that I may revoke my consent at any time. Additionally, by clicking "Get My Auto Quotes," I acknowledge that I have read, understand, and agree to this Web site’s <a href="">Privacy Policy.</a> 
					</div>
				</div>
			</div>
		</div>
	</div>		
</form>
@endsection