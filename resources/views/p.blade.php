@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <button onclick="startFCM()"
                        class="btn btn-danger btn-flat">Allow notification
                </button>

                <div class="card mt-3">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('send.web-notification') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Message Title</label>
                                <input type="text" class="form-control" name="title" value="AAAACapbR2k:APA91bFpDw_2__MIFUsyElm_sEsSObKKmdEnUXaWD25YL3OwMqpMnXK64PAB5zM9GPE535fOLnn9u4XRrCp-SIc1mo26eOHf0vML19Jw1wuug4PfP9ZZV3l2E-M53pEfnAVr56nWhwtZ">
                            </div>
                            <div class="form-group">
                                <label>Message Body</label>
                                <textarea class="form-control" name="body">c6hs7ckkpdnHeeXNWaOIoq:APA91bEIjNLxiNf2VDmlF770LykYrUI2RdreMMmywI3m-EiardZpqGiraXiI7fEZK5K7OOB146X0S_kTX5o2co--ml90EQmuOObDnbCfIb0fEgGT7B8N4PRcYkDBDbm_12qkpWSARt5I</textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        firebase.initializeApp({
            apiKey: 'AIzaSyAB0_MbU6bNbLFPadjD3UxgU7YZLr0PN-g',
            authDomain: 'websites-6011b.firebaseapp.com',
            databaseURL: 'https://websites-6011b.firebaseio.com',
            projectId: 'websites-6011b',
            //storageBucket: 'websites-6011b.appspot.com',
            messagingSenderId: '41512814441',
            appId: '1:41512814441:web:c7019665ac69b83f955ff8',
            //measurementId: 'G-measurement-id',
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
                        url: '{{ route("store.token") }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            alert('Token stored.');
                        },
                        error: function (error) {
                            alert(error);
                        },
                    });

                }).catch(function (error) {
                alert(error);
            });
        }
    </script>
@endsection
