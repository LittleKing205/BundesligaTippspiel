<div class="modal fade" id="switchGroupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tippgemeinschaft wechseln</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('group.switch') }}" method="post">
                <div class="modal-body">
                    <p>Sollen wirklich die Benachrichtigungen über Join deaktiviert werden? Dadurch wird dein API Key aus unserem System gelöscht.</p>
                </div>
                <div class="modal-footer">
                        @csrf
                        @method('post')
                        <button type="submit" class="btn btn-danger">Gruppe weshseln</button>
                        <button type="link" href="{{ route('group.add') }}" class="btn btn-danger">Neue Gruppe erstellen</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                </div>
            </form>
        </div>
    </div>
</div>
