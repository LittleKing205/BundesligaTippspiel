<x-util.card size="col-xl-3 col-md-6" color="{{ $status_color }}" title="Statistiken & Zahlungen">
    <x-slot name="body">
        @if($open_bills > 0)
            <b>Du musst noch {{ $open_bills }} Zahlungen tätigen.</b><br />
        @else
            Du hast alles gezahlt.<br />
        @endif

        Im Topf befinden sich zurzeit {{ number_format($pot, 2, ",", ".") }} €
        @if ($missing_pot > 0)
            (+ {{ number_format($missing_pot, 2, ",", ".") }} €)
        @endif
    </x-slot>
    <x-slot name="link" href="{{ route('statistics') }}">Weitere Statistiken & Zahlungen Anzeigen</x-slot>
</x-util.card>
