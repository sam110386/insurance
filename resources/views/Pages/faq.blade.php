@extends('Layouts.frontend')
@section('content')
<div class="pt-5 pb-5 container">
	<div id="accordion">
		<div class="card ">
			<div class="bg-secondary text-white card-header" id="faq-heading-1" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1">
				<h5 class="mb-0"  >1. Auto Insurance in California
				</h5>
			</div>
			<div id="faq1" class="collapse show" aria-labelledby="faq-heading-1" data-parent="#accordion">
				<div class="card-body">
					Some minimum coverage standards apply to auto insurance in California. If you drive a vehicle in this state, you need to know these laws in order to avoid potential penalties. It is also important to keep in mind that these standards represent the absolute minimum of what you need to drive legally in California. Most experts strongly suggest that drivers go above and beyond mandated minimums when purchasing car insurance. Quotes2Compare makes it easy to find the best coverage at a rate you can afford.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header text-white bg-secondary" id="faq-heading-2" data-toggle="collapse" data-target="#faq2" aria-expanded="true" aria-controls="faq2">
				<h5 class="mb-0" >
					2. Minimum Liability Auto Insurance in California
				</h5>
			</div>
			<div id="faq2" class="collapse" aria-labelledby="faq-heading-2" data-parent="#accordion">
				<div class="card-body">
					Mandatory requirements apply to any vehicles parked or driven on California roads. The state demands that all qualifying vehicles have liability auto insurance that meets or exceeds the following standards:

					<ul>
						<li>$15,000 bodily injury per person</li>
						<li>Coverage for at least two people, totaling $30,000 bodily injury per accident</li>
						<li>$5,000 total property damage</li>
					</ul>
					Not only must drivers obtain coverage at or above these minimum standards, but they also must carry proof of that coverage in their vehicles at any moment. There are severe penalties for drivers caught operating a vehicle without the proper proof of insurance. It does not matter if you actually have a policy, you will still be subject to penalties. You should expect to be asked for your proof insurance:
					<ul>
						<li>After a car accident</li>
						<li>Any time law enforcement pulls you over</li>
						<li>Within 30 days of registering a new vehicle</li>
						<li>Within 45 days of cancelling a previous policy for your vehicle</li>
					</ul>
					Make sure you carry proof of insurance at all times. Suspension of driving privileges and fines may apply if you are caught without proof. This is especially true in cases of lapsed auto insurance in California.
				</div>
			</div>
		</div>		
		<div class="card">
			<div class="card-header text-white bg-secondary" id="faq-heading-3"  data-toggle="collapse" data-target="#faq3" aria-expanded="true" aria-controls="faq3">
				<h5 class="mb-0">
					3. No Fault, UI/UIM, and PIP in California
				</h5>
			</div>
			<div id="faq3" class="collapse" aria-labelledby="faq-heading-3" data-parent="#accordion">
				<div class="card-body">
					Some states require drivers to obtain auto insurance that includes protection against personal injury, no-fault accidents, or uninsured/underinsured motorist accidents. At this time, the state of California does not require its drivers to have any of these options included in their policies. You should keep up to date with the law because these regulations can change.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header text-white bg-secondary" id="faq-heading-4"  data-toggle="collapse" data-target="#faq4" aria-expanded="true" aria-controls="faq4">
				<h5 class="mb-0">
					4. DUI Laws You Need to Know
				</h5>
			</div>
			<div id="faq4" class="collapse" aria-labelledby="faq-heading-4" data-parent="#accordion">
				<div class="card-body">
					The maximum penalties that apply to first time DUI offenders are as follows:
					<ul>
						<li>Six month license suspension</li>
						<li>Fines totaling $400 to $1,000</li>
						<li>Imprisonment for four days up to six months</li>
						<li>Mandatory completion of the Driving Under the Influence Program</li>
						<li>Potential mandatory installation of ignition interlock device at offender’s expense</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header text-white bg-secondary" id="faq-heading-5"  data-toggle="collapse" data-target="#faq5" aria-expanded="true" aria-controls="faq5">
				<h5 class="mb-0">
					5. SR-22 Requirements for Auto Insurance in California
				</h5>
			</div>
			<div id="faq5" class="collapse" aria-labelledby="faq-heading-5" data-parent="#accordion">
				<div class="card-body">
					The SR-22 is a form that some drivers must file with the DMV as part of the reinstatement of driving privileges process. They are typically required for drivers who are applying for reinstatement of a driver’s license. California is one of the states that requires the SR-22 as a proof of financial responsibility following a driving suspension. You must obtain auto insurance in California before you regain your license.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header text-white bg-secondary" id="faq-heading-6" data-toggle="collapse" data-target="#faq6" aria-expanded="true" aria-controls="faq6">
				<h5 class="mb-0" >
					6. Get More Information from Government Resources
				</h5>
			</div>
			<div id="faq6" class="collapse" aria-labelledby="faq-heading-6" data-parent="#accordion">
				<div class="card-body">
					The California Department of Insurance can help you with any further details pertaining to auto insurance in California. You can call them at (800) 927-HELP or visit their website at <a class="text-white" href="http://www.insurance.ca.gov">www.insurance.ca.gov</a>.
				</div>
			</div>
		</div>		
	</div>
	<div class="row mt-5">
		<div class="col-12"><a class="btn btn-lg btn-warning" href="{{ route('new-lead') }}">Get your Quotes</a></div>
	</div>			
</div>



</div>
@endsection
