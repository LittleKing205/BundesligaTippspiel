<div class="mb-3 col-xl-6 col-md-12">
    <div class="card">
        <h5 class="card-header">{{ $league }}. Bundesliga - Zahlungen</h5>
        <div class="card-body">
            <p class="card-text">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Spieltag</th>
                        <th>Betrag</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tfoot>
                        <th></th>
                        <th>Gesamt</th>
                        <th>{{ number_format($bills->sum('to_pay'), 2, ",", ".") }} €</th>
                        <th></th>
                    </tfoot>

                    <tbody>
                        @foreach ($bills as $bill)
                            <tr>
                                <td>
                                    @if($bill->has_payed)
                                        <i class="text-success fas fa-check"></i>
                                    @else
                                        <i class="text-danger fas fa-times"></i>
                                    @endif
                                </td>
                                <td>{{ $bill->day }}</td>
                                <td>{{ number_format($bill->to_pay, 2, ",", ".") }} €</td>
                                <td>
                                    @if($bill->has_payed)
                                        Bezahlt
                                    @else
                                        <u class="statistics-pay-btn" style="cursor: pointer;" data-id="{{ $bill->id }}" data-betrag="{{ number_format($bill->to_pay, 2, ",", ".") }}" data-league="{{ $bill->league }}" data-day="{{ $bill->day }}">Jetzt zahlen</u>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </p>
        </div>
    </div>
</div>
