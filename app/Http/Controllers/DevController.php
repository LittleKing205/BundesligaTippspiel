<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevController extends Controller {

    public function show(Request $request) {
        return view('developer');
    }

    public function switchTippMode(Request $request) {
        $newMode = !$request->session()->get('devTippMode', false);
        $request->session()->put('devTippMode', $newMode);
        return back();
    }

    public function loginAsUser(Request $request) {
        if(session('devIsLoggedInAsDifferentUser', false))
            abort(404);
        $validated = $request->validate([
            'user' => ['required', 'exists:App\Models\User,id'],
        ]);

        $request->session()->put('devIsLoggedInAsDifferentUser', true);
        $request->session()->put('devOriginalUserId', Auth::user()->id);
        Auth::loginUsingId($validated['user']);
        return redirect(route('home'));
    }

    public function logBack(Request $request) {
        if(!session('devIsLoggedInAsDifferentUser', false))
            abort(403);
        $user = User::find(session('devOriginalUserId'));
        if ($user->cannot('dev.login_as_user'))
            abort(403);

        $request->session()->put('devIsLoggedInAsDifferentUser', false);
        Auth::loginUsingId(session('devOriginalUserId'));
        return back();
    }
}
