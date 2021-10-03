@extends('layouts.app')

@section('title', 'Statistiken & Zahlungen')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Statistiken & Zahlungen</li>
@endsection

@section('content')
    <div class="row">
        <x-statistics.system-box />
    </div>

    <div class="row">
        <x-statistics.payment-table league="1" />
        <x-statistics.payment-table league="2" />
    </div>

    <x-statistics.payment-modal />
@endsection
