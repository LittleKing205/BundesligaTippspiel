@extends('layouts.app')

@section('title', 'Spielerverwatung')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('group-admin') }}">Gruppen Administration</a></li>
    <li class="breadcrumb-item active">Spielerverwatung</li>
@endsection

@section('content')
    <div class="row">
        <x-util.card title="Spielerliste">
            <x-slot name="body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Spielername</th>
                            <th>E-Mail</th>
                            <th>Rollen</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users->sortBy('name') as $user)
                            <tr>
                                {{--<td><a href="{{ route('group-admin.user', ['user' => $user->username]) }}">{{ $user->name }}</a></td>--}}
                                <td><a href="#" data-toggle="modal" data-target="#userPermissionModal{{ $user->id }}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->getRoleNames() as $role)
                                        <span class="badge bg-secondary">{{ $role }}</span>
                                    @endforeach
                                </td>
                            </tr>

                            @push('modal')
                                <x-util.modal id="userPermissionModal{{ $user->id }}" title="Benutzer Rollen Bearbeiten">
                                    <x-slot name="body">
                                        Hallo {{ $user->name }}
                                    </x-slot>
                                </x-util.modal>
                            @endpush
                        @endforeach
                    </tbody>
                </table>
            </x-slot>
        </x-util.card>
    </div>
@endsection
