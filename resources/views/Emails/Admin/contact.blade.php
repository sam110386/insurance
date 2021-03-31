<style>
	.table{font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;max-width: 100%; overflow-x: auto; background-color: #FFF; padding: 15px; border:1px solid #cfcfcf; margin-bottom: 20px;}
	.lead-view,h2 {
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
		margin-bottom: 15px;
	}

	.lead-view td, .lead-view th {
		border: 1px solid #ddd;
		padding: 8px;
	}
	.lead-view tr:nth-child(even){background-color: #f2f2f2;}
	.lead-view tr:hover {background-color: #ddd;}
	.lead-view th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
		background-color: #007bff;
		color: white;
	}
	.lead-view th span{font-weight: normal;}
	.mb-10{margin-bottom: 10px;}
</style>
<p>New contact us enquiry recieved. Below are details :</p>

<table class="lead-view">
	<tr><th colspan="2">CONTACT DETAILS</th></tr>
	<tr><td><strong>First Name</strong></td><td>{{$user->fname}}</td></tr>
	<tr><td><strong>Last Name</strong></td><td>{{$user->lname}}</td></tr>
	<tr><td><strong>Email</strong></td><td>{{$user->email}}</td></tr>
	<tr><td><strong>Phone</strong></td><td>{{$user->phone}}</td></tr>
	<tr><td><strong>Message</strong></td><td>{{$user->message}}</td></tr>
</table>