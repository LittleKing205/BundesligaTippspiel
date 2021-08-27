<div class="col-xl-3 col-md-6">
    <div class="card bg-{{ $statusColor }} text-white mb-4">
        <div class="card-header">
            {{ $league }}. Bundesliga
        </div>
        <div class="card-body">
            Du hast <b>{{ $tippCount }}</b> von <b>{{ $gameCount }}</b> Spiele für den aktuellen Spieltag getippt.<br />
            @if($gamesPlayed > 0)
                Aktuell hast du <b>{{ $tippsRight }}</b> von <b>{{ $gamesPlayed }}</b> Spielen richtig.
            @endif
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="{{ route('tipps', ['league' => $league, 'day' => $currentDay]) }}">{{ $currentDay }}. Spieltag Anzeigen</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
