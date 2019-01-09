@extends('Layouts.frontend')
@section('content')
<form class="lead-form">
	<div id="zipcode-container" class="row p-5">
		<div class="container">
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
	<div id="year-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
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
	<div id="make-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle</h3>
				<h4 class="mb-2">Make</h4>
				<div class="form-group choices row">
					@foreach ($makes as $make)
					<label for="make-{{$loop->iteration}}" class="h4 col-12 col-sm-12 col-md-6 col-lg-6 pl-2 pr-2" data-href="models" data-current="make">
						{{$make}}
						<input type="radio" class="d-none" name="make" value="{{$make}}" id="make-{{$loop->iteration}}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div id="models-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle</h3>
				<h4 class="mb-2">Model</h4>
				<div class="form-group choices row">
					@foreach ($models as $model)
					<label for="model-{{$loop->iteration}}" class="h4 col-12 col-sm-12 col-md-6 col-lg-6 pl-2 pr-2" data-href="vehicle2" data-current="models">
						{{$model}}
						<input type="radio" class="d-none" name="model" value="{{$model}}" id="model-{{$loop->iteration}}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle2-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
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
	<div id="vehicle2-year-container" class="row p-5" style="display: none;">
		<div class="container">
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
	<div id="vehicle2-make-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle</h3>
				<h4 class="mb-2">Make</h4>
				<div class="form-group choices row">
					@foreach ($makes as $make)
					<label for="vehicle2-make-{{$loop->iteration}}" class="h4 col-12 col-sm-12 col-md-6 col-lg-6 pl-2 pr-2" data-href="vehicle2-models" data-current="vehicle2-make">
						{{$make}}
						<input type="radio" class="d-none" name="vehicle2-make" value="{{$make}}" id="vehicle2-make-{{$loop->iteration}}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div id="vehicle2-models-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle</h3>
				<h4 class="mb-2">Model</h4>
				<div class="form-group choices row">
					@foreach ($models as $model)
					<label for="vehicle2-model-{{$loop->iteration}}" class="h4 col-12 col-sm-12 col-md-6 col-lg-6 pl-2 pr-2" data-href="previous-insurance" data-current="vehicle2-models">
						{{$model}}
						<input type="radio" class="d-none" name="vehicle2-model" value="{{$model}}" id="vehicle2-model-{{$loop->iteration}}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endforeach
				</div>
			</div>
		</div>
	</div>

	<div id="previous-insurance-container" class="row p-5" style="display: none;">
		<div class="container">
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
					<label for="vehicle2-yes" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="gender" data-current="previous-insurance">
						No
						<input type="radio" class="d-none" name="previous-insurance" value="0" id="previous-insurance-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>
	<div id="current-insurance-container" class="row p-5" style="display: none;">
		<div class="container">
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
	<div id="current-insurance-duration-container" class="row p-5" style="display: none;">
		<div class="container">
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
					<label for="duration-1" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="gender" data-current="current-insurance-duration">
						Less than a year
						<input type="radio" class="d-none" name="current-insurance-duration" value="0-1" id="duration-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="duration-2" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="gender" data-current="current-insurance-duration">
						1 to 2 years
						<input type="radio" class="d-none" name="current-insurance-duration" value="1-2" id="duration-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="duration-3" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="gender" data-current="current-insurance-duration">
						2 to 3 years
						<input type="radio" class="d-none" name="current-insurance-duration" value="2-3" id="duration-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="duration-4" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="gender" data-current="current-insurance-duration">
						4+ years
						<input type="radio" class="d-none" name="current-insurance-duration" value="4+" id="duration-4" />
						<i class="fa fa-angle-right"></i>
					</label>		
				</div>
			</div>
		</div>
	</div>
	<div id="gender-container" class="row p-5" style="display: none;">
		<div class="container">
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

	<div id="married-container" class="row p-5" style="display: none;">
		<div class="container">
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
					<label for="married-yes" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="credit" data-current="married">
						Yes
						<input type="radio" class="d-none" name="married" value="1" id="married-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="married-no" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2" data-href="credit" data-current="married">
						No
						<input type="radio" class="d-none" name="married" value="0" id="married-no" />
						<i class="fa fa-angle-right"></i>
					</label>					
				</div>
			</div>
		</div>
	</div>

	<div id="credit-container" class="row p-5" style="display: none;">
		<div class="container">
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

	<div id="homeowner-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h4 class="mb-2">Homeowner?</h4>
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
	<div id="owner-bundled-container" class="row p-5" style="display: none;">
		<div class="container">
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
					<label for="bundled-1" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="policy-detail" data-current="owner-bundled-container">
						Yes
						<input type="radio" class="d-none" name="bundled" value="1" id="bundled-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="bundled-2" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="policy-detail" data-current="owner-bundled-container">
						No
						<input type="radio" class="d-none" name="bundled" value="0" id="bundled-2" />
						<i class="fa fa-angle-right"></i>
					</label>	
				</div>
			</div>
		</div>
	</div>
	<div id="renter-bundled-container" class="row p-5" style="display: none;">
		<div class="container">
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
					<label for="bundled-1" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="policy-detail" data-current="renter-bundled-container">
						Yes
						<input type="radio" class="d-none" name="bundled" value="1" id="bundled-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="bundled-2" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="policy-detail" data-current="renter-bundled-container">
						No
						<input type="radio" class="d-none" name="bundled" value="0" id="bundled-2" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div id="policy-detail-container" class="row p-5" style="display: none;">
		<div class="container">
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
					<label for="at-fault-yes" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="at_fault" value="1" id="at-fault-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="at-fault-no" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2 bg-warning">
						No
						<input type="radio" class="d-none" name="at_fault" value="0" id="at-fault-no" checked="checked" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>

				<h4 class="mb-2">
					<strong>Two (2) or more tickets</strong> in the past <strong>three (3) years?</strong>
				</h4>
				<div class="form-group choices row">
					<label for="tickets-yes" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="tickets" value="1" id="tickets-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="tickets-no" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2 bg-warning">
						No
						<input type="radio" class="d-none" name="tickets" value="0" id="tickets-no" checked="checked" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>


				<h4 class="mb-2">
					A DUI conviction in the past <strong>three (3) years?</strong>
				</h4>
				<div class="form-group choices row">
					<label for="dui-yes" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2">
						Yes
						<input type="radio" class="d-none" name="dui" value="1" id="dui-yes" />
						<i class="fa fa-angle-right"></i>
					</label>
					<label for="dui-no" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2 bg-warning">
						No
						<input type="radio" class="d-none" name="dui" value="0" id="dui-no" checked="checked" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>
				<div class="form-group choices row">
					<button type="submit" class="btn btn-warning btn-lg">
						CONTINUE
					</button>
				</div>								
			</div>
		</div>
	</div>		

</form>
@endsection