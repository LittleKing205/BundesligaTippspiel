<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function switchGroup(Request $request) {
        return "switch";
    }

    public function addGroupShow(Request $request) {
        return "add";
    }
}
