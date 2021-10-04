<div class="sb-sidenav-menu-heading">{{ __('messages.sidebar.sites') }}</div>
<a class="nav-link" href="{{ route('dashboard') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
    Dashboard
</a>
<a class="nav-link" href="{{ route('statistics') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
    Statistiken
</a>
<a class="nav-link" href="{{ route('rules') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
    Regeln
</a>

@foreach([1, 2] as $league)
    <div class="sb-sidenav-menu-heading">{{ $league }}. Bundesliga</div>
    <a class="nav-link" href="{{ route('tippsWithoutDay', ['league' => $league]) }}">
        <div class="sb-nav-link-icon"><i class="fas fa-pencil-alt"></i></div>
        Tippen
    </a>
    <!--<a class="nav-link" href="#">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
        Tabelle
    </a>-->
@endforeach
