@extends('layouts.app')

@section('title', 'Kassenwart')

@section('breadcump')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kassenwart</li>
@endsection

@section('content')
    <div class="row">
        <div class="mb-3 col-xl-2 col-md-12">
            <div class="card">
                <h5 class="card-header" data-toggle="collapse" data-target="#collapseUserFilter">Nach Spieler Filtern</h5>
                <div class="card-body collapse @desktop show @enddesktop" id="collapseUserFilter">
                    <p class="card-text">
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['payed' => $payed_filter]) }}">Alle</a> <br />
                        @foreach ($users as $user)
                            <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['payed' => $payed_filter, 'validated' => $validated_filter, 'user' => $user->name]) }}">{{ $user->name }}</a><br />
                        @endforeach
                    </p>
                </div>
            </div>
            <br />
            <div class="card">
                <h5 class="card-header" data-toggle="collapse" data-target="#collapseValidatedFilter">Geprüften Zahlungen Filtern</h5>
                <div class="card-body collapse @desktop show @enddesktop" id="collapseValidatedFilter">
                    <p class="card-text">
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter, 'payed' => $payed_filter,]) }}">Alle</a> <br />
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter, 'payed' => $payed_filter, 'validated' => true]) }}">Geprüft</a> <br />
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter, 'payed' => $payed_filter, 'validated' => false]) }}">Nicht Geprüft</a> <br />
                    </p>
                </div>
            </div>
            <br />
            <div class="card">
                <h5 class="card-header" data-toggle="collapse" data-target="#collapsePayedFilter">Nach Zahlstatus Filtern</h5>
                <div class="card-body collapse @desktop show @enddesktop" id="collapsePayedFilter">
                    <p class="card-text">
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter, 'validated' => $validated_filter]) }}">Alle</a> <br />
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter, 'validated' => $validated_filter, 'payed' => true]) }}">Gezahlt</a> <br />
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter, 'validated' => $validated_filter, 'payed' => false]) }}">Nicht gezahlt</a> <br />
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-10 col-md-12">
            <div class="card">
                <h5 class="card-header">Zahlungsverlauf</h5>
                <div class="card-body">
                    <p class="card-text">

                        <table id="bills-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2">Zahl/Check Status</th>
                                    <th>Spielername</th>
                                    <th>Liga</th>
                                    <th>Spieltag</th>
                                    <th>Betrag</th>
                                    <th>Zu zahlen/bezahlt seit</th>
                                    <th>Aktionen</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Zahl/Check Status</th>
                                    <th>Spielername</th>
                                    <th>Liga</th>
                                    <th>Spieltag</th>
                                    <th>Betrag</th>
                                    <th>Zu zahlen/bezahlt seit</th>
                                    <th>Aktionen</th>
                                </tr>
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
                                        <td>
                                            @if($bill->validated)
                                                <i class="text-success fas fa-check"></i>
                                            @else
                                                <i class="text-danger fas fa-times"></i>
                                            @endif
                                        </td>
                                        <td>{{ $bill->user->name }}</td>
                                        <td>{{ $bill->league }}. Bundesliga</td>
                                        <td>{{ $bill->day }}.</td>
                                        <td>{{ number_format($bill->to_pay, 2, ",", ".") }} €</td>
                                        <td>
                                            @if($bill->has_payed)
                                                {{ $bill->updated_at }}
                                            @else
                                                {{ $bill->created_at }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($bill->has_payed )
                                                @can("treasurer.validate_payment")
                                                    @if ($bill->validated)
                                                    <a href="{{ route('treasurer.validate_payment', ['bill' => $bill->id, 'validate' => 'reject']) }}" class="btn btn-warning">Bestätigung Zurückziehen</a>
                                                    @else
                                                        <a href="{{ route('treasurer.validate_payment', ['bill' => $bill->id]) }}" class="btn btn-success">Zahlung Betsätigen</a>
                                                    @endif
                                                @endcan
                                                @can("treasurer.reject_payment")
                                                    <a class="treasurer-payment-revoke btn btn-danger" href="#" data-bill-id="{{ $bill->id }}" data-username="{{ $bill->user->name }}" data-paydate="{{ $bill->updated_at }}" data-toggle="modal" data-target="#treasurerPaymentRevokeModal">Zahlung zurücksetzen</a>
                                                @endcan
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
    </div>

    <div class="modal fade" id="treasurerPaymentRevokeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Zahlung zurücksetzen?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Soll die Zahlung von <b><span id="treasurerPaymentRevokeModalUsername"></span></b> vom <b><span id="treasurerPaymentRevokeModalDate"></span></b> wirklich zurückgesetzt werden?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('treasurer.reject_payment', ['user' => $user_filter, 'payed' => $payed_filter]) }}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" id="inputBillId" name="bill-id" value="">
                        <button type="submit" class="btn btn-danger">Ja, Zahlung zurücksetzen!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nein</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        jQuery(document).ready(function($){
            $('#bills-table').dataTable({
                ordering: true,
                "order": [ 0, 'asc' ],
                "language": {
                    "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
                    "zeroRecords": "Keine Einträge gefunden",
                    "info": "Seite _PAGE_ von _PAGES_",
                    "infoEmpty": "Keine Einträge vorhanden",
                    "infoFiltered": "(gefiltert von _MAX_ Einträgen)",
                    "decimal": ",",
                    paginate: {
                        first: "Erste Seite",
                        previous:   "<<",
                        next:       ">>",
                        last:       "Letzte Seite"
                    },
                }
            });
        });
    </script>
@endpush
