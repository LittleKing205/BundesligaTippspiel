@extends('layouts.app')

@section('title', 'Dashboard ('.Auth::user()->currentGroup->name.')')

@section('breadcump')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <x-dashboard.current-day-table league="1" />
        <x-dashboard.current-day-table league="2" />
        @if (Auth::user()->currentGroup->payment_enabled)
            <x-dashboard.statistics-box />
        @endif
    </div>

    <div class="row">
        <x-dashboard.last-day-table league="1" />
        <x-dashboard.last-day-table league="2" />
    </div>
@endsection
