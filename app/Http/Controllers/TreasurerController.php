<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class TreasurerController extends Controller
{

    public function show(Request $request) {
        if (!Gate::allows('isTreasurer'))
            abort(404);

        $users = User::all();
        $bills = Bill::with('user');

        $user_filter = "";
        $payed_filter = "";

        if(!is_null($request->input("user"))) {
            $user = User::where("name", $request->input("user"))->first();
            if (!is_null($user)) {
                $bills = $bills->where("user_id", $user->id);
                $user_filter = $user->name;
            }
        }

        if(!is_null($request->input("payed"))) {
            $bills = $bills->where("has_payed", $request->input("payed"));
            $payed_filter = $request->input("payed");
        }

        $bills = $bills->get();

        return view('treasurer', compact('users', 'bills', 'user_filter', 'payed_filter'));
    }

    public function rejectPayment(Request $request) {
        $validated = $request->validate([
            "bill-id" => ['exists:App\Models\Bill,id']
        ]);
        $bill = Bill::find(intval($validated["bill-id"]));
        $bill->has_payed = false;
        $bill->save();

        return redirect(route('treasurer', ['user' => $request->input("user"), 'payed' => $request->input("payed")]));
    }
}
