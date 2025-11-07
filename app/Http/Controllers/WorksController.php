<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WorksController extends Controller
{
    public function index()
    {
        $masters = User::whereHas('role', function ($query) {
            $query->where('name', 'master');
        })
            ->with('works')
            ->get();

        return view('works', compact('masters'));
    }
}
