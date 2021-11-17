<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function show(Request $request) {
        return view('statistics');
    }

    public function pay(Request $request) {
        $this->validate($request, [
            'bill_id' => 'exists:App\Models\Bill,id'
        ]);

        $bill = Bill::where("id", $request->bill_id)->first();

        $bill->has_payed = true;
        $bill->save();

        return redirect(route("statistics"))->with("success", "Deine Zahlung wurde erfolgreich gespeichert.");
    }
}
