@extends('Layouts.frontend')
@section('content')
<div class="pt-5 pb-5 container">
	<form action="" method="post">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="fname">First Name</label>
					<input type="text" class="form-control form-control-lg" name="fname" id="fname" placeholder="First Name">
				</div>
			</div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="lname">Last Name</label>
					<input type="text" class="form-control  form-control-lg" id="lname" name="lname" placeholder="Last Name">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="text" class="form-control   form-control-lg" id="email" name="email" placeholder="email">
				</div>
			</div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" class="form-control  form-control-lg" id="phone" name="phone" placeholder="Phone">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="form-group">
					<label for="message">Message</label>
					<textarea class="form-control form-control-lg" placeholder="Message" name="message" id="message"></textarea>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-lg btn-warning">Submit</button>			
	</form>
</div>
@endsection