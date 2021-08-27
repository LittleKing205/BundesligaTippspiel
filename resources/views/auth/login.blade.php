<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin Template for Bootstrap</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/login-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body class="text-center">
<form method="POST" action="{{ route('login') }}" class="form-signin">
    @csrf

    <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.login_title') }}</h1>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <h5 class="text-danger">{{ $error }}</h5>
        @endforeach
    @endif
    <label for="inputEmail" class="sr-only">{{ __('auth.email_field') }}</label>
    <input type="text" id="inputEmail" name="email" class="form-control" placeholder="{{ __('auth.email_field') }}" value="{{ old('email') }}" required autofocus>

    <label for="inputPassword" class="sr-only">{{ __('auth.password_field') }}</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="{{ __('auth.password_field') }}" required>

    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" name="remember"> {{ __('auth.remember_me') }}
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('auth.login_btn') }}</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
</form>
</body>
</html>
