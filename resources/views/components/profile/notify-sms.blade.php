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

<div class="modal fade" id="smsAktivateModal" tabindex="-1" role="dialog" aria-labelledby="smsAktivateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smsAktivateModalLabel">SMS Benachrichtigungen aktivieren</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Abrechen</button>
                <button type="button" id="activateSmsSendTokenBtn" class="btn btn-primary">Sende SMS</button>
                <button type="button" id="storeNumberBtn" class="btn btn-primary d-none">SMS Aktivieren</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="smsDeaktivateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SMS Benachrichtigungen Deaktivieren?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Sollen wirklich die SMS Benachrichtigungen deaktiviert werden? Dadurch wird deine Nummer aus unserem System gelöscht.</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('profile.deleteNumber') }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Ja, Nummer löschen</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Nein</button>
                </form>
            </div>
        </div>
    </div>
</div>
