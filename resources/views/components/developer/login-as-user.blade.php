<x-util.card size="col-xl-3 col-md-6" title="Login als User">
    @if (!Session::get('devIsLoggedInAsDifferentUser', false))
        <form action="{{ route('dev.login_as_user') }}" method="post">
            @csrf
            <div class="form-group row mb-3">
                <label for="inputUserpicker" class="col-sm-4 col-form-label">Benutzer: </label>
                <div class="col-sm-8">
                    <select name="user" class="form-select" id="inputUserpicker" aria-label="select">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-success col-sm-10">Login</button>
            </div>
        </form>
    @else
        You are Already a different user
    @endif
</x-util.card>
