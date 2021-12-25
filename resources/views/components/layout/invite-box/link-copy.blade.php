<div class="tab-pane fade" id="inviteTabTextLink" role="tabpanel" aria-labelledby="inviteTabTextLink-tab">
    <div class="mb-3">
        <h2 cllass="h2">Spieler per Link einladen</h2>
    </div>
    <form>
        @csrf
        @method('post')
        <input type="hidden" name="channel" value="SMS">
        <div class="form-group mb-4 row">
            <label for="inputInvitedSmsNumber" class="col-sm-2 col-form-label">Link</label>
            <div class="col-sm-10">
                <input type="text" name="to" class="form-control" id="inputInvitedSmsNumber" value="{{ route('register', ['invite' => Auth::user()->currentGroup->invite_code]) }}" disabled>
            </div>
        </div>

        <div class="float-end">
            <button type="button" class="btn btn-success" data-dismiss="modal">Schließen</button>
        </div>
    </form>
</div>
