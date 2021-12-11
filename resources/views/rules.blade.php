@extends('layouts.app')

@section('title', 'Regeln')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Regeln</li>
@endsection

@section('content')
    <div class="row">
        <x-util.card size="col-xl-6 col-md-12 mb-3" title="Regelwerk / Spielablauf">
            <x-slot name="body">
                <ol>
                    <li>Getippt wird jedes Spiel der ersten und zweiten Bundesliga.</li>
                    <li>Die Spiele können bis zwei Stunden vor Anpfiff getippt werden.</li>
                    <li>Getippt wird auf Heimsieg, Auswärtssieg oder Unentschieden.</li>
                    @if (Auth::user()->currentGroup->payment_enabled)
                        <li>Jedes <u>FALSCH</u> getippte Spiel kostet 0,50 €.</li>
                        <li>Jedes <u>NICHT</u> getippte Spiel kostet 1,00 €.</li>
                        <li>Die Abrechnung erfolgt nach beendigung des aktuellen Spieltages der jeweiligen Bundesliga.</li>
                    @endif
                </ol>
            </x-slot>
        </x-util.card>
    </div>

    <div class="row">
        <x-util.card size="col-12 mb-3" title="Tipp Box Beispiele (Legende)">
            <x-slot name="body">
                <div class="row">
                    <x-util.card size="col-12 mb-3">
                        <x-slot name="body">
                            Hier kann man alle verschiedenen Farbkombinationen einer Tippbox betrachten. Die jeweiligen Farben der Knöpfe könen in den <a href="{{ route('profile') }}">Profileinstellungen</a> geändert werden.
                        </x-slot>
                    </x-util.card>
                </div>
                <div class="row">
                    <x-rules.open :match="$match" :colors="$colors"/>
                    <x-rules.closed :match="$match" :colors="$colors"/>
                </div>

                <div class="row">
                    <x-rules.played-right-tipp :match="$match" :colors="$colors"/>
                    <x-rules.played-wrong-tipp :match="$match" :colors="$colors"/>
                    <x-rules.played-no-tipp :match="$match" :colors="$colors"/>
                </div>
            </x-slot>
        </x-util.card>
    </div>
@endsection
