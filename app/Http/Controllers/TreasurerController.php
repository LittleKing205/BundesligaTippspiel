<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Notifications\PaymentRejectNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class TreasurerController extends Controller
{

    public function __construct() {
        $this->middleware('permission:treasurer.show');
        $this->middleware('permission:treasurer.reject_payment')->only('rejectPayment');
        $this->middleware('permission:treasurer.validate_payment')->only('validatePayment');
    }

    public function show(Request $request) {
        $users = User::all();
        $bills = Bill::with('user');

        $user_filter = "";
        $payed_filter = "";
        $validated_filter = "";

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

        if(!is_null($request->input("validated"))) {
            $bills = $bills->where("validated", $request->input("validated"));
            $validated_filter = $request->input("validated");
        }

        $bills = $bills->get();

        return view('treasurer', compact('users', 'bills', 'user_filter', 'payed_filter', 'validated_filter'));
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

    public function validatePayment(Request $request, Bill $bill, $validate = null) {
        if (is_null($validate)) {
            $bill->validated = true;
        } else {
            if ($validate == "reject") {
                $bill->validated = false;
            }
        }
        $bill->save();
        return back();
    }
}
