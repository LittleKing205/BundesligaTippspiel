<div class="mb-4 col-xl-4 col-md-12">
    <div class="card">
        <h5 class="card-header">Deine Statistiken</h5>
        <div class="card-body">
            <p class="card-text">
                <div class="row">
                    <div class="col-6">Richtig getippt:</div>
                    <div class="col-6">{{ $tipps_right }}x</div>
                </div>
                <div class="row">
                    <div class="col-6">Falsch getippt:</div>
                    <div class="col-6">{{ $tipps_wrong }}x</div>
                </div>
                <div class="row">
                    <div class="col-6">Insgesammt gezahlt:</div>
                    <div class="col-6">{{ number_format($payed, 2, ",", ".") }} €</div>
                </div>
                @if($not_payed > 0)
                    <div class="row">
                        <div class="col-6">Noch zu zahlen:</div>
                        <div class="col-6">{{ number_format($not_payed, 2, ",", ".") }} €</div>
                    </div>
                @endif
            </p>
        </div>
    </div>
</div>
