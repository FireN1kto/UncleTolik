<?php

namespace App\Http\Controllers;

use database\Masters;

class MastersController extends Controller {
    public function MastersList() {
        $Masters = Masters::all();
        return view('masters', compact('Masters'));
    }
}
