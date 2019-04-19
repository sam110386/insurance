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
					<a data-href="year" data-pos="1" class="zipcode-submit mb-2 btn btn-lg btn-warning pull-left change-question">Get Your Quotes</a>

					<a data-href="#" class="mb-2 btn btn-lg btn-warning ">Empezar</a>
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
				<h3 class="font-weight-bold">Select Your Vehicle <span class="h4">- Year</span></h3>
				<div class="form-group choices row">
					@for ($i = 0; $i < 20; $i++)
					<label for="year-{{ now()->year - $i }}" class="h4 col-3 col-sm-2 col-md-2 col-lg-2 pl-2 pr-2" data-href="make" data-current="year">
						{{ now()->year - $i }}
						<input type="radio" class="d-none" name="year" value="{{ now()->year - $i }}" id="year-{{ now()->year - $i }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
					<div class="col-12">
						<a href="javascript:;" class="btn btn-secondary load-years">Select Previous Year</a>
					</div>
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
							<label for="make-{{$loop->iteration}}" class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="models" data-current="make" data-vehicle="1">
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
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="vin1" id="vin">
							<a data-href="vehicle2" data-current="vin1"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="vehicle2" data-current="vin1"  class="next-question btn btn-lg btn-info">SKIP</a>
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
				<h3 class="font-weight-bold">Second Vehicle <span class="h4">- Year</span></h3>
				<div class="form-group choices row">
					@for ($i = 0; $i < 20; $i++)
					<label for="vehicle2-year-{{ now()->year - $i }}" class="h4 col-3 col-sm-3 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle2-make" data-current="vehicle2-year">
						{{ now()->year - $i }}
						<input type="radio" class="d-none" name="vehicle2-year" value="{{ now()->year - $i }}" id="vehicle2-year-{{ now()->year - $i }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
					<div class="col-12">
						<a href="javascript:;" class="btn btn-secondary load-years">Select Previous Year</a>
					</div>					
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
							<label for="vehicle2-make-{{$loop->iteration}}" class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="vehicle2-models" data-current="vehicle2-make" data-vehicle="2">
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
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="vin2">
							<a data-href="vehicle3" data-current="vin2"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="vehicle3" data-current="vin2"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 3 VEHICLE START -->
	<div id="vehicle3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Add Third Vehicle? (Save Additional 20%)</h4>
				<div class="form-group choices row">
					<label for="vehicle3-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="vehicle3-year" data-current="vehicle3">
						Yes
						<input type="radio" class="d-none" name="vehicle3" value="1" id="vehicle3-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="vehicle3-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle3" >
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
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Third Vehicle <span class="h4">- Year</span></h3>
				<div class="form-group choices row">
					@for ($i = 0; $i < 20; $i++)
					<label for="vehicle3-year-{{ now()->year - $i }}" class="h4 col-3 col-sm-3 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle3-make" data-current="vehicle3-year">
						{{ now()->year - $i }}
						<input type="radio" class="d-none" name="vehicle3-year" value="{{ now()->year - $i }}" id="vehicle3-year-{{ now()->year - $i }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
					<div class="col-12">
						<a href="javascript:;" class="btn btn-secondary load-years">Select Previous Year</a>
					</div>						
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle3-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Third Vehicle <span class="h4">- Make</span></h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">POPULAR</h4>
						<div class="form-group choices row">
							@foreach ($carMakes['popular'] as $k => $popular)
							<label for="vehicle3-make-{{$loop->iteration}}" class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="vehicle3-models" data-current="vehicle3-make" data-vehicle="3">
								{{$popular}}
								<input type="radio" class="d-none" name="vehicle3-make" value="{{$k}}" id="vehicle3-make-{{$loop->iteration}}" />
								<i class="fa fa-angle-right"></i>
							</label>
							@endforeach
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-3">ALL</h4>
						<div class="form-group row">
							<select class="form-control form-control-lg" name="vehicle3-make-select">
								@foreach ($carMakes['all'] as $k => $make)
								<option value="{{$k}}">{{$make}}</option>
								@endforeach
								<option value="other">Other</option>
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle3-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle3-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="3">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle3-models-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle3-make" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Third Vehicle</h3>
				<h4 class="mb-2">Model</h4>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group choices row models-3"></div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="model3-other" class="h4">Other</label>
							<input type="text" class="form-control form-control-lg mb-3 optional" name="model3-other" id="model3-other">
							<a data-href="vin3" class="vehicle-next btn btn-lg btn-warning" data-vehicle="3">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="vin3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle3-models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="vin3">
							<a data-href="vehicle4" data-current="vin3"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="vehicle4" data-current="vin3"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
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
					<a data-href="models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Add Fourth Vehicle? (Save Additional 20%)</h4>
				<div class="form-group choices row">
					<label for="vehicle4-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="vehicle4-year" data-current="vehicle4">
						Yes
						<input type="radio" class="d-none" name="vehicle4" value="1" id="vehicle4-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="vehicle4-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle4" >
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
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fourth Vehicle <span class="h4">- Year</span></h3>
				<div class="form-group choices row">
					@for ($i = 0; $i < 20; $i++)
					<label for="vehicle4-year-{{ now()->year - $i }}" class="h4 col-3 col-sm-3 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle4-make" data-current="vehicle4-year">
						{{ now()->year - $i }}
						<input type="radio" class="d-none" name="vehicle4-year" value="{{ now()->year - $i }}" id="vehicle4-year-{{ now()->year - $i }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
					<div class="col-12">
						<a href="javascript:;" class="btn btn-secondary load-years">Select Previous Year</a>
					</div>						
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle4-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fourth Vehicle <span class="h4">- Make</span></h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-4">POPULAR</h4>
						<div class="form-group choices row">
							@foreach ($carMakes['popular'] as $k => $popular)
							<label for="vehicle4-make-{{$loop->iteration}}" class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="vehicle4-models" data-current="vehicle4-make" data-vehicle="4">
								{{$popular}}
								<input type="radio" class="d-none" name="vehicle4-make" value="{{$k}}" id="vehicle4-make-{{$loop->iteration}}" />
								<i class="fa fa-angle-right"></i>
							</label>
							@endforeach
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-4">ALL</h4>
						<div class="form-group row">
							<select class="form-control form-control-lg" name="vehicle4-make-select">
								@foreach ($carMakes['all'] as $k => $make)
								<option value="{{$k}}">{{$make}}</option>
								@endforeach
								<option value="other">Other</option>
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle4-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle4-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="4">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle4-models-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle4-make" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fourth Vehicle</h3>
				<h4 class="mb-2">Model</h4>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group choices row models-4"></div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="model4-other" class="h4">Other</label>
							<input type="text" class="form-control form-control-lg mb-3 optional" name="model4-other" id="model4-other">
							<a data-href="vin4" class="vehicle-next btn btn-lg btn-warning" data-vehicle="4">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="vin4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle4-models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-4" name="vin4">
							<a data-href="vehicle5" data-current="vin4"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="vehicle5" data-current="vin4"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
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
					<a data-href="models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Add Fifth Vehicle? (Save Additional 20%)</h4>
				<div class="form-group choices row">
					<label for="vehicle5-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="vehicle5-year" data-current="vehicle5">
						Yes
						<input type="radio" class="d-none" name="vehicle5" value="1" id="vehicle5-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="vehicle5-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle5" >
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
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fifth Vehicle <span class="h4">- Year</span></h3>
				<div class="form-group choices row">
					@for ($i = 0; $i < 20; $i++)
					<label for="vehicle5-year-{{ now()->year - $i }}" class="h4 col-3 col-sm-3 col-md-2 col-lg-2 pl-2 pr-2" data-href="vehicle5-make" data-current="vehicle5-year">
						{{ now()->year - $i }}
						<input type="radio" class="d-none" name="vehicle5-year" value="{{ now()->year - $i }}" id="vehicle5-year-{{ now()->year - $i }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
					<div class="col-12">
						<a href="javascript:;" class="btn btn-secondary load-years">Select Previous Year</a>
					</div>						
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle5-make-container" class="vehicle-makes container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fifth Vehicle <span class="h5">- Make</span></h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-5">POPULAR</h4>
						<div class="form-group choices row">
							@foreach ($carMakes['popular'] as $k => $popular)
							<label for="vehicle5-make-{{$loop->iteration}}" class="h4 col-6 col-sm-12 col-md-5 col-lg-5 pl-2 pr-2" data-href="vehicle5-models" data-current="vehicle5-make" data-vehicle="5">
								{{$popular}}
								<input type="radio" class="d-none" name="vehicle5-make" value="{{$k}}" id="vehicle5-make-{{$loop->iteration}}" />
								<i class="fa fa-angle-right"></i>
							</label>
							@endforeach
						</div>						
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="mb-5">ALL</h4>
						<div class="form-group row">
							<select class="form-control form-control-lg" name="vehicle5-make-select">
								@foreach ($carMakes['all'] as $k => $make)
								<option value="{{$k}}">{{$make}}</option>
								@endforeach
								<option value="other">Other</option>
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle5-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle5-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="5">CONTINUE</a>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div id="vehicle5-models-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle5-make" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Fifth Vehicle</h3>
				<h4 class="mb-2">Model</h4>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group choices row models-5"></div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="model5-other" class="h5">Other</label>
							<input type="text" class="form-control form-control-lg mb-3 optional" name="model5-other" id="model5-other">
							<a data-href="vin5" class="vehicle-next btn btn-lg btn-warning" data-vehicle="5">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="vin5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle5-models" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-5" name="vin5">
							<a data-href="previous-insurance" data-current="vin5"  class="vin-submit btn btn-lg btn-warning">CONTINUE</a>
							<a data-href="previous-insurance" data-current="vin5"  class="next-question btn btn-lg btn-info">SKIP</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 5 VEHICLE END -->

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
							<label for="at-fault-yes" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2">
								Yes
								<input type="radio" class="d-none" name="uninsured" value="1" id="at-fault-yes" />
								<i class="fa fa-angle-right"></i>
							</label>
							<label for="at-fault-no" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 bg-warning">
								No
								<input type="radio" class="d-none" name="uninsured" value="0" id="at-fault-no" checked="checked" />
								<i class="fa fa-angle-right"></i>
							</label>
						</div>
						<h4 class="mb-2">Towing</h4>						
						<div class="form-group choices row">
							<label for="at-fault-yes" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2">
								Yes
								<input type="radio" class="d-none" name="towing" value="1" id="at-fault-yes" />
								<i class="fa fa-angle-right"></i>
							</label>
							<label for="at-fault-no" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 bg-warning">
								No
								<input type="radio" class="d-none" name="towing" value="0" id="at-fault-no" checked="checked"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>
						<h4 class="mb-2">Rental</h4>						
						<div class="form-group choices row">
							<label for="at-fault-yes" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2">
								Yes
								<input type="radio" class="d-none" name="rental" value="1" id="at-fault-yes" />
								<i class="fa fa-angle-right"></i>
							</label>
							<label for="at-fault-no" class="h4 col-6 col-sm-6 col-md-3 col-lg-3 pl-2 pr-2 bg-warning">
								No
								<input type="radio" class="d-none" name="rental" value="0" id="at-fault-no" checked="checked"/>
								<i class="fa fa-angle-right"></i>
							</label>
						</div>												
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label class="h4">Bodily Injury</label>
							<select class="form-control form-control-lg" name="bodily-injury">
								<option value="15-30" selected="selected">$15/$30</option>
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
								<option value="1000" selected="selected">$1000</option>
							</select>
						</div>						
						<div class="form-group">
							<label class="h4">Medical</label>
							<select class="form-control form-control-lg" name="bodily-injury">
								<option value="0" selected="selected">$0</option>
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
					<a data-href="name-email1" data-current="referral" class="next-question btn btn-lg btn-warning">CONTINUE</a>
				</div>								
			</div>
		</div>
	</div>
	<div id="name-email1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="referral" class="change-question text-secondary"> 
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
	<div id="dob-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name-email1" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Birthday</h3>
				<div class="row">
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Month</label>
							<select class="form-control form-control-lg dob1-month dob-change" data-dob="1" name="dob-month">
								<option value="1">01 </option>
								<option value="2">02</option>
								<option value="3">03</option>
								<option value="4">04</option>
								<option value="5">05</option>
								<option value="6">06</option>
								<option value="7">07</option>
								<option value="8">08</option>
								<option value="9">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>	
					</div>

					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Day</label>
							<select class="form-control form-control-lg dob1-date" name="dob-date">
								@for($i=1;$i< 32;$i++)
								<option value="{{$i}}">@if($i<10)0{{$i}}@else{{$i}}@endif</option>
								@endfor
							</select>
						</div>	
					</div>	
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Year</label>
							<select class="form-control form-control-lg dob1-year" data-dob="1" name="dob-year">
								@for($i=1;$i<= 100;$i++)
								<option value="{{ now()->year - $i }}">{{ now()->year - $i }}</option>
								@endfor
							</select>
						</div>	
					</div>					

					<div class="col-12">
						<a data-href="dl1" data-dob="1" class="btn dob-submit btn-lg btn-warning">Continue</a>
					</div>				
				</div>
			</div>
		</div>
	</div>

	<div id="dl1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dob" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Drivers License Number</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="dl1">
							<a data-href="driver2"  class="dl-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- DRIVER 2 START -->
	<div id="driver2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dl1" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Add additional driver?</h4>
				<div class="form-group choices row">
					<label for="driver2-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="name2" data-current="driver2">
						Yes
						<input type="radio" class="d-none" name="driver2" value="1" id="driver2-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="driver2-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="last" data-current="driver2" >
						No
						<input type="radio" class="d-none" name="driver2" value="0" id="driver2-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="name2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="driver2" class="change-question text-secondary"> 
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
				<div class="row">
					<div class="form-group">
						<div class="col-3">
							<a data-href="dob2" class="name-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="dob2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name2" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Birthday</h3>
				<div class="row">
				
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Month</label>
							<select class="form-control form-control-lg dob2-month dob-change" data-dob="2" name="dob2-month">
								<option value="1">01 </option>
								<option value="2">02</option>
								<option value="3">03</option>
								<option value="4">04</option>
								<option value="5">05</option>
								<option value="6">06</option>
								<option value="7">07</option>
								<option value="8">08</option>
								<option value="9">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>	
					</div>
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Day</label>
							<select class="form-control form-control-lg dob2-date" name="dob2-date">
								@for($i=1;$i< 32;$i++)
								<option value="{{$i}}">@if($i<10)0{{$i}}@else{{$i}}@endif</option>
								@endfor
							</select>
						</div>	
					</div>
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Year</label>
							<select class="form-control form-control-lg dob2-year" name="dob2-year">
								@for($i=1;$i<= 100;$i++)
								<option value="{{ now()->year - $i }}">{{ now()->year - $i }}</option>
								@endfor
							</select>
						</div>	
					</div>							
					<div class="col-12">
						<a data-href="dl2" data-dob="2" class="btn dob-submit btn-lg btn-warning">Continue</a>
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div id="dl2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dob2" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Drivers License Number</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="dl2">
							<a data-href="driver3"  class="dl-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- DRIVER 2 END -->
	<!-- DRIVER 3 START -->
	<div id="driver3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dl2" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Add additional driver?</h4>
				<div class="form-group choices row">
					<label for="driver3-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="name3" data-current="driver3">
						Yes
						<input type="radio" class="d-none" name="driver3" value="1" id="driver3-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="driver3-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="last" data-current="driver3" >
						No
						<input type="radio" class="d-none" name="driver3" value="0" id="driver3-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="name3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="driver3" class="change-question text-secondary"> 
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
				<div class="row">
					<div class="form-group">
						<div class="col-3">
							<a data-href="dob3" class="name-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="dob3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name3" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Birthday</h3>
				<div class="row">
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Month</label>
							<select class="form-control form-control-lg dob3-month dob-change" data-dob="3" name="dob3-month">
								<option value="1">01</option>
								<option value="2">02</option>
								<option value="3">03</option>
								<option value="4">04</option>
								<option value="5">05</option>
								<option value="6">06</option>
								<option value="7">07</option>
								<option value="8">08</option>
								<option value="9">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>	
					</div>
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Day</label>
							<select class="form-control form-control-lg dob3-date" name="dob3-date">
								@for($i=1;$i< 32;$i++)
								<option value="{{$i}}">@if($i<10)0{{$i}}@else{{$i}}@endif</option>
								@endfor
							</select>
						</div>	
					</div>
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Year</label>
							<select class="form-control form-control-lg dob3-year" name="dob3-year">
								@for($i=1;$i<= 100;$i++)
								<option value="{{ now()->year - $i }}">{{ now()->year - $i }}</option>
								@endfor
							</select>
						</div>	
					</div>										
					<div class="col-12">
						<a data-href="dl3" data-dob="3" class="btn dob-submit btn-lg btn-warning">Continue</a>
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div id="dl3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dob3" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Drivers License Number</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="dl3">
							<a data-href="driver4"  class="dl-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<!-- DRIVER 3 END -->
	<!-- DRIVER 4 START -->
	<div id="driver4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dl3" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Add additional driver?</h4>
				<div class="form-group choices row">
					<label for="driver4-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="name4" data-current="driver4">
						Yes
						<input type="radio" class="d-none" name="driver4" value="1" id="driver4-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="driver4-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="last" data-current="driver4" >
						No
						<input type="radio" class="d-none" name="driver4" value="0" id="driver4-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="name4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="driver4" class="change-question text-secondary"> 
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
				<div class="row">
					<div class="form-group">
						<div class="col-3">
							<a data-href="dob4" class="name-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="dob4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name4" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Birthday</h3>
				<div class="row">
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Month</label>
							<select class="form-control form-control-lg dob4-month dob-change" data-dob="4" name="dob4-month">
								<option value="1">01</option>
								<option value="2">02</option>
								<option value="3">03</option>
								<option value="4">04</option>
								<option value="5">05</option>
								<option value="6">06</option>
								<option value="7">07</option>
								<option value="8">08</option>
								<option value="9">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>	
					</div>
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Day</label>
							<select class="form-control form-control-lg dob4-date" name="dob4-date">
								@for($i=1;$i< 32;$i++)
								<option value="{{$i}}">@if($i<10)0{{$i}}@else{{$i}}@endif</option>
								@endfor
							</select>
						</div>	
					</div>	
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Year</label>
							<select class="form-control form-control-lg dob4-year" name="dob4-year">
								@for($i=1;$i<= 100;$i++)
								<option value="{{ now()->year - $i }}">{{ now()->year - $i }}</option>
								@endfor
							</select>
						</div>	
					</div>					
					<div class="col-12">
						<a data-href="dl4" data-dob="4" class="btn dob-submit btn-lg btn-warning">Continue</a>
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div id="dl4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dob4" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Drivers License Number</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="dl4">
							<a data-href="driver5"  class="dl-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- DRIVER 4 END -->
	<!-- DRIVER 5 START -->
	<div id="driver5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dl4" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Add additional driver?</h4>
				<div class="form-group choices row">
					<label for="driver5-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="name5" data-current="driver5">
						Yes
						<input type="radio" class="d-none" name="driver5" value="1" id="driver5-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="driver5-yes" class="h4 h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="last" data-current="driver5" >
						No
						<input type="radio" class="d-none" name="driver5" value="0" id="driver5-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="name5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="driver5" class="change-question text-secondary"> 
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
				<div class="row">
					<div class="form-group">
						<div class="col-3">
							<a data-href="dob5" class="name-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="dob5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name5" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Birthday</h3>
				<div class="row">
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Month</label>
							<select class="form-control form-control-lg dob5-month dob-change" data-dob="5" name="dob5-month">
								<option value="1">01</option>
								<option value="2">02</option>
								<option value="3">03</option>
								<option value="4">04</option>
								<option value="5">05</option>
								<option value="6">06</option>
								<option value="7">07</option>
								<option value="8">08</option>
								<option value="9">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>	
					</div>
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Day</label>
							<select class="form-control form-control-lg dob5-date" name="dob5-date">
								@for($i=1;$i< 32;$i++)
								<option value="{{$i}}">@if($i<10)0{{$i}}@else{{$i}}@endif</option>
								@endfor
							</select>
						</div>	
					</div>	
					<div class="col-4 col-sm-3">
						<div class="form-group">
							<label class="h5" for="">Year</label>
							<select class="form-control form-control-lg dob5-year" name="dob5-year">
								@for($i=1;$i<= 100;$i++)
								<option value="{{ now()->year - $i }}">{{ now()->year - $i }}</option>
								@endfor
							</select>
						</div>	
					</div>					

					<div class="col-12">
						<a data-href="dl5" data-dob="5" class="btn dob-submit btn-lg btn-warning">Continue</a>
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div id="dl5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dob5" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Drivers License Number</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3" name="dl5">
							<a data-href="last" class="dl-submit btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- DRIVER 5 END -->	
	<div id="last-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="dl5" class="change-question text-secondary"> 
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

	<!-- Not showing -->
	<!--div id="dob-month-container" class="container pt-5 pb-5" style="display: none;">
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
	</div-->
	<!-- Not showing ---->
</form>
@endsection