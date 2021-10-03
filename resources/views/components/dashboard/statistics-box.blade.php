<div class="col-xl-3 col-md-6">
    <div class="card bg-{{ $status_color }} text-white mb-4">
        <div class="card-header">
            Statistiken & Zahlungen
        </div>
        <div class="card-body">
            @if($open_bills > 0)
                <b>Du musst noch {{ $open_bills }} Zahlungen tätigen.</b><br />
            @else
                Du hast alles gezahlt.
            @endif

            Im Topf befinden sich zurzeit {{ number_format($pot, 2, ",", ".") }} €
            @if ($missing_pot > 0)
                (+ {{ number_format($missing_pot, 2, ",", ".") }} €)
            @endif

        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="{{ route("statistics") }}">Weitere Statistiken & Zahlungen Anzeigen</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
