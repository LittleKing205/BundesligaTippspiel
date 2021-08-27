@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcump')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <x-dashboard-current-day league="1" />
        <x-dashboard-current-day league="2" />
    </div>

    <div class="row">
        <x-dashboard-last-day-table league="1" />
        <x-dashboard-last-day-table league="2" />
    </div>
@endsection
