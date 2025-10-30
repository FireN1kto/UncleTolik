<?php

namespace App\Http\Controllers;

use App\Models\Masters;

class MastersController extends Controller {
    public function MastersList() {
        $Masters = Masters::all();
        return view('masters', compact('Masters'));
    }
}
