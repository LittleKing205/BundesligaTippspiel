<li class="nav-item" role="presentation">
    <button class="nav-link @if(isset($active)) active @endif " id="inviteTabText{{ $slot }}-tab" data-bs-toggle="pill" data-bs-target="#inviteTabText{{ $slot }}" type="button" role="tab" aria-controls="inviteTabText{{ $slot }}" aria-selected="true">{{ $slot }}</button>
</li>
