<?php

namespace App\Http\Controllers;

use App\Models\SmsToken;
use App\Notifications\SendTokenNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request) {
        $available_colors = [
            "Blau" => "primary",
            "Grau" => "secondary",
            "Grün" => "success",
            "Rot" => "danger",
            "Gelb" => "warning",
            "Hell Blau" => "info",
            "Weiß" => "light",
            "Schwarz" => "dark",
            "Blau Umriss" => "outline-primary",
            "Grau Umriss" => "outline-secondary",
            "Grün Umriss" => "outline-success",
            "Rot Umriss" => "outline-danger",
            "Gelb Umriss" => "outline-warning",
            "Hell Blau Umriss" => "outline-info",
            "Weiß Umriss" => "outline-light",
            "Schwarz Umriss" => "outline-dark"
        ];
        $user_colors = config("tippspiel.colors");
        if (!is_null(Auth::user()->button_colors))
            $user_colors = array_merge($user_colors, Auth::user()->button_colors);
        $user = Auth::user();
        return view('profile', compact('user', 'available_colors', 'user_colors'));
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

    public function storeJoin(Request $request) {
        $this->validate($request, [
            "join_key" => ["required", "string"]
        ]);
        $user = Auth::user();

        $user->join_key = $request->join_key;
        $user->save();

        return Response::json([
            "message" => "OK",
            "code" => 200
        ]);
    }

    public function deleteJoin(Request $request) {
        $user = Auth::user();
        $user->join_key = null;
        $user->save();

        return redirect(route('profile'))->with("joinDelete");
    }

    public function storeWebPush(Request $request) {
        $this->validate($request, [
            "token" => ["required", "string"]
        ]);
        $user = Auth::user();

        $user->device_key = $request->token;
        $user->save();

        return Response::json([
            "message" => "OK",
            "code" => 200
        ]);
    }

    public function deleteWebPush(Request $request) {
        $user = Auth::user();
        $user->device_key = null;
        $user->save();

        return redirect(route('profile'))->with("webPushDelete");
    }

    public function update(Request $request) {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => ['required', 'min:5', 'max:200'],
            'email' => ['required', 'max:200', 'email', Rule::unique('users')->ignore($user->getAuthIdentifier()) ],
            'password' => ['nullable', 'confirmed']
        ]);

        $user->email = $validated['email'];
        $user->name = $validated['name'];

        if(!is_null($validated['password']))
            $user->password = Hash::make($validated['password']);

        $user->save();
        session()->flash('success', 'Dein Profil wurde erfolgreich gespeichert.');

        return redirect(route('profile'));
    }

    public function updateColors(Request $request) {
        $user = Auth::user();
        $user->button_colors = $request->except(['_token', '_method']);
        $user->save();
        session()->flash('success', 'Dein Profil wurde erfolgreich gespeichert.');
        return redirect(route('profile'));
    }
}
