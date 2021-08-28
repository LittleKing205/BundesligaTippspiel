@extends('layouts.app')

@section('title', 'Profil Einstellungen')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profil</li>
@endsection

@push('meta')
    <meta name="get-sms-token-url" content="{{ route('profile.getSmsToken') }}">
    <meta name="store-number-url" content="{{ route('profile.storeNumber') }}">
    <meta name="store-join-url" content="{{ route('profile.storeJoin') }}">
@endpush

@section('content')
    <div class="card mb-3">
        <div class="card-header">Profil</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-xl-4 mb-3 p-4">
                    Das Passwort Feld kann frei bleiben, wenn das Passwort nicht geändert werden soll.
                </div>
                <div class="col-12 col-xl-8 mb-3">
                    <form action="" method="POST">
                        @csrf
                        @method('post')
                        <div class="form-group row">
                            <label for="inputUsername" class="col-sm-2 col-form-label">Benutzername</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputUsername" placeholder="Benutzername" readonly value="{{ $user->username }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDisplayName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputDisplayName" placeholder="Name" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail" placeholder="Email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Passwort</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPassword" placeholder="Passwort" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPasswordConfirm" class="col-sm-2 col-form-label">Passwort Wiederholen</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPasswordConfirm" placeholder="Passwort" value="">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Speichern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">Benachrichtigungen</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-xl-4 mb-3 p-4">
                    Hier können die Benachrichtigungen eingerichtet werden.<br />
                    <br />
                    Benachrichtigt wird in folgenden Situationen:
                    <ul>
                        <li>3 Stunden bevor ein nicht getipptes Spiel gesperrt wird.</li>
                        <li>Wenn ein Spieltag zuende ist und alle Spieldaten vorhanden sind.</li>
                    </ul>
                    <br />
                    <b>!!!ACHTUNG!!!</b><br />
                    Der WebPush ist leider noch etwas Fehleranfällig und nicht 100% funktionel. Ich arbeite noch daran, dass es
                    zuverlässig arbeitet.
                </div>
                <div class="col-12 col-xl-8 mb-3">
                    @if(config('join_sms.enable'))
                        <x-profile.notify-sms :enabled="!is_null($user->phone)" />
                    @endif
                    @if(config('firebase.enable'))
                        <x-profile.notify-web :enabled="!is_null($user->device_key)" />
                    @endif
                    <x-profile.notify-join :enabled="!is_null($user->join_key)" />
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="card mb-3">
        <div class="card-header">Eingeloggte Geräte</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-xl-4 mb-3">

                </div>
                <div class="col-12 col-xl-8 mb-3">

                </div>
            </div>
        </div>
    </div>
    -->
@endsection
