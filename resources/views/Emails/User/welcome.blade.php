<p>Dear {{$user->name}}</p>
<p>Your account has been create on {{ config('app.name', 'Quote Meow') }} with username: {{$user->username}}</p>
<p>Click <a href="{{route('admin.home')}}">here</a> to login.</p>