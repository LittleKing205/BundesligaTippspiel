<div class="row">
    <x-util.card title="Rollen Einstellungen">
        <x-slot name="body">
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#newRoleModal">Neue Rolle erstellen</button>
            @push('modal')
                <x-util.modal size="xl" id="newRoleModal" title="Neue Rolle erstellen" action="{{ route('group-admin.roles.create') }}" method="put">
                    <x-slot name="body">
                        <div class="mb-3">
                            <label class="form-label"  for="newRoleNameInput">Neuer Rollen Name:</label>
                            <input class="form-control" id="newRoleNameInput" name="name" placeholder="Rollen Name" />
                        </div>
                        <x-group-admin.permission-checkboxes />
                    </x-slot>
                    <x-slot name="footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-success">Speichern</button>
                    </x-slot>
                </x-util.modal>
            @endpush

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
                            <td><a href="#" data-toggle="modal" data-target="#rolePermissionModal{{ $role->id }}">{{ $role->name }}</a></td>
                            <td>
                                @foreach ($role->getPermissionNames() as $permission)
                                    <span class="badge bg-secondary p-2">{{ __('permission_names.'.$permission) }}</span>
                                @endforeach
                            </td>
                        </tr>

                        @push('modal')
                            <x-util.modal size="xl" id="rolePermissionModal{{ $role->id }}" title="Rolle {{ $role->name }} Bearbeiten" action="{{ route('group-admin.roles.save') }}" method="patch">
                                <x-slot name="body">
                                    <input type="hidden" name="role" value="{{ $role->id }}">
                                    <input type="hidden" name="permissions[]" value="EMPTY-PERMISSION">
                                    <x-group-admin.permission-checkboxes :role="$role"/>
                                </x-slot>
                                <x-slot name="footer">
                                    <button type="button" class="btn btn-danger me-auto roleDeleteBtn" data-dismiss="modal" data-role="{{ $role->name }}">Löschen</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
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

@push('modal')
    <x-util.modal id="deleteRoleModal" title="Rolle Löschen?" action="{{ route('group-admin.roles.delete') }}" method="delete">
        <x-slot name="body">
            Soll die Rolle "<span id="deleteRoleModalRoleText"></span>" wirklich gelöscht werden?
        </x-slot>
        <x-slot name="footer">
            <input type="hidden" name="role" value="" id="deleteRoleModalRoleInput" />
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
            <button type="submit" class="btn btn-danger">Ja, Löschen</button>
        </x-slot>
    </x-util.modal>
@endpush

@push('script')
    <script>
        $('.roleDeleteBtn').click(function() {
            $('#deleteRoleModalRoleText').text($(this).data('role'));
            $('#deleteRoleModalRoleInput').val($(this).data('role'));
            $('#deleteRoleModal').modal('show');
        });
    </script>
@endpush
