@extends('Layouts.frontend')
@push('scripts')
<script type="text/javascript">
	var zipcodes = @json($zipcodes);
	var years = @json($years);
</script>
@endpush
@section('content')
<div class="row pt-3 pb-3 progress-container">
<!-- 	<div class="col-12">
		<h4 class="text-center">Progress</h4>
	</div> -->
	<div class="col-12 text-center">
		<div class="q-progress">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
				</tr>
			</table>
		</div>
	</div>
</div>
<form class="lead-form row" action="{{route('save-lead')}}" method="POST" novalidate>
	{{ csrf_field() }}
	<div id="zipcode-container" class="step container pt-5 pb-5 editable-field" style="display: block;">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<div class="form-group">
					<!--label for="zipcode" class="font-weight-bold h3 mb-3">Enter your zip code to start this short and easy process.</label-->
					<input type="number" class="form-control form-control-lg text-center" id="zipcode" name="zipcode" placeholder="ZIP Code" pattern="[0-9]*">
				</div>
				<div class="form-group">
					<a data-href="year" data-pos="1" class="zipcode-submit mb-2 btn btn-lg btn-warning pull-left change-question">Get Your Quotes</a>

					<!--a data-href="#" class="mb-2 btn btn-lg btn-warning ">Empezar</a-->
				</div>
			</div>
		</div>
	</div>
	<div id="year-container" class=" container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-12 col-md-10 offset-md-1">
				<p>
					<a data-href="zipcode" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="make" data-current="year" data-year="{{ $years[$i]->year }}" data-vehicle="1" data-models="models" data-make="make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="year" value="{{ $years[$i]->year }}" id="year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="make" data-current="year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle-year"  data-vehicle="1" data-models="models" data-make="make">CONTINUE</a>
				</div>
				@endif
			</div>
		</div>
	</div>
	<div id="make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="make-select">
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="1">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search m-0" name="model1-other" id="model1-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims1" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="1">CONTINUE</a>
						</div>
						<div class="form-group choices row models-1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="trims1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin1" id="vin">
							<a data-href="ownership1" data-current="vin1"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership1" data-current="vin1"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="ownership1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin1" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership1-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary1" data-current="ownership1">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-1" value="Owned" id="ownership1-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership1-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary1" data-current="ownership1" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-1" value="Financed" id="ownership1-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership1-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary1" data-current="ownership1" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-1" value="Leased" id="ownership1-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin1" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary1-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven1" data-current="primary1">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-1" value="Commute" id="primary1-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary1-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven1" data-current="primary1" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-1" value="Pleasure" id="primary1-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary1-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven1" data-current="primary1" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-1" value="Business" id="primary1-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary1-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven1" data-current="primary1" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-1" value="Farm" id="primary1-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven1-container" class="container pt-5 pb-5 editable-field" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin1" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven1-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="Less than 5,000" id="miles-driven1-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven1-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="5,000-10,000" id="miles-driven1-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven1-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="10,000-15,000" id="miles-driven1-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven1-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="15,000-20,000" id="miles-driven1-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven1-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="More than 20,000" id="miles-driven1-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	

	<div id="vehicle2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle? (Save an Additional 20%)</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle2-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle2-year" data-current="vehicle2">
						Yes
						<input type="radio" class="d-none" name="vehicle2" value="1" id="vehicle2-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1 col-md-1"></span>
					<label for="vehicle2-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle2" >
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
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle2-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle2-make" data-current="vehicle2-year" data-year="{{ $years[$i]->year }}" data-vehicle="2" data-models="vehicle2-models" data-make="vehicle2-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle2-year" value="{{ $years[$i]->year }}" id="vehicle2-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-2">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle2-make" data-current="vehicle2-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle2-year"  data-vehicle="2" data-models="vehicle2-models" data-make="vehicle2-make">CONTINUE</a>
				</div>
				@endif				
			</div>
		</div>
	</div>
	<div id="vehicle2-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle2-make-select">
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle2-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle2-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="2">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle2-models-container" class="container  vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle2-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model2-other" id="model2-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims2" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="2">CONTINUE</a>
						</div>
						<div class="form-group choices row models-2"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle2-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-2"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin2">
							<a data-href="ownership2" data-current="vin2"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership2" data-current="vin2"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership2-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary2" data-current="ownership2">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-2" value="Owned" id="ownership2-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership2-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary2" data-current="ownership2" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-2" value="Financed" id="ownership2-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership2-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary2" data-current="ownership2" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-2" value="Leased" id="ownership2-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary2-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven2" data-current="primary2">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-2" value="Commute" id="primary2-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary2-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven2" data-current="primary2" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-2" value="Pleasure" id="primary2-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary2-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven2" data-current="primary2" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-2" value="Business" id="primary2-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary2-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven2" data-current="primary2" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-2" value="Farm" id="primary2-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven2-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="Less than 5,000" id="miles-driven2-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven2-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="5,000-10,000" id="miles-driven2-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven2-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="10,000-15,000" id="miles-driven2-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven2-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="15,000-20,000" id="miles-driven2-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven2-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="More than 20,000" id="miles-driven2-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>

	<!-- 3 VEHICLE START -->
	<div id="vehicle3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle3-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle3-year" data-current="vehicle3">
						Yes
						<input type="radio" class="d-none" name="vehicle3" value="1" id="vehicle3-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle3-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle3" >
						No
						<input type="radio" class="d-none" name="vehicle3" value="0" id="vehicle3-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle3-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Third Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle3-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle3-make" data-current="vehicle3-year" data-year="{{ $years[$i]->year }}" data-vehicle="3" data-models="vehicle3-models" data-make="vehicle3-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle3-year" value="{{ $years[$i]->year }}" id="vehicle3-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-3">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle3-make" data-current="vehicle3-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle3-year" data-vehicle="3" data-models="vehicle3-models" data-make="vehicle3-make" >CONTINUE</a>
				</div>
				@endif					
			</div>
		</div>
	</div>
	<div id="vehicle3-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Third Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">

						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle3-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle3-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle3-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="3">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle3-models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle3-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Third Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model3-other" id="model3-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims3" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="3">CONTINUE</a>
						</div>
						<div class="form-group choices row models-3"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle3-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-3"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin3">
							<a data-href="ownership3" data-current="vin3"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership3" data-current="vin3"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership3-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary3" data-current="ownership3">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-3" value="Owned" id="ownership3-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership3-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary3" data-current="ownership3" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-3" value="Financed" id="ownership3-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership3-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary3" data-current="ownership3" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-3" value="Leased" id="ownership3-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary3-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven3" data-current="primary3">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-3" value="Commute" id="primary3-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary3-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven3" data-current="primary3" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-3" value="Pleasure" id="primary3-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary3-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven3" data-current="primary3" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-3" value="Business" id="primary3-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary3-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven3" data-current="primary3" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-3" value="Farm" id="primary3-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven3-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="Less than 5,000" id="miles-driven3-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven3-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="5,000-10,000" id="miles-driven3-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven3-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="10,000-15,000" id="miles-driven3-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven3-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="15,000-20,000" id="miles-driven3-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven3-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="More than 20,000" id="miles-driven3-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	

	<!-- 3 VEHICLE END -->	
	<!-- 4 VEHICLE START -->
	<div id="vehicle4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle4-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle4-year" data-current="vehicle4">
						Yes
						<input type="radio" class="d-none" name="vehicle4" value="1" id="vehicle4-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle4-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle4" >
						No
						<input type="radio" class="d-none" name="vehicle4" value="0" id="vehicle4-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle4-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fourth Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle4-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle4-make" data-current="vehicle4-year" data-year="{{ $years[$i]->year }}" data-vehicle="4" data-models="vehicle4-models" data-make="vehicle4-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle4-year" value="{{ $years[$i]->year }}" id="vehicle4-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-4">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle4-make" data-current="vehicle4-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle4-year" data-vehicle="4" data-models="vehicle4-models" data-make="vehicle4-make" >CONTINUE</a>
				</div>
				@endif			
			</div>
		</div>
	</div>
	<div id="vehicle4-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fourth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-4">POPULAR</h4>
						<div class="form-group choices row">
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-4">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle4-make-select">
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle4-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle4-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="4">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle4-models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle4-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fourth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model4-other" id="model4-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims4" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="4">CONTINUE</a>
						</div>
						<div class="form-group choices row models-4"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle4-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-4"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims4" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-4 not-required" name="vin4">
							<a data-href="ownership4" data-current="vin4"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership4" data-current="vin4"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin4" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership4-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary4" data-current="ownership4">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-4" value="Owned" id="ownership4-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership4-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary4" data-current="ownership4" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-4" value="Financed" id="ownership4-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership4-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary4" data-current="ownership4" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-4" value="Leased" id="ownership4-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership4" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary4-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven4" data-current="primary4">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-4" value="Commute" id="primary4-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary4-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven4" data-current="primary4" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-4" value="Pleasure" id="primary4-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary4-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven4" data-current="primary4" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-4" value="Business" id="primary4-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary4-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven4" data-current="primary4" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-4" value="Farm" id="primary4-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary4" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven4-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="Less than 5,000" id="miles-driven4-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven4-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="5,000-10,000" id="miles-driven4-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven4-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="10,000-15,000" id="miles-driven4-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven4-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="15,000-20,000" id="miles-driven4-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven4-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="More than 20,000" id="miles-driven4-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	
	<!-- 4 VEHICLE END -->
	<!-- 5 VEHICLE START -->
	<div id="vehicle5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle?</h4>
				<div class="form-group choices row pr-15 pl-15">
					<label for="vehicle5-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle5-year" data-current="vehicle5">
						Yes
						<input type="radio" class="d-none" name="vehicle5" value="1" id="vehicle5-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle5-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle5" >
						No
						<input type="radio" class="d-none" name="vehicle5" value="0" id="vehicle5-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle5-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fifth Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle5-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle5-make" data-current="vehicle5-year" data-year="{{ $years[$i]->year }}" data-vehicle="5" data-models="vehicle5-models" data-make="vehicle5-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle5-year" value="{{ $years[$i]->year }}" id="vehicle5-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-5">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle5-make" data-current="vehicle5-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle5-year" data-vehicle="5" data-models="vehicle5-models" data-make="vehicle5-make" >CONTINUE</a>
				</div>
				@endif			
			</div>
		</div>
	</div>
	<div id="vehicle5-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fifth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-5">POPULAR</h4>
						<div class="form-group choices row">
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-5">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle5-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle5-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle5-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="5">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle5-models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle5-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fifth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model5-other" id="model5-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims5" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="5">CONTINUE</a>
						</div>
						<div class="form-group choices row models-5"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle5-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-5"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims5" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-5 not-required" name="vin5">
							<a data-href="ownership5" data-current="vin5"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership5" data-current="vin5"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin4" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership5-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary5" data-current="ownership5">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-5" value="Owned" id="ownership5-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership5-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary5" data-current="ownership5" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-5" value="Financed" id="ownership5-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership5-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary5" data-current="ownership5" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-5" value="Leased" id="ownership5-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership5" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary5-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven5" data-current="primary5">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-5" value="Commute" id="primary5-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary5-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven5" data-current="primary5" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-5" value="Pleasure" id="primary5-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary5-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven5" data-current="primary5" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-5" value="Business" id="primary5-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary5-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven5" data-current="primary5" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-5" value="Farm" id="primary5-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary5" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven5-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="Less than 5,000" id="miles-driven5-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven5-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="5,000-10,000" id="miles-driven5-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven5-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="10,000-15,000" id="miles-driven5-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven5-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="15,000-20,000" id="miles-driven5-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven5-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="More than 20,000" id="miles-driven5-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	
	<!-- 5 VEHICLE END -->
	<!-- 6 VEHICLE START -->
	<div id="vehicle6-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="miles-driven5" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle6-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle6-year" data-current="vehicle6">
						Yes
						<input type="radio" class="d-none" name="vehicle6" value="1" id="vehicle6-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle6-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle6" >
						No
						<input type="radio" class="d-none" name="vehicle6" value="0" id="vehicle6-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle6-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Sixth Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle6-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle6-make" data-current="vehicle6-year" data-year="{{ $years[$i]->year }}" data-vehicle="6" data-models="vehicle6-models" data-make="vehicle6-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle6-year" value="{{ $years[$i]->year }}" id="vehicle6-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-6">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle6-make" data-current="vehicle6-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle6-year" data-vehicle="6" data-models="vehicle6-models" data-make="vehicle6-make" >CONTINUE</a>
				</div>
				@endif					
			</div>
		</div>
	</div>
	<div id="vehicle6-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Sixth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">

						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle6-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle6-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle6-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="6">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle6-models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle6-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Sixth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model6-other" id="model6-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims6" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="6">CONTINUE</a>
						</div>
						<div class="form-group choices row models-6"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims6-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle6-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-6"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin6-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin6">
							<a data-href="ownership6" data-current="vin6"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership6" data-current="vin6"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership6-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership6-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary6" data-current="ownership6">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-6" value="Owned" id="ownership6-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership6-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary6" data-current="ownership6" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-6" value="Financed" id="ownership6-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership6-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary6" data-current="ownership6" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-6" value="Leased" id="ownership6-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary6-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership6" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary6-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven6" data-current="primary6">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-6" value="Commute" id="primary6-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary6-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven6" data-current="primary6" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-6" value="Pleasure" id="primary6-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary6-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven6" data-current="primary6" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-6" value="Business" id="primary6-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary6-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven6" data-current="primary6" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-6" value="Farm" id="primary6-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven6-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary6" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven6-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="Less than 5,000" id="miles-driven6-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven6-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="5,000-10,000" id="miles-driven6-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven6-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="10,000-15,000" id="miles-driven6-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven6-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="15,000-20,000" id="miles-driven6-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven6-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="More than 20,000" id="miles-driven6-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	

	<!-- 6 VEHICLE END -->
	<!-- 7 VEHICLE START -->
	<div id="vehicle7-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="miles-driven6" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle7-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle7-year" data-current="vehicle7">
						Yes
						<input type="radio" class="d-none" name="vehicle7" value="1" id="vehicle7-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle7-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle7" >
						No
						<input type="radio" class="d-none" name="vehicle7" value="0" id="vehicle7-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle7-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Seventh Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle7-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle7-make" data-current="vehicle7-year" data-year="{{ $years[$i]->year }}" data-vehicle="7" data-models="vehicle7-models" data-make="vehicle7-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle7-year" value="{{ $years[$i]->year }}" id="vehicle7-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-7">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle7-make" data-current="vehicle7-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle7-year" data-vehicle="7" data-models="vehicle7-models" data-make="vehicle7-make" >CONTINUE</a>
				</div>
				@endif					
			</div>
		</div>
	</div>
	<div id="vehicle7-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Seventh Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">

						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle7-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle7-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle7-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="7">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle7-models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle7-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Seventh Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model7-other" id="model7-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims7" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="7">CONTINUE</a>
						</div>
						<div class="form-group choices row models-7"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims7-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle7-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-7"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin7-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin7">
							<a data-href="ownership7" data-current="vin7"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership7" data-current="vin7"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership7-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership7-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary7" data-current="ownership7">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-7" value="Owned" id="ownership7-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership7-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary7" data-current="ownership7" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-7" value="Financed" id="ownership7-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership7-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary7" data-current="ownership7" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-7" value="Leased" id="ownership7-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary7-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership7" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary7-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven7" data-current="primary7">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-7" value="Commute" id="primary7-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary7-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven7" data-current="primary7" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-7" value="Pleasure" id="primary7-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary7-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven7" data-current="primary7" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-7" value="Business" id="primary7-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary7-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven7" data-current="primary7" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-7" value="Farm" id="primary7-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven7-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary7" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven7-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="Less than 5,000" id="miles-driven7-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven7-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="5,000-10,000" id="miles-driven7-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven7-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="10,000-15,000" id="miles-driven7-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven7-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="15,000-20,000" id="miles-driven7-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven7-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="More than 20,000" id="miles-driven7-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	

	<!-- 7 VEHICLE END -->	
	<!-- 8 VEHICLE START -->
	<div id="vehicle8-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="miles-driven7" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle8-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle8-year" data-current="vehicle8">
						Yes
						<input type="radio" class="d-none" name="vehicle8" value="1" id="vehicle8-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle8-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle8" >
						No
						<input type="radio" class="d-none" name="vehicle8" value="0" id="vehicle8-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle8-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Eighth Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle8-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle8-make" data-current="vehicle8-year" data-year="{{ $years[$i]->year }}" data-vehicle="8" data-models="vehicle8-models" data-make="vehicle8-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle8-year" value="{{ $years[$i]->year }}" id="vehicle8-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-8">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle8-make" data-current="vehicle8-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle8-year" data-vehicle="8" data-models="vehicle8-models" data-make="vehicle8-make" >CONTINUE</a>
				</div>
				@endif					
			</div>
		</div>
	</div>
	<div id="vehicle8-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Eighth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">

						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle8-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle8-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle8-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="8">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle8-models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle8-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Eighth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model8-other" id="model8-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims8" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="8">CONTINUE</a>
						</div>
						<div class="form-group choices row models-8"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims8-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle8-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-8"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin8-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin8">
							<a data-href="ownership8" data-current="vin8"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership8" data-current="vin8"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership8-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership8-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary8" data-current="ownership8">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-8" value="Owned" id="ownership8-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership8-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary8" data-current="ownership8" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-8" value="Financed" id="ownership8-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership8-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary8" data-current="ownership8" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-8" value="Leased" id="ownership8-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary8-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership8" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary8-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven8" data-current="primary8">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-8" value="Commute" id="primary8-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary8-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven8" data-current="primary8" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-8" value="Pleasure" id="primary8-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary8-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven8" data-current="primary8" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-8" value="Business" id="primary8-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary8-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven8" data-current="primary8" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-8" value="Farm" id="primary8-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven8-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary8" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven8-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="Less than 5,000" id="miles-driven8-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven8-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="5,000-10,000" id="miles-driven8-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven8-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="10,000-15,000" id="miles-driven8-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven8-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="15,000-20,000" id="miles-driven8-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven8-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="More than 20,000" id="miles-driven8-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	

	<!-- 8 VEHICLE END -->	
	<!-- 9 VEHICLE START -->
	<div id="vehicle9-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="miles-driven8" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle9-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle9-year" data-current="vehicle9">
						Yes
						<input type="radio" class="d-none" name="vehicle9" value="1" id="vehicle9-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle9-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle9" >
						No
						<input type="radio" class="d-none" name="vehicle9" value="0" id="vehicle9-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle9-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Ninth Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle9-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle9-make" data-current="vehicle9-year" data-year="{{ $years[$i]->year }}" data-vehicle="9" data-models="vehicle9-models" data-make="vehicle9-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle9-year" value="{{ $years[$i]->year }}" id="vehicle9-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-9">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle9-make" data-current="vehicle9-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle9-year" data-vehicle="9" data-models="vehicle9-models" data-make="vehicle9-make" >CONTINUE</a>
				</div>
				@endif					
			</div>
		</div>
	</div>
	<div id="vehicle9-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Ninth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">

						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle9-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle9-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle9-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="9">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle9-models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle9-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Ninth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model9-other" id="model9-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims9" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="9">CONTINUE</a>
						</div>
						<div class="form-group choices row models-9"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims9-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle9-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-9"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin9-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin9">
							<a data-href="ownership9" data-current="vin9"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership9" data-current="vin9"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership9-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership9-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary9" data-current="ownership9">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-9" value="Owned" id="ownership9-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership9-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary9" data-current="ownership9" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-9" value="Financed" id="ownership9-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership9-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary9" data-current="ownership9" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-9" value="Leased" id="ownership9-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary9-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership9" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary9-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven9" data-current="primary9">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-9" value="Commute" id="primary9-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary9-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven9" data-current="primary9" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-9" value="Pleasure" id="primary9-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary9-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven9" data-current="primary9" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-9" value="Business" id="primary9-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary9-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven9" data-current="primary9" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-9" value="Farm" id="primary9-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven9-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary9" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven9-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="Less than 5,000" id="miles-driven9-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven9-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="5,000-10,000" id="miles-driven9-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven9-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="10,000-15,000" id="miles-driven9-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven9-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="15,000-20,000" id="miles-driven9-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven9-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="More than 20,000" id="miles-driven9-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	

	<!-- 9 VEHICLE END -->	
	<!-- 10 VEHICLE START -->
	<div id="vehicle10-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="miles-driven9" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Add Additional Vehicle?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle10-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle10-year" data-current="vehicle10">
						Yes
						<input type="radio" class="d-none" name="vehicle10" value="1" id="vehicle10-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle10-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle10" >
						No
						<input type="radio" class="d-none" name="vehicle10" value="0" id="vehicle10-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle10-year-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Tenth Vehicle Year</h3>
				<div class="form-group choices row get-make">
					@php
						$yearLoop  = (count($years) > 20) ? 20 : $yearCount - 1 ; 
					@endphp
					@for ($i = 0; $i < $yearLoop; $i++)
					<label for="vehicle10-year-{{ $years[$i]->year }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle10-make" data-current="vehicle10-year" data-year="{{ $years[$i]->year }}" data-vehicle="10" data-models="vehicle10-models" data-make="vehicle10-make">
						{{ $years[$i]->year }}
						<input type="radio" class="d-none" name="vehicle10-year" value="{{ $years[$i]->year }}" id="vehicle10-year-{{ $years[$i]->year }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				@if(count($years) > 20)
				<div class="form-group">
					<h3>OTHER</h3>
					<select class="auto-select form-control optional form-control-lg col-12 col-md-6" name="vehicle-year-10">
						<option value="">Choose one</option>
						@for ($i = 20; $i < count($years); $i++)
						<option value="{{ $years[$i]->year }}">{{ $years[$i]->year }}</option>
						@endfor
					</select>
					<a data-href="vehicle10-make" data-current="vehicle10-year" class="mt-4 year-select-next btn btn-lg btn-warning" data-type="select" data-name="vehicle10-year" data-vehicle="10" data-models="vehicle10-models" data-make="vehicle10-make" >CONTINUE</a>
				</div>
				@endif					
			</div>
		</div>
	</div>
	<div id="vehicle10-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Tenth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">

						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="auto-select form-control form-control-lg" name="vehicle10-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle10-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle10-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="10">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle10-models-container" class="container vehicle-models pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle10-make" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Tenth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model10-other" id="model10-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
							<a data-href="trims10" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="10">CONTINUE</a>
						</div>
						<div class="form-group choices row models-10"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims10-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle10-models" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-10"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin10-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin10">
							<a data-href="ownership10" data-current="vin10"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="ownership10" data-current="vin10"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="ownership10-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vin2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership10-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary10" data-current="ownership10">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-10" value="Owned" id="ownership10-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership10-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary10" data-current="ownership10" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-10" value="Financed" id="ownership10-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership10-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="primary10" data-current="ownership10" >
						Leased
						<input type="radio" class="d-none" name="ownership-vehicle-10" value="Leased" id="ownership10-3" />
						<i class="fa fa-angle-right"></i>
					</label>									
				</div>
			</div>
		</div>
	</div>

	<div id="primary10-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="ownership10" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary10-1" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven10" data-current="primary10">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-10" value="Commute" id="primary10-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary10-2" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven10" data-current="primary10" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-10" value="Pleasure" id="primary10-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary10-3" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven10" data-current="primary10" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-10" value="Business" id="primary10-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary10-4" class="h4 border text-center col-12 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="miles-driven10" data-current="primary10" >
						Farm
						<input type="radio" class="d-none" name="primary-use-vehicle-10" value="Farm" id="primary10-4" />
						<i class="fa fa-angle-right"></i>
					</label>														
				</div>
			</div>
		</div>
	</div>
	<div id="miles-driven10-container" class="step container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="primary10" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven10-1" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="previous-insurance" data-current="miles-driven10">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-10" value="Less than 5,000" id="miles-driven10-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven10-2" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="previous-insurance" data-current="miles-driven10" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-10" value="5,000-10,000" id="miles-driven10-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven10-3" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="previous-insurance" data-current="miles-driven10" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-10" value="10,000-15,000" id="miles-driven10-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven10-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="previous-insurance" data-current="miles-driven10" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-10" value="15,000-20,000" id="miles-driven10-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven10-4" class="h4 border text-center col-12 col-sm-4 col-md-4 col-lg-3 pl-2 pr-2" data-href="previous-insurance" data-current="miles-driven10" >
						More than 20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-10" value="More than 20,000" id="miles-driven10-5" />
						<i class="fa fa-angle-right"></i>
					</label>						
				</div>
			</div>
		</div>
	</div>	
	<!-- 10 VEHICLE END -->					
	<div id="previous-insurance-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Have you had auto insurance in the past 30 days?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="vehicle2-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="current-insurance" data-current="previous-insurance">
						Yes
						<input type="radio" class="d-none" name="previous-insurance" value="1" id="previous-insurance-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="vehicle2-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="married" data-current="previous-insurance">
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
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Current Auto Insurance</h4>
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
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">How long have you continuously had auto insurance?</h4>
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

	<div id="married-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Married?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="married-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="children" data-current="married">
						Yes
						<input type="radio" class="d-none" name="married" value="1" id="married-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="married-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="homeowner" data-current="married">
						No
						<input type="radio" class="d-none" name="married" value="0" id="married-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>

	<div id="children-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Children under the age of 16?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="children-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="homeowner" data-current="children">
						Yes
						<input type="radio" class="d-none" name="children" value="1" id="children-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="children-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="homeowner" data-current="children">
						No
						<input type="radio" class="d-none" name="children" value="0" id="children-no" />
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
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Do you own/rent?</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="owner" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="owner-bundled" data-current="homeowner">
						Own
						<input type="radio" class="d-none" name="homeowner" value="owner" id="owner" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="renter" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="renter-bundled" data-current="homeowner">
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
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Would you like to also receive home insurance policy quotes? You may be able to bundle and save even more on your auto policy.</h4>
				<div class="form-group choices row pr-15 pl-15">
					<label for="bundled-1" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="policy-detail" data-current="owner-bundled">
						Yes
						<input type="radio" class="d-none" name="bundled" value="1" id="bundled-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="bundled-2" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="policy-detail" data-current="owner-bundled">
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
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Would you like to also receive <span class="font-weight-bold">Renters Insurance</span> policy quotes? You may be able to bundle and save even more on your auto policy.</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="bundled-1" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="policy-detail" data-current="renter-bundled">
						Yes
						<input type="radio" class="d-none" name="bundled" value="1" id="bundled-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="bundled-2" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="policy-detail" data-current="renter-bundled">
						No
						<input type="radio" class="d-none" name="bundled" value="0" id="bundled-2" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div id="policy-detail-container" class="step container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-4">Has anyone on this policy had:</h4>

				<h4 class="mb-4">
					An at-fault accident in the past <strong>three (3) years?</strong>
				</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="at-fault-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="at_fault" value="1" id="at-fault-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="at-fault-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2">
						No
						<input type="radio" class="d-none" name="at_fault" value="0" id="at-fault-no" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>

				<h4 class="mb-4">
					<strong>Two (2) or more tickets</strong> in the past <strong>three (3) years?</strong>
				</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="tickets-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="tickets" value="1" id="tickets-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="tickets-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2">
						No
						<input type="radio" class="d-none" name="tickets" value="0" id="tickets-no" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>

				<h4 class="mb-4">
					A DUI conviction in the past <strong>ten (10) years?</strong>
				</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="dui-yes" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="dui" value="1" id="dui-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="col-2 col-sm-1"></span>
					<label for="dui-no" class="h4 border text-center col-5 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2">
						No
						<input type="radio" class="d-none" name="dui" value="0" id="dui-no" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>
				<div class="form-group row pl-15 pr-15">
					<a data-href="extra"  data-current="policy-detail" class="next-question btn btn-lg btn-warning">CONTINUE</a>
				</div>								
			</div>
		</div>
	</div>

	<div id="extra-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row ">
					<div class="col-12 col-sm-12 col-md-5 col-lg-5 mb-3">
						<div class="form-group">
							<label class="h4">Bodily Injury Liability &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#bodilyPopup"></i></label>
							<select class="form-control form-control-lg" name="bodily-injury">
								<option value="15-30" selected="selected">$15k/$30k</option>
								<option value="25-50">$25k/$50k</option>
								<option value="30-60">$30k/$60k</option>
								<option value="50-100">$50k/$100k</option>
								<option value="100-300">$100k/$300k</option>
								<option value="250-500">$250k/$500k</option>
								<option value="500-1000">$500k/$1Mil</option>
							</select>
						</div>
						<div class="form-group">
							<label class="h4">Property Damage  &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#propertyPopup"></i></label>
							<select class="form-control form-control-lg" name="property-damage">
								<option value="5000">$5000</option>
								<option value="25000" selected="selected">$25,000</option>
								<option value="50000">$50,000</option>
								<option value="100000">$100,000</option>
								<option value="250000">$250,000</option>
								<option value="500000">$500,000</option>
								<option value="1000000">$1,000,000</option>
							</select>
						</div>						
						<div class="form-group">
							<label class="h4">
								Comprehensive Deductible &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#deductiblePopup"></i>
							</label>
							<select class="form-control form-control-lg" name="deductible">
								<option value="250">$250</option>
								<option value="500">$500</option>
								<option value="1000" selected="selected">$1000</option>
							</select>
						</div>
						<div class="form-group">
							<label class="h4">
								Collision Deductible  &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#collisionPopup"></i>
							</label>
							<select class="form-control form-control-lg" name="collision-deductible">
								<option value="250">$250</option>
								<option value="500">$500</option>
								<option value="1000" selected="selected">$1000</option>
							</select>
						</div>											
						<div class="form-group">
							<label class="h4">Medical Coverage &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#medicalPopup"></i></label>
							<select class="form-control form-control-lg" name="medical">
								<option value="0" selected="selected">$0</option>
								<option value="5000">$5000</option>
								<option value="10000">$10000</option>
							</select>
						</div>						
					</div>
					<div class="d-none d-md-block col-md-2 col-lg-2 "></div>
					<div class="col-12 col-sm-12 col-md-5 col-lg-5">
						<h4 class="mb-2">Uninsured Motorist &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#uninsuredPopup"></i></h4>						
						<div class="form-group choices row pl-15 pr-15">
							<label for="at-fault-yes" class="h4 border text-center col-5 col-sm-5 col-md-3 col-lg-3 pl-2 pr-2 mb-0">
								Yes
								<input type="radio" class="d-none" name="uninsured" value="1" id="at-fault-yes" />
								<i class="fa fa-angle-right"></i>
							</label>
							<span class="col-2 col-sm-1"></span>
							<label for="at-fault-no" class="h4 border text-center col-5 col-sm-5 col-md-3 col-lg-3 pl-2 pr-2 mb-0">
								No
								<input type="radio" class="d-none" name="uninsured" value="0" id="at-fault-no" />
								<i class="fa fa-angle-right"></i>
							</label>
						</div>
						<h4 class="mb-2">Road Side &amp; Towing &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#towingPopup"></i></h4>						
						<div class="form-group choices row pl-15 pr-15">
							<label for="at-fault-yes" class="h4 border text-center col-5 col-sm-5 col-md-3 col-lg-3 pl-2 pr-2 mb-0">
								Yes
								<input type="radio" class="d-none" name="towing" value="1" id="at-fault-yes" />
								<i class="fa fa-angle-right"></i>
							</label>
							<span class="col-2 col-sm-1"></span>
							<label for="at-fault-no" class="h4 border text-center col-5 col-sm-5 col-md-3 col-lg-3 pl-2 pr-2 mb-0">
								No
								<input type="radio" class="d-none" name="towing" value="0" id="at-fault-no"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>
						<h4 class="mb-2">Rental Car &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#rentalPopup"></i></h4>						
						<div class="form-group choices row pl-15 pr-15">
							<label for="at-fault-yes" class="h4 border text-center col-5 col-sm-5 col-md-3 col-lg-3 pl-2 pr-2 mb-0">
								Yes
								<input type="radio" class="d-none" name="rental" value="1" id="at-fault-yes" />
								<i class="fa fa-angle-right"></i>
							</label>
							<span class="col-2 col-sm-1"></span>
							<label for="at-fault-no" class="h4 border text-center col-5 col-sm-5 col-md-3 col-lg-3 pl-2 pr-2 mb-0">
								No
								<input type="radio" class="d-none" name="rental" value="0" id="at-fault-no"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>												
					</div>								
				</div>
				<div class="form-group row pl-15 pr-15 mt-2">
					<a data-href="referral" data-current="extra" class="next-question btn btn-lg btn-warning">CONTINUE</a>
				</div>								
			</div>
		</div>
	</div>

	<div id="referral-container" class="step container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-5 col-lg-5">				
						<div class="form-group">
							<label class="h5 mb-2">What is the most important quality you look for when choosing an auto insurer?</label>
							<select class="form-control form-control-lg" name="quality">
								<option value="">Choose one</option>
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
						<h4 class="h5 mb-2 mt-2">Will it be important to you to be able to speak to your local agent in person?</h4>						
						<div class="form-group choices row pr-15 pl-15">
							<label for="at-fault-yes" class="h4 text-center border col-5 col-sm-5 col-md-3 col-lg-3 pl-2 pr-2">
								Yes
								<input type="radio" class="d-none" name="agent_in_person" value="1" id="at-fault-yes" />
								<i class="fa fa-angle-right"></i>
							</label>
							<span class="col-2 col-sm-1"></span>
							<label for="at-fault-no" class="h4 text-center border col-5 col-sm-5 col-md-3 col-lg-3 pl-2 pr-2 ">
								No
								<input type="radio" class="d-none" name="agent_in_person" value="0" id="at-fault-no"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>
					</div>
					<div class="d-none d-md-block col-md-2 col-lg-2"></div>
					<div class="col-12 col-sm-12 col-md-5 col-lg-5">
						<div class="form-group">
							<label class="h5 mb-2">How did you hear about us?</label>
							<select class="form-control form-control-lg not-required" name="referrer">
								<option value="">Choose one</option>
								<option value="friend-or-family">Friend or Family</option>
								<option value="auto-dealer">Auto Dealer</option>
								<option value="other">Other</option>
							</select>
						</div>						
						<div class="form-group">
							<label class="h5 mb-2">Referrer Name</label>
							<input type="text" name="referrer_name" class="form-control form-control-lg not-required">
						</div>						
					</div>					
				</div>
				<div class="form-group row pr-15 pl-15">
					<a data-href="name-email1" data-current="referral" class="next-question btn btn-lg btn-warning">CONTINUE</a>
				</div>								
			</div>
		</div>
	</div>
	<div id="name-email1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="referral" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="first_name" class="font-weight-bold h5 mb-3 text-warning">First Name</label>
							<input type="text" class="form-control form-control-lg" id="first_name" name="first_name">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="last_name" class="font-weight-bold h5 mb-3 text-warning">Last Name</label>
							<input type="text" class="form-control form-control-lg" id="last_name" name="last_name">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="email" class="font-weight-bold h5 mb-3 text-warning">Email</label>
							<input type="text" class="form-control form-control-lg" id="email" name="email">
						</div>
					</div>
				</div>
				<div class="row dob-error-1">
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning" for="dob">Birthday</label>
							<input type="tel" pattern="[0-9\/]*"  class="form-control form-control-lg masked-dob dob1 " name="dob" id="dob">
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="h5 text-warning font-weight-bold mb-3" for="">Gender</label>
							<div class="choices">
								<label class="h4 text-center border d-inline pl-2 pr-2 mr-3">
									Male
									<input type="radio" class="d-none" name="gender" value="Male">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border  d-inline pl-2 pr-2  mr-3">
									Female
									<input type="radio" class="d-none" name="gender" value="Female">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border d-inline pl-2 pr-2  mr-3">
									Non-Binary
									<input type="radio" class="d-none" name="gender" value="Non-Binary">
									<i class="fa fa-angle-right"></i>
								</label>							
							</div>
						</div>
					</div>			
				</div>	
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="dl1" class="font-weight-bold h5 mb-3 text-warning">Drivers License Number</label>
							<input type="text" class="form-control form-control-lg dl-field" id="dl1" name="dl1">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning">State</label>
							<select class="form-control form-control-lg" name="state1">
								<option value="">Choose one</option>
								@foreach($states as $s => $state)
								<option value="{{$s}}" @if($s=="CA") selected="selected" @endif>{{$state}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>							
				<div class="row mt-4">
					<div class="form-group">
						<div class="col-12">
							<a data-href="last" class="name-email-submit btn btn-lg btn-warning next-question" data-dob="1">CONTINUE</a> 
							<a data-href="name2" class="name-email-submit btn btn-lg btn-warning next-question" data-dob="1" >Add Another Driver</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<!-- DRIVER 2 START -->
	<div id="name2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name-email1" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="first_name2" class="font-weight-bold h5 mb-3 text-warning">First Name</label>
							<input type="text" class="form-control form-control-lg" id="first_name2" name="first_name2">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="last_name2" class="font-weight-bold h5 mb-3 text-warning">Last Name</label>
							<input type="text" class="form-control form-control-lg" id="last_name2" name="last_name2">
						</div>
					</div>
				</div>
				<div class="row dob-error-2">
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning" for="dob2">Birthday</label>
							<input type="tel" pattern="[0-9\/]*"  class="form-control form-control-lg masked-dob dob2 " name="dob2" id="dob2">
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="h5 text-warning font-weight-bold mb-3" for="">Gender</label>
							<div class="choices">
								<label class="h4 text-center border d-inline pl-2 pr-2 mr-3">
									Male
									<input type="radio" class="d-none" name="gender-2" value="Male">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border  d-inline pl-2 pr-2  mr-3">
									Female
									<input type="radio" class="d-none" name="gender-2" value="Female">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border d-inline pl-2 pr-2  mr-3">
									Non-Binary
									<input type="radio" class="d-none" name="gender-2" value="Non-Binary">
									<i class="fa fa-angle-right"></i>
								</label>							
							</div>
						</div>					
					</div>							
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="dl2" class="font-weight-bold h5 mb-3 text-warning">Drivers License Number</label>
							<input type="text" class="form-control form-control-lg " id="dl2" name="dl2">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning">State</label>
							<select class="form-control form-control-lg" name="state2">
								<option value="">Choose one</option>
								@foreach($states as $s => $state)
								<option value="{{$s}}" @if($s=="CA") selected="selected" @endif>{{$state}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>				
				<div class="row mt-4">
					<div class="form-group">
						<div class="col-12">
							<a data-href="last" data-dob="2" class="name-submit btn btn-lg btn-warning">CONTINUE</a> 
							<a data-href="name3" class="name-submit btn btn-lg btn-warning next-question" data-dob="2" >Add Another Driver</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- DRIVER 2 END -->
	<!-- DRIVER 3 START -->
	<div id="name3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name2" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="first_name3" class="font-weight-bold h5 mb-3 text-warning">First Name</label>
							<input type="text" class="form-control form-control-lg" id="first_name3" name="first_name3">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="last_name3" class="font-weight-bold h5 mb-3 text-warning">Last Name</label>
							<input type="text" class="form-control form-control-lg" id="last_name3" name="last_name3">
						</div>
					</div>
				</div>
				<div class="row dob-error-3">
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning" for="dob3">Birthday</label>
							<input type="tel" pattern="[0-9\/]*"  class="form-control form-control-lg masked-dob dob3 " name="dob3" id="dob3">
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="h5 text-warning font-weight-bold mb-3" for="">Gender</label>
							<div class="choices">
								<label class="h4 text-center border d-inline pl-2 pr-2 mr-3">
									Male
									<input type="radio" class="d-none" name="gender-3" value="Male">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border  d-inline pl-2 pr-2  mr-3">
									Female
									<input type="radio" class="d-none" name="gender-3" value="Female">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border d-inline pl-2 pr-2  mr-3">
									Non-Binary
									<input type="radio" class="d-none" name="gender-3" value="Non-Binary">
									<i class="fa fa-angle-right"></i>
								</label>							
							</div>
						</div>					
					</div>							
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="dl3" class="font-weight-bold h5 mb-3 text-warning">Drivers License Number</label>
							<input type="text" class="form-control form-control-lg " id="dl3" name="dl3">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning">State</label>
							<select class="form-control form-control-lg" name="state3">
								<option value="">Choose one</option>
								@foreach($states as $s => $state)
								<option value="{{$s}}" @if($s=="CA") selected="selected" @endif>{{$state}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>				
				<div class="row mt-4">
					<div class="form-group">
						<div class="col-12">
							<a data-href="last" data-dob="3" class="name-submit btn btn-lg btn-warning">CONTINUE</a> 
							<a data-href="name4" class="name-submit btn btn-lg btn-warning next-question" data-dob="3" >Add Another Driver</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- DRIVER 3 END -->
	<!-- DRIVER 4 START -->
	<div id="name4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name3" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="first_name4" class="font-weight-bold h5 mb-3 text-warning">First Name</label>
							<input type="text" class="form-control form-control-lg" id="first_name4" name="first_name4">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="last_name4" class="font-weight-bold h5 mb-3 text-warning">Last Name</label>
							<input type="text" class="form-control form-control-lg" id="last_name4" name="last_name4">
						</div>
					</div>
				</div>
				<div class="row dob-error-4">
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning" for="dob3">Birthday</label>
							<input type="tel" pattern="[0-9\/]*" class="form-control form-control-lg masked-dob dob4 " name="dob4" id="dob4">
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="h5 text-warning font-weight-bold mb-3" for="">Gender</label>
							<div class="choices">
								<label class="h4 text-center border d-inline pl-2 pr-2 mr-3">
									Male
									<input type="radio" class="d-none" name="gender-4" value="Male">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border  d-inline pl-2 pr-2  mr-3">
									Female
									<input type="radio" class="d-none" name="gender-4" value="Female">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border d-inline pl-2 pr-2  mr-3">
									Non-Binary
									<input type="radio" class="d-none" name="gender-4" value="Non-Binary">
									<i class="fa fa-angle-right"></i>
								</label>							
							</div>
						</div>					
					</div>										
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="dl4" class="font-weight-bold h5 mb-3 text-warning">Drivers License Number</label>
							<input type="text" class="form-control form-control-lg " id="dl4" name="dl4">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning">State</label>
							<select class="form-control form-control-lg" name="state4">
								<option value="">Choose one</option>
								@foreach($states as $s => $state)
								<option value="{{$s}}" @if($s=="CA") selected="selected" @endif>{{$state}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>				
				<div class="row mt-4">
					<div class="form-group">
						<div class="col-12">
							<a data-href="last" data-dob="4" class="name-submit btn btn-lg btn-warning">CONTINUE</a> 
							<a data-href="name5" class="name-submit btn btn-lg btn-warning next-question" data-dob="4" >Add Another Driver</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- DRIVER 4 END -->
	<!-- DRIVER 5 START -->
	<div id="name5-container" class="step container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name4" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="first_name5" class="font-weight-bold h5 mb-3 text-warning">First Name</label>
							<input type="text" class="form-control form-control-lg" id="first_name5" name="first_name5">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="last_name5" class="font-weight-bold h5 mb-3 text-warning">Last Name</label>
							<input type="text" class="form-control form-control-lg" id="last_name5" name="last_name5">
						</div>
					</div>
				</div>
				<div class="row dob-error-5">
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning" for="dob5">Birthday</label>
							<input type="tel" pattern="[0-9\/]*"  class="form-control form-control-lg masked-dob dob5 "  name="dob5" id="dob5">
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label class="h5 text-warning font-weight-bold mb-3" for="">Gender</label>
							<div class="choices">
								<label class="h4 text-center border d-inline pl-2 pr-2 mr-3">
									Male
									<input type="radio" class="d-none" name="gender-5" value="Male">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border  d-inline pl-2 pr-2  mr-3">
									Female
									<input type="radio" class="d-none" name="gender-5" value="Female">
									<i class="fa fa-angle-right"></i>
								</label>

								<label class="h4 text-center border d-inline pl-2 pr-2  mr-3">
									Non-Binary
									<input type="radio" class="d-none" name="gender-5" value="Non-Binary">
									<i class="fa fa-angle-right"></i>
								</label>							
							</div>
						</div>					
					</div>							
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="dl5" class="font-weight-bold h5 mb-3 text-warning">Drivers License Number</label>
							<input type="text" class="form-control form-control-lg " id="dl5" name="dl5">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label class="font-weight-bold h5 mb-3 text-warning">State</label>
							<select class="form-control form-control-lg" name="state5">
								<option value="">Choose one</option>
								@foreach($states as $s => $state)
								<option value="{{$s}}" @if($s=="CA") selected="selected" @endif>{{$state}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>				
				<div class="row mt-4">
					<div class="form-group">
						<div class="col-12">
							<a data-href="last" data-dob="5" class="name-submit btn btn-lg btn-warning">CONTINUE</a> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- DRIVER 5 END -->
	<div id="last-container" class="step container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dl5" class="change-question prev text-primary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<div class="row">
					<div class="col-12"><h3><span class="first-name-label"></span>, Last Step!</h3></div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label for="street" class="font-weight-bold h5 mb-3 text-warning">Street Address</label>
							<input type="text" class="form-control form-control-lg" id="street" name="street">
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label for="phone" class="font-weight-bold h5 mb-3 text-warning">Phone Number</label>
							<input type="tel" class="form-control form-control-lg" id="phone" name="phone" pattern="[0-9()]*" novalidate>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label for="d-city" class="font-weight-bold h5 mb-3 text-mute">City</label>
							<input type="text" class="form-control form-control-lg" id="d-city" disabled="disabled" readonly/>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label for="d-state" class="font-weight-bold h5 mb-3 text-mute">State</label>
							<input type="text" class="form-control form-control-lg" value="California" id="d-state" disabled="disabled" readonly />
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-group">
							<label for="d-zipcode" class="font-weight-bold h5 mb-3 text-mute">Zipcode</label>
							<input type="text" class="form-control form-control-lg" id="d-zipcode" disabled="disabled" readonly/>
						</div>
					</div>										
				</div>
				<div class="row">
					{{--
						<div class="col-12 form-group">
							<a href="javascript:;" class="review-application btn btn-lg btn-success">Review Summary</a>
						</div>
					--}}
					<div class="col-12">
						<div class="custom-control custom-checkbox float-left">
						  <input type="checkbox" class="custom-control-input" id="TnC">
						  <label class="custom-control-label" for="TnC">By clicking "Submit For Quotes" I provide my electronic signature and 
							express written consent to telemarketing calls, text messages, emails,
							and postal mail from this website, their affiliates, and insurance companies at the phone number, email address, and postal address provided by me. I consent to calls and text messages transmitting insurance quotes, or seeking related additional information from me. I understand that my signature is not a condition of purchasing any property, goods, or services and that I may revoke my consent at any time. Additionally, by clicking "Submit For Quotes," I acknowledge that I have read, understand, and agree to this website’s <a target="_blank" href="{{ route('privacy') }}">Privacy Policy.</a></label>
						</div>
					</div>
					<div class="col-12 form-group pt-3">
						<button type="submit" class="final-submit btn btn-lg btn-success">Submit For Quotes</button>
					</div>										
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="reviewPopup" tabindex="-1" role="dialog" aria-labelledby="reviewPopupTtitle" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="reviewPopupTtitle">Application Review</h5>
	      		</div>
	      		<div class="modal-body">
	      			<div class="questions_review_data"></div>
					<div class="row">
						<div class="col-12 form-group">
							<button type="submit" class="final-submit btn btn-lg btn-success">Submit For Quotes</button>
							<a href="javascript:;" class="btn btn-secondary cancel-review">Cancel</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							By clicking "Submit For Quotes" I provide my electronic signature and express written consent to telemarketing calls, text messages, emails, and postal mail from this website, their affiliates, and insurance companies at the phone number, email address, and postal address provided by me. I consent to calls and text messages transmitting insurance quotes, or seeking related additional information from me. I understand that my signature is not a condition of purchasing any property, goods, or services and that I may revoke my consent at any time. Additionally, by clicking "Submit For Quotes," I acknowledge that I have read, understand, and agree to this website’s <a target="_blank" href="{{ route('privacy') }}">Privacy Policy.</a> 
						</div>
					</div>	      			
	      		</div>
	  		</div>
		</div>
	</div>
</form>
<div class="modal fade" id="bodilyPopup" tabindex="-1" role="dialog" aria-labelledby="bodilyPopupTtitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bodilyPopupTtitle">Bodily Injury Liability</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>This coverage pays for damages due to bodily injury and property damage to others for which you are responsible. If you are sued, it also pays for your defense and court costs. Medical expenses, pain and suffering, and lost wages are some examples of bodily injury damages. Property damage includes damage to property and loss of its use.</p>
		<p><strong>How high should my limits be?</strong></p>
		<p>Nobody can tell you the most you would have to pay if you were to cause an accident. Consider how you would pay any damages that exceed your limits. The higher your limits are, the more likely it is that we will be able to pay all of the damages for you.</p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="rentalPopup" tabindex="-1" role="dialog" aria-labelledby="rentalPopupTtitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rentalPopupTtitle">Car Rental and Travel Expenses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<p><strong>This coverage pays for the following expenses:</strong></p>
		<p><strong>Car Rental Expense</strong> - Pays up to the amount you choose, from the options shown below, when you rent a car while your car is not drivable due to a loss that would be payable under Comprehensive or Collision Coverage.</p>
		<p><strong>Limit Options</strong></p>

		<p><strong>Travel Expenses</strong> - Pays up to $400 total for the following incurred expenses for all persons when your car is not drivable as a result of a loss that occurs more than 50 miles from home: meals, lodging, and transportation home or on to your destination and the return trip to pick up your car.</p>

		<p><strong>Rental Car</strong> - Repayment of Deductible Amount Expense: Pays up to $400 for a deductible for which you may be responsible if you have an accident in a rental car.</p>
        
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="towingPopup" tabindex="-1" role="dialog" aria-labelledby="towingPopupTtitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="towingPopupTtitle">Emergency Road Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<p><strong>This coverage pays the fair cost for the following emergency services for a covered car:</strong></p>

		<ul>
			<li>Mechanical labor for up to one hour at the place of its breakdown.</li>
			<li>Towing to the nearest place where repairs can be made.</li>
			<li>Towing the car out if it is stuck on or next to a public road.</li>
			<li>Delivery of gas, oil, battery, or change of tire, but not the cost of such items.</li>
			<li>Locksmith labor for up to one hour to unlock a covered car if its key is lost, stolen, or locked inside the car.</li>
		</ul>
		<p><strong>Whom do I call when I need help?</strong></p>

		<p>You may call any service provider in the area. State Farm's Emergency Road Service Coverage lets you choose who comes to your aid.</p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="uninsuredPopup" tabindex="-1" role="dialog" aria-labelledby="uninsuredPopupTtitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uninsuredPopupTtitle">Uninsured Motorist</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<p>Uninsured Motor Vehicle Coverage pays for damages when an insured is injured in a car accident caused by another person who does not have any liability insurance, or who does not have enough to pay your damages.</p>

		<p>Why should I buy Uninsured Motor Vehicle Coverage?</p>

		<p>Doing so lets you decide how much coverage is available to pay your damages. Without Uninsured Motor Vehicle Coverage, you must rely upon whatever liability limits, if any, are carried by the other driver to pay your damages.</p>

		<ul>
			<li>No Coverage</li>
			<li>$15,000/$30,000</li>
			<li>$25,000/$50,000 </li>
			<li>$30,000/$60,000 </li>
			<li>$50,000/$100,000 </li>
			<li>$100,00/$300,000</li>
		</ul>

		<p>Uninsured Motor Vehicle - Property Damage</p>

		<p>Uninsured Motor Vehicle – Property Damage Coverage pays for property damages to your car resulting from an accident caused by an uninsured driver. If you have Collision Coverage, Uninsured Motor Vehicle Coverage - Property Damage pays damages up to the amount of your Collision Coverage deductible. lf you do not have Collision Coverage, Uninsured Motor Vehicle Coverage - Property Damage pays damages up to $3,500.</p>

		<p><strong>Why should I buy this coverage?</strong></p>

		<p>Doing so lets you decide how much coverage is available to pay your damages. Without this, your only option is to try to get the other driver to pay your damages out of their own pocket.</p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="medicalPopup" tabindex="-1" role="dialog" aria-labelledby="medicalPopupTtitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="medicalPopupTtitle">Medical Payments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<p>This coverage pays medical and funeral expenses for bodily injury sustained by a covered person in a car accident. Medical expenses must be reasonable, necessary, and for services furnished within three years after the accident. The most we will pay for funeral expenses is the lower of your limit or $3,000.</p>

		<p><strong>Why should I buy Medical Payments Coverage?</strong></p>

		<p>Medical Payments Coverage pays covered expenses regardless of who’s at fault in an accident. Each person occupying your car is covered for up to the limit you choose. Because there are no deductibles or coinsurance requirements, we will pay beginning with the first dollar of incurred expenses. Medical Payments Coverage provides an unbeatable combination of great coverage and an affordable price.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deductiblePopup" tabindex="-1" role="dialog" aria-labelledby="deductiblePopupTtitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deductiblePopupTtitle">Comprehensive Coverage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<p>Comprehensive Coverage pays for a covered car that's stolen or damaged by causes other than collision or upset. For example, damage caused by the following is covered:</p>

		<ul>
			<li>Fire</li>
			<li>Wind</li>
			<li>Hail</li>
			<li>Flood</li>
			<li>Earthquake</li>
			<li>Theft</li>
			<li>Vandalism</li>
			<li>Hitting a bird or animal</li>
		</ul>

		<p>Comprehensive Coverage will also pay for substitute transportation expenses of up to $25 a day if your car is stolen. Payments will be made beginning when you tell us of the theft. A deductible is not required.</p>

		<p>Please note that if you lease or have a lien on your covered vehicle, your lessor or lienholder may require you to buy this coverage.</p>

		<p>Should I carry a deductible even though I don't have to?</p>

		<p>Higher deductibles will lower your premium but increase the amount you must pay out of your own pocket if a loss occurs. Ask yourself how much you're willing to pay in order to save money on premiums.</p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="collisionPopup" tabindex="-1" role="dialog" aria-labelledby="collisionPopupTtitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="collisionPopupTtitle">Collision Coverage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<p>This coverage pays for a covered car that is damaged by collision with another object or by the upset of the car. A deductible is required.</p>

		<p>Please note that if you lease or have a lien on your covered vehicle, your lessor or lienholder may require you to buy this coverage.</p>

		<p>How high should my deductible be?</p>

		<p>Higher deductibles lower your premium but increase the amount you’ll have to pay out of your own pocket in case of a loss. Ask yourself how much you’re willing to pay to save money on premiums.</p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="propertyPopup" tabindex="-1" role="dialog" aria-labelledby="propertyPopupTtitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="propertyPopupTtitle">Property Damage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<p>This coverage pays for damages due to bodily injury and property damage to others for which you are responsible. If you are sued, it also pays for your defense and court costs. Medical expenses, pain and suffering, and lost wages are some examples of bodily injury damages. Property damage includes damage to property and loss of its use.</p>
		<p>How high should my limits be?</p>

		<p>Nobody can tell you the most you would have to pay if you were to cause an accident. Consider how you would pay any damages that exceed your limits. The higher your limits are, the more likely it is that we will be able to pay all of the damages for you.</p>
      </div>
    </div>
  </div>
</div>
@endsection