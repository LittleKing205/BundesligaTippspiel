<x-util.card size="mb-4 col-xl-4 col-md-12" title="Deine Statistiken">
    <x-slot name="body">
        <div class="row">
            <div class="col-6">Richtig getippt:</div>
            <div class="col-6">{{ $tipps_right }}x</div>
        </div>
        <div class="row">
            <div class="col-6">Falsch getippt:</div>
            <div class="col-6">{{ $tipps_wrong }}x</div>
        </div>
        @if (Auth::user()->currentGroup->payment_enabled)
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
        @endif
    </x-slot>
</x-util.card>
