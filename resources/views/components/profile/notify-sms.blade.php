@push('meta')
    <meta name="get-sms-token-url" content="{{ route('profile.getSmsToken') }}">
    <meta name="store-number-url" content="{{ route('profile.storeNumber') }}">
@endpush

<div class="row mb-4">
    <div class="col-7">SMS Benachrichtigung</div>
    <div class="col-5">
        @if($enabled)
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#smsDeaktivateModal">SMS Deaktivieren</button>
        @else
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#smsAktivateModal">SMS Aktivieren</button>
        @endif
    </div>
</div>

@push('modal')
    <x-util.modal id="smsAktivateModal" title="SMS Benachrichtigungen aktivieren">
        <x-slot name="body">
            <form>
                <div class="form-group">
                    <label for="telefonNummer" class="col-form-label">Handynummer:</label>
                    <input id="activateTelefonNummerInput" type="tel" class="form-control">
                </div>
                <div class="form-group d-none" id="telefonnummerConfirmTokenField">
                    <label for="checkToken" class="col-form-label">SMS Token:</label>
                    <input type="number" class="form-control" id="checkToken">
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abrechen</button>
            <button type="button" id="activateSmsSendTokenBtn" class="btn btn-primary">Sende SMS</button>
            <button type="button" id="storeNumberBtn" class="btn btn-primary d-none">SMS Aktivieren</button>
        </x-slot>
    </x-util.modal>
@endpush

@push('modal')
    <x-util.modal id="smsDeaktivateModal" title="SMS Benachrichtigungen Deaktivieren?" action="{{ route('profile.deleteNumber') }}" method="delete">
        <x-slot name="body">
            <p>Sollen wirklich die SMS Benachrichtigungen deaktiviert werden? Dadurch wird deine Nummer aus unserem System gelöscht.</p>
        </x-slot>
        <x-slot name="footer">
            <button type="submit" class="btn btn-danger">Ja, Nummer löschen</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nein</button>
        </x-slot>
    </x-util.modal>
@endpush
