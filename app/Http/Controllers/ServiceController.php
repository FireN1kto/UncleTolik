<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;

class ServiceController extends Controller
{
    public function ServicesList(){

        $types = Type::with(['services' => function($query) {
            $query->orderBy('name');
        }])->get();

        return view('services', compact('types'));
    }
}
