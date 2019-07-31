@include('Layouts.header') 
  <section>
    @if(Route::is('new-lead'))
      @include('Pages.home')
    @endif
    @yield('content')
  </section>
@include('Layouts.footer') 
