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

<div class="modal fade" id="webDeaktivateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">WebPush Benachrichtigungen Deaktivieren?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Soll der WebPush wirklich deaktiviert werden?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('profile.deleteWebPush') }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Ja, WebPush deaktivieren</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Nein</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
