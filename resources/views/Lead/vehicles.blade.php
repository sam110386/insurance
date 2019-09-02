	<div id="year-container" class=" container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-12 col-md-10 offset-md-1">
				<p>
					<a data-href="zipcode" class="change-question prev text-primary btn btn-warning btn-sm ">
						<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year1-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm">
						<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-3">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="make-select">
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="1">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search m-0" name="model1-other" id="model1-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>
						<div class="form-group choices row models-1 col-12"></div>
						<div class="form-group">
							<a data-href="trims1" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="1">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="trims1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="models" class="change-question prev text-primary btn btn-warning btn-sm"> 
						<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-1"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-1" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually" />
							<a href="javascript:;" data-href="vin1" data-current="trims1" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
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
					<a data-href="models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin1" id="vin">
							<a data-href="ownership1" data-current="vin1"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin1" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership1-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary1" data-current="ownership1">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-1" value="Owned" id="ownership1-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership1-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary1" data-current="ownership1" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-1" value="Financed" id="ownership1-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership1-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary1" data-current="ownership1" >
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
					<a data-href="vin1" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary1-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven1" data-current="primary1">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-1" value="Commute" id="primary1-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary1-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven1" data-current="primary1" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-1" value="Pleasure" id="primary1-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary1-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven1" data-current="primary1" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-1" value="Business" id="primary1-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary1-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven1" data-current="primary1" >
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
					<a data-href="vin1" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-1" id="miles-driven-per-year-vehicle-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle2" data-current="miles-driven1" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->				
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven1-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="Less than 5,000" id="miles-driven1-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven1-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="5,000-10,000" id="miles-driven1-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven1-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="10,000-15,000" id="miles-driven1-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven1-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-1" value="15,000-20,000" id="miles-driven1-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven1-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle2" data-current="miles-driven1" >
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
					<a data-href="models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year2-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-3">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle2-make-select">
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle2-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle2-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="2">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle2-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Second Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model2-other" id="model2-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-2 col-12"></div>
						<div class="form-group">
							<a data-href="trims2" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="2">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims2-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle2-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-2"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-2" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually" />
							<a href="javascript:;" data-href="vin2" data-current="trims2" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
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
					<a data-href="trims2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin2">
							<a data-href="ownership2" data-current="vin2"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership2-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary2" data-current="ownership2">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-2" value="Owned" id="ownership2-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership2-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary2" data-current="ownership2" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-2" value="Financed" id="ownership2-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership2-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary2" data-current="ownership2" >
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
					<a data-href="ownership2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary2-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven2" data-current="primary2">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-2" value="Commute" id="primary2-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary2-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven2" data-current="primary2" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-2" value="Pleasure" id="primary2-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary2-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven2" data-current="primary2" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-2" value="Business" id="primary2-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary2-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven2" data-current="primary2" >
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
					<a data-href="primary2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-2" id="miles-driven-per-year-vehicle-2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle3" data-current="miles-driven2" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->				
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven2-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="Less than 5,000" id="miles-driven2-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven2-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="5,000-10,000" id="miles-driven2-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven2-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="10,000-15,000" id="miles-driven2-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven2-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-2" value="15,000-20,000" id="miles-driven2-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven2-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle3" data-current="miles-driven2" >
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
					<a data-href="models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year3-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Third Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-3">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle3-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle3-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle3-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="3">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle3-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Third Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model3-other" id="model3-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-3 col-12"></div>
						<div class="form-group">
							<a data-href="trims3" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="3">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims3-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle3-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-3"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-3" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually"/>
							<a href="javascript:;" data-href="vin3" data-current="trims3" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
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
					<a data-href="trims3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin3">
							<a data-href="ownership3" data-current="vin3"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership3-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary3" data-current="ownership3">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-3" value="Owned" id="ownership3-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership3-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary3" data-current="ownership3" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-3" value="Financed" id="ownership3-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership3-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary3" data-current="ownership3" >
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
					<a data-href="ownership3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary3-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven3" data-current="primary3">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-3" value="Commute" id="primary3-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary3-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven3" data-current="primary3" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-3" value="Pleasure" id="primary3-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary3-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven3" data-current="primary3" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-3" value="Business" id="primary3-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary3-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven3" data-current="primary3" >
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
					<a data-href="primary3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-3" id="miles-driven-per-year-vehicle-3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle4" data-current="miles-driven3" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->					
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven3-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="Less than 5,000" id="miles-driven3-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven3-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="5,000-10,000" id="miles-driven3-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven3-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="10,000-15,000" id="miles-driven3-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven3-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-3" value="15,000-20,000" id="miles-driven3-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven3-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle4" data-current="miles-driven3" >
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
					<a data-href="models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year4-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Fourth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-4">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle4-make-select">
							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle4-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle4-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="4">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle4-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Fourth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model4-other" id="model4-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-4 col-12"></div>
						<div class="form-group">
							<a data-href="trims4" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="4">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims4-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle4-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-4"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-4" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually"/>
							<a href="javascript:;" data-href="vin4" data-current="trims4" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
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
					<a data-href="trims4" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-4 not-required" name="vin4">
							<a data-href="ownership4" data-current="vin4"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin4" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership4-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary4" data-current="ownership4">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-4" value="Owned" id="ownership4-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership4-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary4" data-current="ownership4" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-4" value="Financed" id="ownership4-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership4-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary4" data-current="ownership4" >
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
					<a data-href="ownership4" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary4-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven4" data-current="primary4">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-4" value="Commute" id="primary4-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary4-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven4" data-current="primary4" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-4" value="Pleasure" id="primary4-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary4-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven4" data-current="primary4" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-4" value="Business" id="primary4-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary4-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven4" data-current="primary4" >
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
					<a data-href="primary4" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-4" id="miles-driven-per-year-vehicle-4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle5" data-current="miles-driven4" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->					
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven4-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="Less than 5,000" id="miles-driven4-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven4-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="5,000-10,000" id="miles-driven4-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven4-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="10,000-15,000" id="miles-driven4-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven4-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-4" value="15,000-20,000" id="miles-driven4-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven4-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle5" data-current="miles-driven4" >
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
					<a data-href="models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year5-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Fifth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-5">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle5-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle5-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle5-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="5">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle5-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Fifth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model5-other" id="model5-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-5 col-12"></div>
						<div class="form-group">
							<a data-href="trims5" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="5">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims5-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle5-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-5"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-5" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually"/>
							<a href="javascript:;" data-href="vin5" data-current="trims5" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
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
					<a data-href="trims5" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-5 not-required" name="vin5">
							<a data-href="ownership5" data-current="vin5"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin4" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership5-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary5" data-current="ownership5">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-5" value="Owned" id="ownership5-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership5-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary5" data-current="ownership5" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-5" value="Financed" id="ownership5-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership5-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary5" data-current="ownership5" >
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
					<a data-href="ownership5" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary5-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven5" data-current="primary5">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-5" value="Commute" id="primary5-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary5-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven5" data-current="primary5" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-5" value="Pleasure" id="primary5-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary5-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven5" data-current="primary5" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-5" value="Business" id="primary5-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary5-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven5" data-current="primary5" >
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
					<a data-href="primary5" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-5" id="miles-driven-per-year-vehicle-5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle6" data-current="miles-driven5" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->					
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven5-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="Less than 5,000" id="miles-driven5-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven5-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="5,000-10,000" id="miles-driven5-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven5-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="10,000-15,000" id="miles-driven5-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven5-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-5" value="15,000-20,000" id="miles-driven5-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven5-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle6" data-current="miles-driven5" >
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
					<a data-href="miles-driven5" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year6-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Sixth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-3">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle6-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle6-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle6-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="6">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle6-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Sixth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model6-other" id="model6-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-6 col-12"></div>
						<div class="form-group">
							<a data-href="trims6" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="6">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims6-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle6-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-6"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-6" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually"/>
							<a href="javascript:;" data-href="vin6" data-current="trims6" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin6-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin6">
							<a data-href="ownership6" data-current="vin6"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership6-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary6" data-current="ownership6">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-6" value="Owned" id="ownership6-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership6-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary6" data-current="ownership6" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-6" value="Financed" id="ownership6-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership6-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary6" data-current="ownership6" >
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
					<a data-href="ownership6" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary6-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven6" data-current="primary6">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-6" value="Commute" id="primary6-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary6-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven6" data-current="primary6" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-6" value="Pleasure" id="primary6-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary6-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven6" data-current="primary6" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-6" value="Business" id="primary6-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary6-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven6" data-current="primary6" >
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
					<a data-href="primary6" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-6" id="miles-driven-per-year-vehicle-6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle7" data-current="miles-driven6" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->				
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven6-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="Less than 5,000" id="miles-driven6-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven6-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="5,000-10,000" id="miles-driven6-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven6-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="10,000-15,000" id="miles-driven6-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven6-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-6" value="15,000-20,000" id="miles-driven6-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven6-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle7" data-current="miles-driven6" >
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
					<a data-href="miles-driven6" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year7-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Seventh Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-3">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle7-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle7-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle7-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="7">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle7-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Seventh Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model7-other" id="model7-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-7 col-12"></div>
						<div class="form-group">
							<a data-href="trims7" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="7">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims7-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle7-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-7"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-7" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually"/>
							<a href="javascript:;" data-href="vin7" data-current="trims7" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin7-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin7">
							<a data-href="ownership7" data-current="vin7"  class="vin-submit  disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership7-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary7" data-current="ownership7">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-7" value="Owned" id="ownership7-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership7-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary7" data-current="ownership7" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-7" value="Financed" id="ownership7-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership7-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary7" data-current="ownership7" >
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
					<a data-href="ownership7" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary7-1" class="h4 border text-center col-12 col-sm-12 col-md-4  col-lg-2 pl-2 pr-2" data-href="miles-driven7" data-current="primary7">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-7" value="Commute" id="primary7-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary7-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven7" data-current="primary7" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-7" value="Pleasure" id="primary7-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary7-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven7" data-current="primary7" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-7" value="Business" id="primary7-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary7-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven7" data-current="primary7" >
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
					<a data-href="primary7" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-7" id="miles-driven-per-year-vehicle-7" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle8" data-current="miles-driven7" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->				
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven7-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="Less than 5,000" id="miles-driven7-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven7-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="5,000-10,000" id="miles-driven7-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven7-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="10,000-15,000" id="miles-driven7-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven7-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-7" value="15,000-20,000" id="miles-driven7-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven7-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle8" data-current="miles-driven7" >
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
					<a data-href="miles-driven7" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year8-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Eighth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-3">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle8-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle8-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle8-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="8">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle8-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Eighth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model8-other" id="model8-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-8 col-12"></div>
						<div class="form-group">
							<a data-href="trims8" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="8">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims8-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle8-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-8"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-8" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually"/>
							<a href="javascript:;" data-href="vin8" data-current="trims8" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin8-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin8">
							<a data-href="ownership8" data-current="vin8"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership8-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary8" data-current="ownership8">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-8" value="Owned" id="ownership8-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership8-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary8" data-current="ownership8" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-8" value="Financed" id="ownership8-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership8-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary8" data-current="ownership8" >
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
					<a data-href="ownership8" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary8-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven8" data-current="primary8">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-8" value="Commute" id="primary8-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary8-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven8" data-current="primary8" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-8" value="Pleasure" id="primary8-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary8-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven8" data-current="primary8" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-8" value="Business" id="primary8-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary8-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven8" data-current="primary8" >
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
					<a data-href="primary8" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-8" id="miles-driven-per-year-vehicle-8" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle9" data-current="miles-driven8" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->					
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven8-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="Less than 5,000" id="miles-driven8-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven8-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="5,000-10,000" id="miles-driven8-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven8-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="10,000-15,000" id="miles-driven8-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven8-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-8" value="15,000-20,000" id="miles-driven8-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven8-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle9" data-current="miles-driven8" >
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
					<a data-href="miles-driven8" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year9-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
						<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Ninth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-3">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle9-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle9-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle9-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="9">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle9-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Ninth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model9-other" id="model9-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-9 col-12"></div>
						<div class="form-group">
							<a data-href="trims9" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="9">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims9-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle9-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-9"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-9" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually"/>
							<a href="javascript:;" data-href="vin9" data-current="trims9" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="vin9-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin9">
							<a data-href="ownership9" data-current="vin9"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership9-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary9" data-current="ownership9">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-9" value="Owned" id="ownership9-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership9-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary9" data-current="ownership9" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-9" value="Financed" id="ownership9-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership9-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary9" data-current="ownership9" >
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
					<a data-href="ownership9" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary9-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven9" data-current="primary9">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-9" value="Commute" id="primary9-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary9-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven9" data-current="primary9" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-9" value="Pleasure" id="primary9-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary9-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven9" data-current="primary9" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-9" value="Business" id="primary9-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary9-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven9" data-current="primary9" >
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
					<a data-href="primary9" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-9" id="miles-driven-per-year-vehicle-9" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="vehicle10" data-current="miles-driven9" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->				
				<div class="form-group choices row pl-15 pr-15">
					<label for="miles-driven9-1" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9">
						Less than 5,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="Less than 5,000" id="miles-driven9-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven9-2" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9" >
						5,000-10,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="5,000-10,000" id="miles-driven9-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven9-3" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9" >
						10,000-15,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="10,000-15,000" id="miles-driven9-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven9-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9" >
						15,000-20,000
						<input type="radio" class="d-none" name="miles-driven-per-year-vehicle-9" value="15,000-20,000" id="miles-driven9-4" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="miles-driven9-4" class="h4 border text-center col-12 col-sm-12 col-md-5 col-lg-3 pl-2 pr-2" data-href="vehicle10" data-current="miles-driven9" >
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
					<a data-href="miles-driven9" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
						<option value="other">Enter My Vehicle Year Manually</option>
					</select>
					<input type="tel" pattern="[0-9]*" placeholder="Enter Vehicle Year" name="year10-other-input" class="form-control form-control-lg vehicle-year-input col-12 col-md-6 mt-2" style="display: none;">					
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
					<a data-href="#" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Tenth Vehicle Make</h3>
				<div class="row">
					<div class="col-12 col-md-6">
						<h4 class="mb-3">ALL MAKES</h4>
						<div class="form-group">
							<select class="auto-select form-control form-control-lg" name="vehicle10-make-select">

							</select>
							<input type="text" class="mt-3 form-control form-control-lg optional" name="vehicle10-make-other" placeholder="Enter Vehicle Make" style="display: none;">
							<a data-href="vehicle10-models" class="mt-3 show-models btn btn-lg btn-warning" data-vehicle="10">CONTINUE</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<h4 class="mb-3">POPULAR MAKES</h4>
						<div class="form-group choices row col-12">
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
					<a data-href="vehicle10-make" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Tenth Vehicle Model</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 optional model-search" name="model10-other" id="model10-other" placeholder="search model...">
							<div class="list-group models-list">
							</div>
						</div>
						<div class="form-group">
							<h4>ALL MODELS</h4>
						</div>						
						<div class="form-group choices row models-10 col-12"></div>
						<div class="form-group">
							<a data-href="trims10" class="mt-3 vehicle-next btn btn-lg btn-warning" data-vehicle="10">CONTINUE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="trims10-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="vehicle10-models" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">Select Your Vehicle Trim</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-9 col-lg-9">
						<div class="form-group choices row trims-10"></div>
						<div class="form-group manual-trim" style="display: none">
							<input type="text" name="trim-other-10" class="form-control form-control-lg" placeholder="Enter Vehicle Trim Manually" />
							<a href="javascript:;" data-href="vin10" data-current="trims10" class="mt-3 btn btn-lg btn-warning next-question">Continue</a>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="vin10-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="trims3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h3 class="font-weight-bold">For an accurate quote, enter VIN</h3>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg mb-3 not-required" name="vin10">
							<a data-href="ownership10" data-current="vin10"  class="vin-submit disabled btn btn-lg btn-warning">CONTINUE</a>
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
					<a data-href="vin2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Ownership</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="ownership10-1" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary10" data-current="ownership10">
						Owned
						<input type="radio" class="d-none" name="ownership-vehicle-10" value="Owned" id="ownership10-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership10-2" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary10" data-current="ownership10" >
						Financed
						<input type="radio" class="d-none" name="ownership-vehicle-10" value="Financed" id="ownership10-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="ownership10-3" class="h4 border text-center col-12 col-sm-12 col-md-3 col-lg-2 pl-2 pr-2" data-href="primary10" data-current="ownership10" >
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
					<a data-href="ownership10" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Primary Use of Vehicle</h4>
				<div class="form-group choices row pl-15 pr-15">
					<label for="primary10-1" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven10" data-current="primary10">
						Commute
						<input type="radio" class="d-none" name="primary-use-vehicle-10" value="Commute" id="primary10-1" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary10-2" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven10" data-current="primary10" >
						Pleasure
						<input type="radio" class="d-none" name="primary-use-vehicle-10" value="Pleasure" id="primary10-2" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary10-3" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven10" data-current="primary10" >
						Business
						<input type="radio" class="d-none" name="primary-use-vehicle-10" value="Business" id="primary10-3" />
						<i class="fa fa-angle-right"></i>
					</label>
					<span class="mr-4"></span>
					<label for="primary10-4" class="h4 border text-center col-12 col-sm-12 col-md-4 col-lg-2 pl-2 pr-2" data-href="miles-driven10" data-current="primary10" >
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
					<a data-href="primary10" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
					</a>
				</p>
				<h4 class="mb-4">Miles Driven Per Year</h4>
				<!--div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<input type="tel" class="form-control form-control-lg mb-3" name="miles-driven-per-year-vehicle-10" id="miles-driven-per-year-vehicle-10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<a data-href="previous-insurance" data-current="miles-driven10" class="next-question btn btn-lg btn-warning">CONTINUE</a>
						</div>
					</div>
				</div-->					
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