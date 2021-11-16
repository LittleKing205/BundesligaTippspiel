@push('meta')
    <meta name="store-join-url" content="{{ route('profile.storeJoin') }}">
@endpush

<div class="row mb-4">
    <div class="col-7"><a href="https://play.google.com/store/apps/details?id=com.joaomgcd.join" target="_blank">Join</a> (Andoroid App)</div>
    <div class="col-5">
        @if($enabled)
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#joinDeaktivateModal">Join Deaktivieren</button>
        @else
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#joinAktivateModal">Join Aktivieren</button>
        @endif
    </div>
</div>

@push('modal')
    <x-util.modal id="joinAktivateModal" title="Join Benachrichtigungen aktivieren">
        <x-slot name="body">
            <form>
                <div class="form-group">
                    <label for="activateJoinInput" class="col-form-label">Join Key:</label>
                    <input id="activateJoinInput" type="text" class="form-control">
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abrechen</button>
            <button type="button" id="storeJoinBtn" class="btn btn-primary">Join Aktivieren</button>
        </x-slot>
    </x-util.modal>
@endpush

@push('modal')
    <x-util.modal id="joinDeaktivateModal" title="Join Benachrichtigungen Deaktivieren?" action="{{ route('profile.deleteJoin') }}" method="delete">
        <x-slot name="body">
            <p>Sollen wirklich die Benachrichtigungen über Join deaktiviert werden? Dadurch wird dein API Key aus unserem System gelöscht.</p>
        </x-slot>
        <x-slot name="footer">
            <button type="submit" class="btn btn-danger">Ja, API Key löschen</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nein</button>
        </x-slot>
    </x-util.modal>
@endpush
