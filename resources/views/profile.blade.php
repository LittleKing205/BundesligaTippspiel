@extends('layouts.app')

@section('title', 'Profil Einstellungen')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profil</li>
@endsection

@push('meta')
    <meta name="get-sms-token-url" content="{{ route('profile.getSmsToken') }}">
    <meta name="store-number-url" content="{{ route('profile.storeNumber') }}">
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
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Passwort</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPassword3" placeholder="Passwort" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Passwort Wiederholen</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPassword3" placeholder="Passwort" value="">
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
                </div>
                <div class="col-12 col-xl-8 mb-3">
                    <div class="row">
                        <div class="col-7">SMS Benachrichtigung</div>
                        <div class="col-5">
                            @if(is_null($user->phone))
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#smsAktivateModal">SMS Aktivieren</button>
                            @else
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#smsDeaktivateModal">SMS Deaktivieren</button>
                            @endif
                        </div>
                    </div>
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

    <div class="modal fade" id="smsAktivateModal" tabindex="-1" role="dialog" aria-labelledby="smsAktivateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smsAktivateMModalLabel">SMS Benachrichtigungen aktivieren</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="telefonNummer" class="col-form-label">Handynummer:</label>
                            <input id="activateTelefonNummerInput" type="tel" class="form-control">
                        </div>
                        <div class="form-group d-none" id="telefonnummerConfirmTokenField">
                            <label for="checkToken" class="col-form-label">SMS Token:</label>
                            <input type="number" class="form-control" id="checkToken">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abrechen</button>
                    <button type="button" id="activateSmsSendTokenBtn" class="btn btn-primary">Sende SMS</button>
                    <button type="button" id="storeNumberBtn" class="btn btn-primary d-none">SMS Aktivieren</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="smsDeaktivateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SMS Benachrichtigungen Deaktivieren?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sollen wirklich die SMS Benachrichtigungen deaktiviert werden? Dadurch wird deine Nummer aus unserem System gelöscht.</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('profile.deleteNumber') }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Ja, Nummer löschen</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nein</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
