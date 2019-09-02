@extends('Layouts.frontend')
@push('scripts')
<script type="text/javascript">
	var zipcodes = @json($zipcodes);
	var years = @json($years);
</script>
@endpush
@section('content')
<div class="row progress-container">
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
<form class="lead-form row" action="{{Request::fullUrl()}}" method="POST" novalidate>
	{{ csrf_field() }}
	<div id="zipcode-container" class="step container pt-5 pb-5 editable-field" style="display: block;">
		<div class="row pb-3">
			<div class="col-12 text-center">
				<h1 class="font-weight-bold">Insurance Quotes Made Easy!</h1>
			</div>
		</div>		
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<div class="form-group">
					<!--label for="zipcode" class="font-weight-bold h3 mb-3">Enter your zip code to start this short and easy process.</label-->
					<input type="number" class="form-control form-control-lg text-center" id="zipcode" name="zipcode" placeholder="ZIP Code" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
					<p class="text-center"><small>3 minutes until the finish line.</small></p>
				</div>
				<div class="form-group">
					<a data-href="year" data-pos="1" class="zipcode-submit mb-2 btn btn-lg btn-warning pull-left change-question">Get Your Quotes</a>

					<!--a data-href="#" class="mb-2 btn btn-lg btn-warning ">Empezar</a-->
				</div>
			</div>
		</div>
		<div class="row mt-5 mb-3 lg-mx-w-70-pr">
			<div class="col-12 col-md-4 text-center">
				<p><img src="{{ asset('img/home-icon-3.png') }}"  class="img-fluid" width="36"/></p>
				<h5 class="font-weight-bold">Tailoring the quotes for you.</h5>
				<p>Our experts will find the best rates from reputable companies.</p>
			</div>
			<div class="col-12 col-md-4 text-center">
				<p><img src="{{ asset('img/home-icon-1.png') }}"  class="img-fluid" width="36" /></p>
				<h5  class="font-weight-bold">Transparency is key.</h5>
				<p>Our quotes come with a peace of mind and without a pushy sales pitch.</p>
			</div>
			<div class="col-12 col-md-4 text-center">
				<p><img src="{{ asset('img/email-icon.png') }}"  class="img-fluid" width="36"/></p>
				<h5 class="font-weight-bold">Secure. Private. Exclusive.</h5>
				<p>You'll only ever get contacted by QuoteMeow representatives.</p>
			</div>		
		</div>		
	</div>
	@include('Lead.vehicles')
		
	<div id="previous-insurance-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Current Auto Insurance</h4>
				<div class="form-group choices row " id="insurance-companies">
					@foreach ($insuranceComp as $company)
					<label for="company-{{$loop->iteration}}" class="h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="current-insurance-duration" data-current="current-insurance">
						{{$company}}
						<input type="radio" class="d-none" name="current-insurance" value="{{$company}}" id="company-{{$loop->iteration}}" />
						<i class="fa fa-angle-right"></i>
					</label>
					@endforeach
					<label for="company-other" id='other-company' class="other h4 col-6 col-sm-6 col-md-4 col-lg-3 pl-2 pr-2" data-href="current-insurance-duration" data-current="current-insurance">
						Other
						<input type="radio" class="d-none" name="current-insurance" value="Other" id="company-other" placeholder="Enter company name" />
						<i class="fa fa-angle-right"></i>
					</label>
				</div>
				<div class="row other-insurance-company" style="display:none;">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="not-required form-control form-control-lg mb-3" name="current-insurance-other" id="current-insurance-other">
							<a data-href="current-insurance-duration" data-current="current-insurance" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<div id="current-insurance-duration-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm">
						<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Would also like to receive a <span class="font-weight-bold">Homeowners Insurance</span> quote? You may be able to bundle and save even more on your auto insurance.</h4>
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Would also like to receive a <span class="font-weight-bold">Renters Insurance</span> quote? You may be able to bundle and save even more on your auto insurance.
				</h4>
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<div class="row ">
					<div class="col-12 col-sm-12 col-md-5 col-lg-5 mb-3">
						<div class="form-group">
							<label class="h4">Bodily Injury Liability &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#bodilyPopup"></i></label>
							<select class="form-control form-control-lg skip-reset" name="bodily-injury">
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
							<select class="form-control form-control-lg skip-reset" name="property-damage">
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
							<select class="form-control form-control-lg skip-reset" name="deductible">
								<option value="250">$250</option>
								<option value="500">$500</option>
								<option value="1000" selected="selected">$1000</option>
							</select>
						</div>
						<div class="form-group">
							<label class="h4">
								Collision Deductible  &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#collisionPopup"></i>
							</label>
							<select class="form-control form-control-lg skip-reset" name="collision-deductible">
								<option value="250">$250</option>
								<option value="500">$500</option>
								<option value="1000" selected="selected">$1000</option>
							</select>
						</div>											
						<div class="form-group">
							<label class="h4">Medical Coverage &nbsp; <i class="fa fa-xs fa-question-circle c-pointer" data-toggle="modal" data-target="#medicalPopup"></i></label>
							<select class="form-control form-control-lg skip-reset" name="medical">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-5 col-lg-5">				
						<div class="form-group">
							<label class="h5 mb-2">What is the most important quality you look for when choosing an auto insurer?</label>
							<select class="form-control form-control-lg" name="quality">
								<option value="">Choose one</option>
								<option value="provides-quality-service">Provides quality service</option>
								<option value="is-a-reputable-company">Is a reputable company</option>
								<option value="offers-a-low-price-and-discounts">Offers a low price and discounts</option>
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
							<select class="form-control form-control-lg referrer" name="referrer">
								<option value="">Choose one</option>
								<option value="Email">Email</option>
								<option value="Social Media">Social Media</option>
								<option value="Google / Yahoo / Bing">Google / Yahoo / Bing</option>
								<option value="Other">Other</option>
							</select>
						</div>						
						<div class="form-group ref-name" style="display: none">
							<label class="h5 mb-2">Referrer Name</label>
							<input type="text" name="referrer_name" class="form-control form-control-lg">
						</div>						
					</div>					
				</div>
				<div class="form-group row pr-15 pl-15">
					<a data-href="name-email1" data-current="referral" class="next-question btn btn-lg btn-warning">CONTINUE</a>
				</div>								
			</div>
		</div>
	</div>

	@include('Lead.drivers')
	
	<div id="last-container" class="step container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="name5" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
							<input type="text" class="form-control form-control-lg skip-reset" value="California" id="d-state" disabled="disabled" readonly />
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
						<label class="tnc-text">
							<div class="custom-control custom-checkbox float-left mr-3">
							  <input type="checkbox" class="custom-control-input" id="TnC">
							  <label class="custom-control-label" for="TnC"></label>
							</div>
							By clicking "Submit For Quotes" I provide my electronic signature and 
							express written consent to telemarketing calls, text messages, emails,
							and postal mail from this website, their affiliates, and insurance companies at the phone number, email address, and postal address provided by me. I consent to calls and text messages transmitting insurance quotes, or seeking related additional information from me. I understand that my signature is not a condition of purchasing any property, goods, or services and that I may revoke my consent at any time. Additionally, by clicking "Submit For Quotes," I acknowledge that I have read, understand, and agree to this website’s <a target="_blank" href="{{ route('privacy') }}">Privacy Policy.</a>
						</label>
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
		<p>You may call any service provider in the area. This coverage lets you choose who comes to your aid.</p>
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