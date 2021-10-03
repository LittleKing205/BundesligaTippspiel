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
