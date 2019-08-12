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
  <link rel="icon" href="/fav.ico" type="image/x-icon" />
  <title>{{ config('app.name', 'Insurance') }}</title>
</head>
<body class="sidebar-mini">
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/"><img src="{{asset('img/logo.png')}}" alt="Insurance" height="50" /></a>
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
               
          {{--<ul class="navbar-nav ml-auto nav-right">
                                <li class="nav-item">
                                  <a class="nav-link" href="#"><i class="fa fa-phone"></i></a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="#"><i class="fa fa-comment"></i> <img src="{{ asset('img/life-help-off.svg') }}" alt="Agents" /> <span>Expert Help</span></a>
                                </li>
                              </ul>--}}
        </div>
      </div>
    </nav>
  </header>