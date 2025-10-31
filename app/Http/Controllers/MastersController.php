<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MastersController extends Controller {

    public function MastersList() {
        $masters = User::whereHas('role', function ($query) {
            $query->where('name', 'master');
        })->get();

        return view('masters', compact('masters'));
    }
}
