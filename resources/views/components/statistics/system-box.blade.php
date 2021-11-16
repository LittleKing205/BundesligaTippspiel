<x-util.card size="mb-4 col-xl-4 col-md-12" title="Tippspiel in Zahlen">
    <x-slot name="body">
        <div class="row">
            <div class="col-6">Gespeicherte Spiele:</div>
            <div class="col-6">{{ $game_count }}</div>
        </div>
        <div class="row">
            <div class="col-6">Gespielte Spiele:</div>
            <div class="col-6">{{ $finished_games }}</div>
        </div>
        <div class="row">
            <div class="col-6">Gespeicherte Tipps:</div>
            <div class="col-6">{{ $tipp_count }}</div>
        </div>
    </x-slot>
</x-util.card>
