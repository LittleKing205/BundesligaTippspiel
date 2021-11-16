<x-util.card size="col-xl-6 col-md-6 mb-3" title="Spiel Gesperrt // Getippt für {{ $match->team1->name }}" small-title>
    <x-slot name="body">
        <p>
            <div align="center">
                Anpfiff: <b>{{ $match->match_start->format('H:i') }}</b>
            </div>
            <div class="d-flex justify-content-around">
                <div align="center">
                    <div width="60px" height="60px"><img height="60px" src="{{ $match->team1->badge }}" /></div>
                    <div>{{ $match->team1->name }}</div>
                </div>
                <div align="center">
                    <div width="60px" height="60px"><img height="60px" src="{{ $match->team2->badge }}" /></div>
                    <div>{{ $match->team2->name }}</div>
                </div>
            </div>
        </p>
    </x-slot>
    <x-slot name="footer" class="d-flex justify-content-around">
        <button type="button" class="btn btn-{{ $colors["user_tipp"] }} px-xl-5 px-4" disabled><i class="fas fa-plus"></i></button>
        <button type="button" class="btn btn-{{ $colors["default_locked"] }} px-xl-5 px-4" disabled><i class="fas fa-equals"></i></button>
        <button type="button" class="btn btn-{{ $colors["default_locked"] }} px-xl-5 px-4" disabled><i class="fas fa-plus"></i></button>
    </x-slot>
</x-util.card>
