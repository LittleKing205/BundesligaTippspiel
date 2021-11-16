@extends('layouts.app')

@section('title', 'Testseite')

@section('breadcump')
<li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="{{ route('group-admin') }}">Gruppen Administration</a></li>
<li class="breadcrumb-item active"><a href="{{ route('group-admin.users') }}">Spielerverwatung</a></li>
<li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
    <div class="row">
        <x-util.card title="User Permissions" >
            <x-slot name="body">
                {{ $user->getRoleNames()->implode(', ') }}
            </x-slot>
        </x-util.card>
    </div>
@endsection
