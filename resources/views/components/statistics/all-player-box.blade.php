<div class="mb-4 col-xl-4 col-md-12">
    <div class="card">
        <h5 class="card-header">Topf</h5>
        <div class="card-body">
            <p class="card-text">
                <div class="row">
                    <div class="col-6">Im Topf:</div>
                    <div class="col-6">
                        {{ number_format($pot_sum, 2, ",", ".") }} €
                        @if ($pot_sum_missing > 0)
                            (+ {{ number_format($pot_sum_missing, 2, ",", ".") }} €)
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">Am Meisten Richtig:</div>
                    <div class="col-6">{{ $most_right_name }} ({{ $most_right_sum }}x)</div>
                </div>
                <div class="row">
                    <div class="col-6">Am Meisten Falsch:</div>
                    <div class="col-6">{{ $most_wrong_name }} ({{ $most_wrong_sum }}x)</div>
                </div>
                <div class="row">
                    <div class="col-6">Nicht getippte Spiele:</div>
                    <div class="col-6">{{ $not_tipped }}x</div>
                </div>
            </p>
        </div>
    </div>
</div>
