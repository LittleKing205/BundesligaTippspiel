<div class="col-xl-3 col-md-6">
    <div class="card">
        <div class="card-header">Login als User</div>
        <div class="card-body">
            @if (!Session::get('devIsLoggedInAsDifferentUser', false))
                <form action="{{ route('dev.login_as_user') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="inputUserpicker" class="col-sm-4 col-form-label">Benutzer: </label>
                        <div class="col-sm-8">
                            <select name="user" class="form-select" id="inputUserpicker" aria-label="select">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="col-sm-12">Login</button>
                    </div>
                </form>
            @else
                Logout To Main User
            @endif
        </div>
    </div>
</div>
