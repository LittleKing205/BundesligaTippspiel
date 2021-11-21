<div class="row">
    <x-util.card title="Spielerliste">
        <x-slot name="body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Spielername</th>
                        <th>E-Mail</th>
                        <th>Rollen</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users->sortBy('name') as $user)
                        <tr>
                            {{--<td><a href="{{ route('group-admin.user', ['user' => $user->username]) }}">{{ $user->name }}</a></td>--}}
                            <td>{{ $user->name }} @if($user->id == Auth::user()->currentGroup->owner_id) <i class="fas fa-star text-warning"></i> @endif </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->id == Auth::user()->currentGroup->owner_id)
                                    <span class="badge bg-secondary p-2">Gruppen Admin (Alle Berechtigungen)</span>
                                @else
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#userAddRole{{ $user->username }}"><i class="fas fa-plus"></i></button>
                                @endif
                                @foreach ($user->getRoleNames() as $role)
                                    <span class="badge bg-secondary p-2">{{ $role }} <a href="#" data-toggle="modal" data-target="#userRemoveRole{{ $user->username }}" class="text-white ms-3"><i class="fas fa-times"></i></a></span>
                                    @push('modal') {{--  Delete Role Modal--}}
                                        <x-util.modal id="userRemoveRole{{ $user->username }}" title="Rolle dem User entfernen?" action="{{ route('group-admin.users.delete-role') }}" method="delete">
                                            <x-slot name="body">
                                                <p>
                                                    Bla Bla
                                                </p>
                                            </x-slot>
                                            <x-slot name="footer">
                                                <input type="hidden" name="user" value="{{ $user->username }}" />
                                                <input type="hidden" name="role" value="{{ $role }}" />
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                                                <button type="submit" class="btn btn-danger">Löschen</button>
                                            </x-slot>
                                        </x-util.modal>
                                    @endpush
                                @endforeach
                            </td>
                            <td>
                                @if($user->id != Auth::user()->currentGroup->owner_id)
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#userKickModal{{ $user->username }}"><i class="fas fa-ban"></i></button>
                                @endif
                                {{--<button type="button" class="btn btn-warning"><i class="fas fa-exchange-alt"></i></button>--}}
                            </td>
                        </tr>

                        @push('modal')
                            <x-util.modal id="userAddRole{{ $user->username }}" title="" action="{{ route('group-admin.users.add-role') }}" method="put">
                                <x-slot name="body">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Example select</label>
                                        <select name="role" class="form-control" id="exampleFormControlSelect1">
                                            @foreach ($roles as $role)
                                                <option>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </x-slot>
                                <x-slot name="footer">
                                    <input type="hidden" name="user" value="{{ $user->username }}" />
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                                    <button type="submit" class="btn btn-success">Hinzufügen</button>
                                </x-slot>
                            </x-util.modal>

                            <x-util.modal id="userKickModal{{ $user->username }}" title="User Kicken" action="{{ route('group-admin.users.kick') }}" method="delete">
                                <x-slot name="body">
                                    <p>
                                        Soll der Benutzer "{{ $user->name }}" wrklich aus dieser Gruppe gekickt werden?
                                    </p>
                                </x-slot>
                                <x-slot name="footer">
                                    <input type="hidden" name="user" value="{{ $user->username }}" />
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                                    <button type="submit" class="btn btn-danger">Jep, Kicken</button>
                                </x-slot>
                            </x-util.modal>
                        @endpush
                    @endforeach
                </tbody>
            </table>
        </x-slot>
    </x-util.card>
</div>
