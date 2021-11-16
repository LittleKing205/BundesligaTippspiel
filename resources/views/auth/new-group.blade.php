@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('group.new.create') }}" class="form-signin">
        @csrf

        <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Neue Tippgemeinschaft erstellen</h1>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <h5 class="text-danger">{{ $error }}</h5>
            @endforeach
        @endif

        <label for="inputName" class="sr-only">Name</label>
        <input type="text" id="inputName" name="name" class="form-control" value="{{ old('name') }}" placeholder="Gruppen name" required autofocus>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Erstellen</button>

        @if (!is_null(Auth::user()->current_group_id))
            <a class="btn btn-lg btn-danger btn-block" href="{{ URL::previous() }}">Abbrechen</a>
        @endif

        <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
    </form>
@endsection
