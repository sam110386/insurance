<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <title>{{ config('app.name', 'Insurance') }}</title>
</head>
<body class="sidebar-mini">
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/"><img src="{{asset('img/logo.jpg')}}" alt="Insurance" height="50" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">        
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('about') }}">ABOUT</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
            </li>        
            <li class="nav-item">
              <a class="nav-link" href="{{ route('contact') }}">CONTACT</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <section>
    @yield('content')
  </section>
  <div class="brand-carousel container-fluid border-top border-bottom">
   <div class="row">
    <div class="col-12">
      <div class="owl-carousel owl-theme">
        <div class="item">
          <img src="{{ asset('img/isurance.png') }}" alt="Isurance" />
        </div>
        <div class="item">
          <img src="{{ asset('img/mercury.png') }}" alt="Mercury" />
        </div>
        <div class="item">
          <img src="{{ asset('img/farmers.png') }}" alt="Farmers" />
        </div>
        <div class="item">
          <img src="{{ asset('img/state-farm.png') }}" alt="State Farm" />
        </div>
        <div class="item">
          <img src="{{ asset('img/national-wide.png') }}" alt="National Wide" />
        </div>
        <div class="item">
          <img src="{{ asset('img/american-family.png') }}" alt="American Family" />
        </div>
        <div class="item">
          <img src="{{ asset('img/progressive.png') }}" alt="Progressive" />
        </div>
        <div class="item">
          <img src="{{ asset('img/liberty-mutual.png') }}" alt="Liberty Mutual" />
        </div>                        
      </div>
    </div>
  </div>

</div>
<footer class="footer">
  <div class="container text-center">
    <span class="text-muted">All Rights Reserves &copy; Insurance.</span> 
  </div>
</footer>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
@stack('scripts')
<script src="{{ asset('js/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>