<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('admin.title')}} | {{ trans('admin.reset_password') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css") }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="hold-transition login-page" @if(config('admin.login_background_image'))style="background: url({{config('admin.login_background_image')}}) no-repeat;background-size: cover;"@endif>
<div class="login-box">
  <div class="login-logo">
    <a href="{{ admin_base_path('/') }}">{!! config('admin.logo') !!}</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <!--p class="login-box-msg">{{ trans('admin.reset_password') }}</p-->
      @if(session()->has('error'))
          <div class="alert alert-error">
              {{ session()->get('error') }}
          </div>
      @endif
    <form action="{{ route('password-reset-post',$token) }}" method="post">
      <div class="form-group has-feedback {!! !$errors->has('password') ?: 'has-error' !!} ">
        <input type="password" class="form-control" placeholder="{{ trans('admin.new_password') }}" name="password" value="" >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
         @if($errors->has('password'))
          @foreach($errors->get('password') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
          @endforeach
        @endif        
      </div>

      <div class="form-group has-feedback {!! !$errors->has('password_confirmation') ?: 'has-error' !!} ">
        <input type="password" class="form-control" placeholder="{{ trans('admin.confirm_new_password') }}" name="password_confirmation" value="" >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
         @if($errors->has('password_confirmation'))
          @foreach($errors->get('password_confirmation') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
          @endforeach
        @endif
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('admin.submit') }}</button>
        </div>
        <div class="col-xs-8 text-right">
          <a href="{{ admin_base_path('auth/login') }}">Login</a>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</body>
</html>