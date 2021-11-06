<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Notifications\PaymentRejectNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class TreasurerController extends Controller
{

    public function __construct() {
        $this->middleware('permission:treasurer.show');
        $this->middleware('permission:treasurer.reject_payment')->only('rejectPayment');
    }

    public function show(Request $request) {
        $users = Auth::user()->currentGroup->users->sortBy("name");
        $bills = Bill::where("tipp_group_id", Auth::user()->current_group_id)->with('user');

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

        $bill->user->notify(new PaymentRejectNotification($bill));

        return redirect(route('treasurer', ['user' => $request->input("user"), 'payed' => $request->input("payed")]));
    }
}
