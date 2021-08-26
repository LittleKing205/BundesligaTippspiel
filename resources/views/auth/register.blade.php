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
<form method="POST" action="{{ route('register') }}" class="form-signin">
    @csrf

    <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

    <label for="inputName" class="sr-only">Name</label>
    <input type="text" id="inputName" name="name" class="form-control" placeholder="Name" required autofocus>

    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>

    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>

    <label for="inputPassword" class="sr-only">Password Confirmation</label>
    <input type="password" id="inputPassword" name="password_confirmation" class="form-control" placeholder="Password Confirmation" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
</form>
</body>
</html>
