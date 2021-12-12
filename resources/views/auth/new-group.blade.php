@extends('layouts.guest')

@section('content')
    <div id="newGroup">
        <form method="POST" action="{{ route('group.new.create') }}" class="form-signin">
            <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal">Neue Tippgemeinschaft erstellen</h1>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <h5 class="text-danger">{{ $error }}</h5>
                @endforeach
            @endif

            <Button class="mb-5 btn btn-lg btn-primary btn-block btn-switch-mode">Einer Gruppe beitreten</Button>

            <label for="inputName" class="sr-only">Name</label>
            <input type="text" id="inputName" name="name" class="form-control" value="{{ old('name') }}" placeholder="Gruppen name" required autofocus>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Erstellen</button>

            @if (!is_null(Auth::user()->current_group_id))
                <a class="btn btn-lg btn-danger btn-block" href="{{ URL::previous() }}">Abbrechen</a>
            @endif

            <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
        </form>
    </div>

    <div id="enterGroup" style="display: none">
        <form method="POST" action="{{ route('group.enter') }}" class="form-signin">
            <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal">Einer Gruppe Beitreten</h1>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <h5 class="text-danger">{{ $error }}</h5>
                @endforeach
            @endif

            <Button class="mb-5 btn btn-lg btn-primary btn-block btn-switch-mode">Eine Tippgemeinschaft erstellen</Button>

            <label for="inputName" class="sr-only">Einladungs Code</label>
            <input type="text" id="inputName" name="invite_code" class="form-control" value="{{ old('name') }}" placeholder="Einladungs Code" required autofocus>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Beitreten</button>

            @if (!is_null(Auth::user()->current_group_id))
                <a class="btn btn-lg btn-danger btn-block" href="{{ route('dashboard') }}">Abbrechen</a>
            @endif

            <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
        </form>
    </div>
@endsection

@push('script')
    <script>
        jQuery(document).ready(function($){
            $(".btn-switch-mode").click(function(e) {
                e.preventDefault();
                $("#enterGroup").toggle();
                $("#newGroup").toggle();
            });
        });
    </script>
@endpush
