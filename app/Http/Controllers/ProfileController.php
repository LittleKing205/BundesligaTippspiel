<?php

namespace App\Http\Controllers;

use App\Models\SmsToken;
use App\Notifications\SendTokenNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProfileController extends Controller
{
    public function show(Request $request) {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function getSmsToken(Request $request) {
        $this->validate($request, [
            "number" => ["required", "numeric", "starts_with:01", "min:10"]
        ]);

        $user = Auth::user();
        $token = random_int(100000, 999999);

        SmsToken::create([
            "user_id" => Auth::id(),
            "token" => $token,
            "number" => $request->number
        ]);

        $user->notify(new SendTokenNotification($request->number, $token));

        return Response::json([
            "message" => "OK",
            "code" => "200"
        ]);
    }

    public function storeNumber(Request $request) {
        $this->validate($request, [
            "token" => ["required", "numeric", "min:100000", "max:999999"],
            "number" => ["required", "numeric", "starts_with:01", "min:10"]
        ]);
        $user = Auth::user();
        $smsToken = SmsToken::where("user_id", $user->id)->where("token", $request->token)->where("number", $request->number);

        if (!is_null($smsToken)) {
            $user->phone = $request->number;
            $user->save();

            SmsToken::where("user_id", $user->id)->delete();

            return Response::json([
                "message" => "OK",
                "code" => 200
            ]);
        } else {
            abort(401);
        }
    }

    public function deleteNumber(Request $request) {
        $user = Auth::user();
        $user->phone = null;
        $user->save();

        return redirect(route('profile'))->with("numberDelete");
    }
}
