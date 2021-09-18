@if (session()->has('success'))
    <div class="alert alert-success mt-2" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('danger'))
    <div class="alert alert-danger mt-2" role="alert">
        {{ session('danger') }}
    </div>
@endif

@if ($errors->any())
    @foreach ( $errors->all() as $error )
        <div class="alert alert-danger mt-2" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif
