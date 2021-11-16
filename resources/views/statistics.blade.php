@extends('layouts.app')

@section('title', 'Statistiken & Zahlungen')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Statistiken & Zahlungen</li>
@endsection

@section('content')
    <div class="row">
        <x-statistics.system-box />
        <x-statistics.all-player-box />
        <x-statistics.player-box />
    </div>

    <div class="row">
        <x-statistics.payment-table league="1" />
        <x-statistics.payment-table league="2" />
    </div>
@endsection

@push('modal')
    <x-util.modal id="payment-modal" title="Als Bezahlt markieren?" action="{{ route('statistics.pay') }}">
        <x-slot name="body">
            <p>
                Zur vereinfachung für den Kassenwart, bitte den unten angegebenen Verwendungszweck verwenden.<br />
                Der Verwendungszweck und der Betrag wird Automatisch beim klicken kopiert, so kann man die Daten direkt in die Überweisung einfügen.
            </p>
            <p>
                Verwendungszweck:<br />
                <input class="payment-modal-verwendungszweck click-copy" value="1. Bundesliga // 5. Spieltag" />
            </p>
            <p>
                Betrag:<br />
                <input class="payment-modal-to-pay click-copy" value="5,50" /> €
            </p>
        </x-slot>
        <x-slot name="footer">
            <input class="payment-modal-bill-id" type="hidden" name="bill_id" value="" />
            <button type="submit" class="btn btn-success">Als Bezahlt markieren</button>
            <button type="button" class="btn btn-secondary" data-dismiss="payment-modal">Abbrechen</button>
        </x-slot>
    </x-util.modal>
@endpush
