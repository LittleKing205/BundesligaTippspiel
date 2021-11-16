<x-util.card size="mb-3 col-xl-6 col-md-12" title="{{ $league }}. Bundesliga - {{ $lastDay }}. Spieltag Ergebnisse">
    <x-slot name="body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Name</th>
                    <th>Richtig</th>
                    <th>Falsch</th>
                    <th>Zu Behzahlen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leagueResult as $userResult)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $userResult["user"]->name }}</td>
                        <td>{{ $userResult["right"] }}</td>
                        <td>{{ $userResult["wrong"] }}</td>
                        <td>{{ number_format($userResult["to_pay"], 2, ",", ".") }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-slot>
</x-util.card>
