@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.login_title') }}</h1>
        <h2 class="h3 mb-3 font-weight-normal">Passwort Reset</h2>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <h5 class="text-danger">{{ $error }}</h5>
            @endforeach
        @endif

        <label for="inputEmail" class="sr-only">{{ __('auth.email_field') }}</label>
        <input type="text" id="inputEmail" name="email" class="form-control mb-3 @error('email') is-invalid @enderror" " placeholder="{{ __('auth.email_field') }}" value="{{ old('email') }}" required autofocus autocomplete="email" >

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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
