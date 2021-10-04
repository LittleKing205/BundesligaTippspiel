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
                    <div class="col-6">Am Meisten gezahlt:</div>
                    <div class="col-6">{{ $most_payments_user }} ({{ number_format($most_payments_payed, 2, ",", ".") }} €)</div>
                </div>
            </p>
        </div>
    </div>
</div>
