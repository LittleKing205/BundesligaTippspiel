<a class="navbar-brand ps-3" href="{{ route('home') }}">Bundesliga Tippspiel</a>
<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
<!-- Navbar Search-->
<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    <div class="input-group"></div>
</form>
<!-- Navbar-->
<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            @if(Auth::user()->currentGroup->invites_enabled)
                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#invitePlayerModal">Spieler Einladen</a></li>
            @endif

            <li><a class="dropdown-item" href="{{ route('profile') }}">Profil Einstellungen</a></li>

            @can('group-admin')
                <li><a class="dropdown-item" href="{{ route('group-admin') }}">Gruppen Administration</a></li>
            @endcan

            @can('dev.edit_closed_games')
                <li><a class="dropdown-item" href="{{ route('dev.switch_tipp_mode') }}"><input type="checkbox" @if (Session::get('devTippMode', false))
                    checked
                @endif> Edit Closed Games</a></li>
            @endcan
            @if(Session::get('devIsLoggedInAsDifferentUser', false))
                <li><a href="{{ route('dev.login_as_user.back') }}" class="dropdown-item">Zurück zu {{ $backToUser->name }}</a></li>
            @endif
            @canany('dev.login_as_user')
                <li><a href="{{ route('dev') }}" class="dropdown-item">Entwickler Funktionen</a></li>
            @endcanany
            <li><hr class="dropdown-divider" /></li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
</ul>

@push('modal')
    <x-util.modal id="invitePlayerModal" title="Spieler einladen">
        <x-slot name="body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="inviteTabTextSms-tab" data-bs-toggle="pill" data-bs-target="#inviteTabTextSms" type="button" role="tab" aria-controls="inviteTabTextSms" aria-selected="true">SMS</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="inviteTabTextSms" role="tabpanel" aria-labelledby="inviteTabTextSms-tab">...</div>
                {{-- <div class="tab-pane fade show active" id="inviteTabTextEmail" role="tabpanel" aria-labelledby="inviteTabTextSms-tab">...</div> --}}
            </div>
        </x-slot>
    </x-util.modal>
@endpush
