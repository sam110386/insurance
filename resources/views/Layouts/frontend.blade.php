@include('Layouts.header') 
  <section>
    @include('Pages.home') 
    @yield('content')
  </section>
@include('Layouts.footer') 
