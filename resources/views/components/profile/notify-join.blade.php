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

<div class="modal fade" id="joinAktivateModal" tabindex="-1" role="dialog" aria-labelledby="joinAktivateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="joinAktivateModalLabel">Join Benachrichtigungen aktivieren</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="activateJoinInput" class="col-form-label">Join Key:</label>
                        <input id="activateJoinInput" type="text" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Abrechen</button>
                <button type="button" id="storeJoinBtn" class="btn btn-primary">Join Aktivieren</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="joinDeaktivateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Join Benachrichtigungen Deaktivieren?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Sollen wirklich die Benachrichtigungen über Join deaktiviert werden? Dadurch wird dein API Key aus unserem System gelöscht.</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('profile.deleteJoin') }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Ja, API Key löschen</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Nein</button>
                </form>
            </div>
        </div>
    </div>
</div>
