<div class="tab-pane fade show active" id="inviteTabTextSMS" role="tabpanel" aria-labelledby="inviteTabTextSMS-tab">
    <div class="mb-3">
        <h2 cllass="h2">Spieler per SMS einladen</h2>
    </div>
    <form action="{{ route('group-admin.invite') }}" method="post">
        @csrf
        @method('post')
        <input type="hidden" name="channel" value="SMS">
        <div class="form-group mb-4 row">
            <label for="inputInvitedSmsNumber" class="col-sm-2 col-form-label">Nummer</label>
            <div class="col-sm-10">
                <input type="number" name="to" class="form-control" id="inputInvitedSmsNumber" placeholder="Handy Nummer">
            </div>
        </div>

        <div class="float-end">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
            <button type="submit" class="btn btn-success">Einladungslink senden</button>
        </div>
    </form>
</div>
