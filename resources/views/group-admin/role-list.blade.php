@extends('layouts.app')

@section('title', 'Spielerverwatung')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('group-admin') }}">Gruppen Administration</a></li>
    <li class="breadcrumb-item active">Rollen Verwaltung</li>
@endsection

@section('content')
    <div class="row">
        <x-util.card title="Rollen Liste">
            <x-slot name="body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Rolle</th>
                            <th>Berechtigungen</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($roles->sortBy('name') as $role)
                            <tr>
                                <td><a href="#" data-toggle="modal" data-target="#userPermissionModal{{ $role->id }}">{{ $role->name }}</a></td>
                                <td>
                                    @foreach ($role->getPermissionNames() as $permission)
                                        <span class="badge bg-secondary p-2">{{ __('permission_names.'.$permission) }}</span>
                                    @endforeach
                                </td>
                            </tr>

                            @push('modal')
                                <x-util.modal size="xl" id="userPermissionModal{{ $role->id }}" title="Rolle Bearbeiten" action="{{ route('group-admin.roles.save') }}" method="patch">
                                    <x-slot name="body">
                                        <input type="hidden" name="role" value="{{ $role->id }}">
                                        <input type="hidden" name="permissions[]" value="EMPTY-PERMISSION">

                                        <div><b>Administrations Berechtigungen:</b></div>
                                        <div class="ms-3">
                                            <x-util.checkbox id="{{ $role->id }}-adminSettingsShow-Ceckbox" name="permissions[]" value="admin.settings.show" checked="{{ $role->hasPermissionTo('admin.settings.show') }}">
                                                {{ __('permission_names.admin.settings.show') }}
                                            </x-util.checkbox>
                                            <x-util.checkbox id="{{ $role->id }}-adminEditRolesCeckbox" name="permissions[]" value="admin.edit-roles" checked="{{ $role->hasPermissionTo('admin.edit-roles') }}">
                                                {{ __('permission_names.admin.edit-roles') }}
                                            </x-util.checkbox>
                                        </div>

                                        <div><b>Kassenwart Berechtigungen</b></div>
                                        <div class="ms-3">
                                            <x-util.checkbox id="{{ $role->id }}-treasurerShow-Ceckbox" name="permissions[]" value="treasurer.show" checked="{{ $role->hasPermissionTo('treasurer.show') }}">
                                                {{ __('permission_names.treasurer.show') }}
                                            </x-util.checkbox>
                                            <x-util.checkbox id="{{ $role->id }}-treasurerReject_payment-Ceckbox" name="permissions[]" value="treasurer.reject_payment" checked="{{ $role->hasPermissionTo('treasurer.reject_payment') }}">
                                                {{ __('permission_names.treasurer.reject_payment') }}
                                            </x-util.checkbox>
                                            <x-util.checkbox id="{{ $role->id }}-treasurerValidate_payment-Ceckbox" name="permissions[]" value="treasurer.validate_payment" checked="{{ $role->hasPermissionTo('treasurer.validate_payment') }}">
                                                {{ __('permission_names.treasurer.validate_payment') }}
                                            </x-util.checkbox>
                                        </div>

                                    </x-slot>
                                    <x-slot name="footer">
                                        <button type="submit" class="btn btn-success">Speichern</button>
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
