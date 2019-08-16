	<div id="name-email1-container" class="container pt-5 pb-5" style="display: none;">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<p>
					<a data-href="referral" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
							<select class="form-control form-control-lg skip-reset" name="state1">
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
					<a data-href="name-email1" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
							<select class="form-control form-control-lg skip-reset" name="state2">
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
					<a data-href="name2" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
							<select class="form-control form-control-lg skip-reset" name="state3">
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
					<a data-href="name3" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
							<select class="form-control form-control-lg skip-reset" name="state4">
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
					<a data-href="name4" class="change-question prev text-primary btn btn-warning btn-sm"> 
							<i class="fa fa-angle-left"></i> Previous Question
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
							<select class="form-control form-control-lg skip-reset" name="state5">
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