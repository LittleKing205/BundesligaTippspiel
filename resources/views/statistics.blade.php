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
@endsection
