<div id="{{ $match->id }}" class="col-xl-6 col-md-6 mb-3">
    <div class="card">
        <div class="card-body">
            <p>
                <div align="center">
                    Anpfiff: <b>{{ $match->match_start->format('H:i') }}</b>
                    @if($match->has_finished)
                        <br />Spiel ist vorbei
                    @endif
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
        </div>
        <footer class="card-footer d-flex justify-content-around">
            @foreach([1, 0, 2] as $button)
                <x-tipps.tipp-button :val="$button" :matchId="$match->id" :userTipp="$user_tipp" :matchResult="$match_result" :locked="$locked"/>
            @endforeach
        </footer>
    </div>
</div>
