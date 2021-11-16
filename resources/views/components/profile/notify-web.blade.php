<div class="row mb-4">
    <div class="col-7">WebPush</div>
    <div class="col-5">
        @if($enabled)
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#webDeaktivateModal">Push Deaktivieren</button>
        @else
            <button type="button" class="btn btn-primary" onclick="startFCM()">Push Aktivieren</button>
        @endif
    </div>
</div>

@push('modal')
    <x-util.modal id="webDeaktivateModal" title="WebPush Benachrichtigungen Deaktivieren?" action="{{ route('profile.deleteWebPush') }}" method="delete">
        <x-slot name="body">
            <p>Soll der WebPush wirklich deaktiviert werden?</p>
        </x-slot>
        <x-slot name="footer">
            <button type="submit" class="btn btn-danger">Ja, WebPush deaktivieren</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nein</button>
        </x-slot>
    </x-util.modal>
@endpush

@push('script')
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>-

    <script>
        firebase.initializeApp({
            apiKey: 'AIzaSyAB0_MbU6bNbLFPadjD3UxgU7YZLr0PN-g',
            authDomain: 'websites-6011b.firebaseapp.com',
            projectId: 'websites-6011b',
            messagingSenderId: '41512814441',
            appId: '1:41512814441:web:c7019665ac69b83f955ff8',
        });
        const messaging = firebase.messaging();
        function startFCM() {
            messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function (response) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route("profile.storeWebPush") }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            location.reload();
                        },
                        error: function (error) {
                            console.log(error);
                            alert(error);
                        },
                    });

                }).catch(function (error) {
                    console.log(error);
                    alert(error);
                });
        }
    </script>
@endpush
