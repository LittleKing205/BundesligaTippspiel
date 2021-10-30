@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.login_title') }}</h1>
        <h2 class="h3 mb-3 font-weight-normal">Passwort Reset</h2>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <h5 class="text-danger">{{ $error }}</h5>
            @endforeach
        @endif

        <label for="inputEmail" class="sr-only">{{ __('auth.email_field') }}</label>
        <input type="email" id="inputEmail" name="email" class="form-control @error('email') is-invalid @enderror" " placeholder="{{ __('auth.email_field') }}" value="{{ old('email') }}" required autofocus autocomplete="email" >

        <label for="inputPassword" class="sr-only">{{ __('auth.password_field') }}</label>
        <input type="password" id="inputPassword" name="password" class="form-control @error('password') is-invalid @enderror" " placeholder="{{ __('auth.password_field') }}" required autocomplete="new-password" >

        <label for="inputPassword-confirm" class="sr-only">Passwort Wiederholen</label>
        <input type="password" id="inputPassword-confirm" name="password-confirm" class="form-control mb-3 @error('password') is-invalid @enderror" " placeholder="Passwort Wiederholen" required autocomplete="new-password" >

        <button class="btn btn-lg btn-primary btn-block" type="submit">Zurücksetzen</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
    </form>
@endsection

<!--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
-->
