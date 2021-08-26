<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class WebNotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('p');
    }

    public function storeToken(Request $request)
    {
        auth()->user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }

    public function sendWebNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        //$FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
        $FcmToken = ['c6hs7ckkpdnHeeXNWaOIoq:APA91bEIjNLxiNf2VDmlF770LykYrUI2RdreMMmywI3m-EiardZpqGiraXiI7fEZK5K7OOB146X0S_kTX5o2co--ml90EQmuOObDnbCfIb0fEgGT7B8N4PRcYkDBDbm_12qkpWSARt5I'];

        $serverKey = 'AAAACapbR2k:APA91bFpDw_2__MIFUsyElm_sEsSObKKmdEnUXaWD25YL3OwMqpMnXK64PAB5zM9GPE535fOLnn9u4XRrCp-SIc1mo26eOHf0vML19Jw1wuug4PfP9ZZV3l2E-M53pEfnAVr56nWhwtZ';

        $data = [
            "notification" => [
                "title" => 'title',
                "body" => 'body',
                "icon" =>
            ],
            "to" => 'c6hs7ckkpdnHeeXNWaOIoq:APA91bEIjNLxiNf2VDmlF770LykYrUI2RdreMMmywI3m-EiardZpqGiraXiI7fEZK5K7OOB146X0S_kTX5o2co--ml90EQmuOObDnbCfIb0fEgGT7B8N4PRcYkDBDbm_12qkpWSARt5I'
        ];

        $encodedData = json_encode($data);

        $headers = [
            'authorization:key=' . $serverKey,
            'content-type:application/json'
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        // FCM response
        dd($result);
    }
}
