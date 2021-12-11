@extends('layouts.app')

@section('title', 'Gruppen Einstellungen')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Gruppen Einstellungen</li>
@endsection

@section('content')
    <x-group-admin.settings />
    <x-group-admin.users />
    <x-group-admin.roles />
@endsection
