@extends('layouts.app')

@section('title', 'Profil Einstellungen')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
    <div class="card mb-3">
        <h4 class="card-header">Profil</h4>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-xl-4 mb-3 p-4">
                    <p>
                        Hier kann der Name, die E-Mail Adresse und das Passwort geändert werden.
                        Das Passwort Feld kann frei bleiben, wenn das Passwort nicht geändert werden soll.
                    </p>
                </div>
                <div class="col-12 col-xl-8 mb-3">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="form-group mb-3 row">
                            <label for="inputUsername" class="col-sm-2 col-form-label">Benutzername</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputUsername" placeholder="Benutzername" readonly value="{{ $user->username }}">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="inputDisplayName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input name="name" type="text" class="form-control" id="inputDisplayName" placeholder="Name" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Passwort</label>
                            <div class="col-sm-10">
                                <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Passwort" value="">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="inputPasswordConfirm" class="col-sm-2 col-form-label">Passwort Wiederholen</label>
                            <div class="col-sm-10">
                                <input name="password_confirmation" type="password" class="form-control" id="inputPasswordConfirm" placeholder="Passwort" value="">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Speichern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <h4 class="card-header">Benachrichtigungen</h4>
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
                    @if(config('firebase.enable'))
                        <br />
                        <b>!!!ACHTUNG!!!</b><br />
                        Der WebPush ist leider noch etwas Fehlerbehaftet. Ich arbeite noch daran, dass es besser funktioniert.
                    @endif
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
    <div class="card mb-3">
        <h4 class="card-header">Tipp Button Farben ändern</h4>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-xl-4 mb-3">
                    <p>
                        Hier können die Farbgebungen der jeweiligen Buttons abgeändert werden. Die Buttons werden nach Aufsteigender Priorität gefärbt bzw. überschrieben.<br />
                        Die aktuellen Einstellungen können <a href="{{ route('rules') }}">hier</a> mit Beispielen eingesehen werden.
                    </p>
                    <ul>
                        <li>
                            <b>Standart Farbe / Gesperrter Button</b>:<br />
                            Jeder Button wird mit dieser Farbe versehen. Hier kann man auswählen, welche Farbe ein Button haben soll, wenn ein Spiel gesperrt ist oder noch getippt werden kann.
                        </li>
                        <li>
                            <b>Getippter Button</b>:<br />
                            Diese Farbe wird gesetzt, ein Tipp für das jeweilige Spiel vorliegt.
                        </li>
                        <li>
                            <b>Spielergebnis</b>:<br />
                            Diese Farbe wird gesetzt, wenn das Spielergebnis dem Button entspricht.
                        </li>
                        <li>
                            <b>Falscher Tipp</b>:<br />
                            Diese Farbe wird für den Falsch abgesetzten Tipp gesetzt.
                        </li>
                        <li>
                            <b>Nicht getipptes Ergebnis</b>:<br />
                            Diese Farbe wird für das Ergenis eines Spiels gesetzt, wo kein Tipp abgegeben wurde.
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-xl-8 mb-3">
                    <form action="{{ route('profile.updateColors') }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="form-group mb-3 row">
                            <label for="inputDefaultColor" class="col-sm-2 col-form-label">Standart Farbe</label>
                            <div class="col-sm-10">
                                <select name="default" class="form-select" id="inputDefaultColor" aria-label="select">
                                    @foreach ($available_colors as $color_name => $color_value)
                                        <option value="{{ $color_value }}" @if($user_colors['default'] == $color_value) selected @endif>{{ $color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputDefaultLockedColor" class="col-sm-2 col-form-label">Gesperrter Button</label>
                            <div class="col-sm-10">
                                <select name="default_locked" class="form-select" id="inputDefaultLockedColor" aria-label="select">
                                    @foreach ($available_colors as $color_name => $color_value)
                                        <option value="{{ $color_value }}" @if($user_colors['default_locked'] == $color_value) selected @endif>{{ $color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputTippedColor" class="col-sm-2 col-form-label">Getippter Button</label>
                            <div class="col-sm-10">
                                <select name="user_tipp" class="form-select" id="inputTippedColor" aria-label="select">
                                    @foreach ($available_colors as $color_name => $color_value)
                                        <option value="{{ $color_value }}" @if($user_colors['user_tipp'] == $color_value) selected @endif>{{ $color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputGameResultColor" class="col-sm-2 col-form-label">Spielergebnis</label>
                            <div class="col-sm-10">
                                <select name="game_result" class="form-select" id="inputGameResultColor" aria-label="select">
                                    @foreach ($available_colors as $color_name => $color_value)
                                        <option value="{{ $color_value }}" @if($user_colors['game_result'] == $color_value) selected @endif>{{ $color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputUserWrongTippColor" class="col-sm-2 col-form-label">Falscher Tipp</label>
                            <div class="col-sm-10">
                                <select name="user_wrong_tipp" class="form-select" id="inputUserWrongTippColor" aria-label="select">
                                    @foreach ($available_colors as $color_name => $color_value)
                                        <option value="{{ $color_value }}" @if($user_colors['user_wrong_tipp'] == $color_value) selected @endif>{{ $color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputNotTippedColor" class="col-sm-2 col-form-label">Nicht getipptes Ergebnis</label>
                            <div class="col-sm-10">
                                <select name="not_tipped" class="form-select" id="inputNotTippedColor" aria-label="select">
                                    @foreach ($available_colors as $color_name => $color_value)
                                        <option value="{{ $color_value }}" @if($user_colors['not_tipped'] == $color_value) selected @endif>{{ $color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Speichern</button>
                    </form>
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
