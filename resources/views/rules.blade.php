@extends('layouts.app')

@section('title', 'Regeln')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Regeln</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6 col-md-12 mb-3">
            <div class="card">
                <h5 class="card-header">Regelwerk / Spielablauf</h5>
                <div class="card-body">
                    <ol>
                        <li>Getippt wird jedes Spiel der ersten und zweiten Bundesliga.</li>
                        <li>Die Spiele können bis zwei Stunden vor Anpfiff getippt werden.</li>
                        <li>Getippt wird auf Heimsieg, Auswärtssieg oder Unentschieden.</li>
                        <li>Jedes <u>FALSCH</u> getippte Spiel kostet 0,50 €.</li>
                        <li>Jedes <u>NICHT</u> getippte Spiel kostet 1,00 €.</li>
                        <li>Die Abrechnung erfolgt nach beendigung des aktuellen Spieltages der jeweiligen Bundesliga.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
