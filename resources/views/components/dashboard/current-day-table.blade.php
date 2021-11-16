<x-util.card size="col-xl-3 col-md-6" color="{{ $statusColor }}" title="{{ $league }}. Bundesliga">
    <x-slot name="body">
        Du hast <b>{{ $tippCount }}</b> von <b>{{ $gameCount }}</b> Spiele für den aktuellen Spieltag getippt.<br />
        @if($gamesPlayed > 0)
            Aktuell hast du <b>{{ $tippsRight }}</b> von <b>{{ $gamesPlayed }}</b> Spielen richtig.
        @endif
    </x-slot>
    <x-slot name="link" href="{{ route('tipps', ['league' => $league, 'day' => $currentDay]) }}">{{ $currentDay }}. Spieltag Anzeigen</x-slot>
</x-util.card>
