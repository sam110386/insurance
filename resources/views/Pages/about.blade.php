@extends('Layouts.frontend')
@section('content')
<div class="pt-5 pb-5 container">
	<h2>About Us</h2>
	<p>QuoteMeow.com launched in 2018 with the strong belief that drivers deserve better auto insurance. We automated the quote process, allowing us to tailor policies that provide the coverages that drivers need, often with great savings.</p>
	<p>We also recognized a smarter driver is a safer driver: We take a modern approach to auto insurance, providing our customers with a top-notch customer service support team who will go above and beyond your expectations.</p>
	<div class="row ">
		<div class="col-12"><a class="btn btn-lg btn-warning" href="{{ route('new-lead') }}">Get your Quotes</a></div>
	</div>	
</div>
@endsection