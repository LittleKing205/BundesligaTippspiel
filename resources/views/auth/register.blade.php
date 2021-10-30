@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="form-signin">
        @csrf

        <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Bundeliga Tippspiel Registration</h1>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <h5 class="text-danger">{{ $error }}</h5>
            @endforeach
        @endif

        <label for="inputUsername" class="sr-only">Benutzername</label>
        <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Benutzername" required autofocus>

        <label for="inputName" class="sr-only">Anzeigename</label>
        <input type="text" id="inputName" name="name" class="form-control" placeholder="Anzeigename" required>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>

        <label for="inputPassword" class="sr-only">Password Confirmation</label>
        <input type="password" id="inputPassword" name="password_confirmation" class="form-control" placeholder="Password Confirmation" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Registrieren</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
    </form>
@endsection
