<x-util.modal id="switchGroupModal" title="Tippgemeinschaft wechseln" action="{{ route('group.switch') }}">
    <x-slot name="body">
        <div class="input-group mb-3">
            <button name="btn" value="switch" class="btn btn-outline-success" type="submit">Gruppe wechelsn zu:</button>
            <select name="switched-group" class="form-select" id="inputGroupSelect02">
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}" @if(Auth::user()->currentGroup->id == $group->id) selected disabled @endif >{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
    </x-slot>
    <x-slot name="footer">
        <a href="{{ route('group.new.show') }}" class="btn btn-info">Neue Gruppe erstellen</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
    </x-slot>
</x-util.modal>
