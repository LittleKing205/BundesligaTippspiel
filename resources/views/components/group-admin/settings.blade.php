<div class="row">
    <x-util.card title="Einstellungen">
        <x-slot name="body">
            <div class="row">
                <div class="col-12 col-xl-4 mb-3 p-4">
                    <p>
                        BLABLABLABLABLABLABLABLABLABLABLABLABLABLABLABLABLABLABLA
                    </p>
                </div>
                <div class="col-12 col-xl-8 mb-3">
                    <form action="{{ route('group-admin.save-settings') }}" method="post">
                        @csrf
                        @method('patch')

                        <div class="form-group mb-3 row">
                            <label for="inputGroupName" class="col-sm-2 col-form-label">Tippgruppen Name</label>
                            <div class="col-sm-10">
                                <input name="name" type="text" step="0.01" class="form-control" id="inputGroupName" placeholder="Falscher Tipp" value="{{ $group->name }}">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputEnableInvites" class="col-sm-2 col-form-label">Einladungen</label>
                            <div class="col-12 col-sm-3 mb-2">
                                <select name="invites_enabled" class="form-select" id="inputEnableInvites" aria-label="select">
                                    <option value="1" @if($group->invites_enabled) selected @endif>Eingeschaltet</option>
                                    <option value="0" @if(!$group->invites_enabled) selected @endif>Ausgeschaltet</option>
                                </select>
                            </div>
                            <div class="col-10 col-sm-6">
                                <input type="text" class="form-control" placeholder="Invite Code" readonly value="{{ $group->invite_code }}">
                            </div>
                            <div class="col-2 col-sm-1">
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#changeInviteCodeModal"><i class="fas fa-sync-alt"></i></button>
                                @push('modal')
                                    <x-util.modal id="changeInviteCodeModal" title="Einladungscode zurücksetzen?" action="{{ route('group-admin.change-invite-code') }}" method="patch">
                                        <x-slot name="body">
                                            Soll der Einladungscode neu erstellt werden?<br />
                                            Jeder mit dem dem Aktuellen Code wird nicht mehr in der lage sein, in deine Gruppe einzutreten!
                                        </x-slot>
                                        <x-slot name="footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                                            <button type="submit" class="btn btn-danger">Ja, bitte ändern</button>
                                        </x-slot>
                                    </x-util.modal>
                                @endpush
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputEnablePot" class="col-sm-2 col-form-label">Preisgelder</label>
                            <div class="col-sm-10 mb-2">
                                <select name="payment_enabled" class="form-select" id="inputEnablePot" aria-label="select">
                                    <option value="1" @if($group->payment_enabled) selected @endif>Eingeschaltet</option>
                                    <option value="0" @if(!$group->payment_enabled) selected @endif>Ausgeschaltet</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputWrongPot" class="col-sm-2 col-form-label">Falscher Tipp Preisgeld</label>
                            <div class="col-sm-10">
                                <input name="wrong_tipp" type="text" step="0.01" class="form-control" id="inputWrongPot" placeholder="Falscher Tipp" value="{{ number_format($group->wrong_tipp , 2, ",", ".") }}" @if(!$group->payment_enabled) disabled @endif>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="inputNotTipped" class="col-sm-2 col-form-label">Kein Tipp Preisgeld</label>
                            <div class="col-sm-10">
                                <input name="not_tipped" type="text" step="0.01" class="form-control" id="inputNotTipped" placeholder="Nicht Getipped" value="{{ number_format($group->not_tipped , 2, ",", ".") }}" @if(!$group->payment_enabled) disabled @endif>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Speichern</button>
                    </form>
                </div>
        </x-slot>
    </x-util.card>
</div>
