<div class="modal fade" id="switchGroupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tippgemeinschaft wechseln</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('group.modal-form') }}" method="post">
                <div class="modal-body">
                    <p></p>
                    <div class="input-group mb-3">
                        <button name="btn" value="switch" class="btn btn-outline-success" type="submit">Gruppe wechelsn zu:</button>
                        <select name="switched-group" class="form-select" id="inputGroupSelect02">
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" @if(Auth::user()->currentGroup->id == $group->id) selected disabled @endif >{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                        @csrf
                        @method('post')
                        <!--<button type="submit" name="btn" value="switch" class="btn btn-danger">Gruppe weshseln</button>-->
                        <button type="submit" name="btn" value="add" class="btn btn-info">Neue Gruppe erstellen</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                </div>
            </form>
        </div>
    </div>
</div>
