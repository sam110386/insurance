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
					<a data-href="year" data-pos="1" class="btn btn-lg btn-warning btn-block change-question">Get Your Quotes</a>
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
					<label for="year-{{ now()->year - $i }}" class="h4 col-6 col-sm-2 col-md-2 col-lg-1 pl-2 pr-2">
						{{ now()->year - $i }}
						<input type="radio" class="d-none" name="year" value="{{ now()->year - $i }}" id="year-{{ now()->year - $i }}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endfor
				</div>
				<a data-href="make" class="change-question d-none">Next</a>
			</div>
		</div>
	</div>
	<div id="make-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="year" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle</h3>
				<h4 class="mb-2">Make</h4>
				<div class="form-group choices row">
					@foreach ($makes as $make)
					<label for="make-{{$loop->iteration}}" class="h4 col-12 col-sm-12 col-md-6 col-lg-6 pl-2 pr-2">
						{{$make}}
						<input type="radio" class="d-none" name="make" value="{{$make}}" id="make-{{$loop->iteration}}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endforeach
				</div>
				<a data-href="models" data-pos="1" class="change-question d-none">Next</a>
			</div>
		</div>
	</div>
	<div id="models-container" class="row p-5" style="display: none;">
		<div class="container">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="year" class="change-question text-secondary"> 
						<strong>
							<i class="fa fa-angle-left"></i> Previous Question
						</strong>
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle</h3>
				<h4 class="mb-2">Model</h4>
				<div class="form-group choices row">
					@foreach ($models as $model)
					<label for="model-{{$loop->iteration}}" class="h4 col-12 col-sm-12 col-md-6 col-lg-6 pl-2 pr-2">
						{{$model}}
						<input type="radio" class="d-none" name="model" value="{{$model}}" id="model-{{$loop->iteration}}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endforeach
				</div>
				<a data-href="year" data-pos="1" class="change-question d-none">Next</a>
			</div>
		</div>
	</div>		
</form>
@endsection