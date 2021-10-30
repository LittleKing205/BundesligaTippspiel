@extends('layouts.app')

@section('title', 'Entwickler Funktionen')

@section('breadcump')
<li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Entwickler Funktionen</li>
@endsection

@section('content')
    <div class="row">
        <x-developer.login-as-user />
    </div>
@endsection
