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
                <h5 class="card-header">Nach Spieler Filtern</h5>
                <div class="card-body">
                    <p class="card-text">
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['payed' => $payed_filter]) }}">Alle</a> <br />
                        @foreach ($users as $user)
                            <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['payed' => $payed_filter, 'user' => $user->name]) }}">{{ $user->name }}</a><br />
                        @endforeach
                    </p>
                </div>
            </div>
            <br />
            <div class="card">
                <h5 class="card-header">Nach Zahlstatus Filtern</h5>
                <div class="card-body">
                    <p class="card-text">
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter]) }}">Alle</a> <br />
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter, 'payed' => true]) }}">Gezahlt</a> <br />
                        <i class="fas fa-arrow-right"></i> <a href="{{ route('treasurer', ['user' => $user_filter, 'payed' => false]) }}">Nicht gezahlt</a> <br />
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
                                    <th>Spielername</th>
                                    <th>Liga</th>
                                    <th>Spieltag</th>
                                    <th>Betrag</th>
                                    <th>Zu zahlen/bezahlt seit</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Spielername</th>
                                    <th>Liga</th>
                                    <th>Spieltag</th>
                                    <th>Betrag</th>
                                    <th>Zu zahlen/bezahlt seit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->user->name }}</td>
                                        <td>{{ $bill->league }}. Bundesliga</td>
                                        <td>{{ $bill->day }}.</td>
                                        <td>{{ number_format($bill->to_pay, 2, ",", ".") }} €</td>
                                        <td>
                                            @if(!is_null($bill->updated_at))
                                                <span class="text-success">{{ $bill->updated_at }}</span>
                                            @else
                                                <span class="text-danger">{{ $bill->created_at }}</span>
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
@endsection
