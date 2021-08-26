<button type="button" data-btnval="{{ $val }}" data-match="{{ $matchId }}" class="tipp_btn btn btn-{{ $state }} px-xl-5 px-4" @if($locked) disabled @endif>
    <i class="fas fa-{{ ($val == 0) ? 'equals' : 'plus' }}"></i>
</button>
