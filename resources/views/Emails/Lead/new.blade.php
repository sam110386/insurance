<table>
	<tr><th>FIELD</th><th>VALUE</th></tr>
	@foreach($lead as $key => $value)
	@if($key != '_token')
	<tr><th>{{$key}} </th><td>{{$value}}</td></tr>
	@endif
	@endforeach
</table>