<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Services;

class ServiceController extends Controller
{
    public function ServicesList(){

        $types = Type::with(['services' => function($query) {
            $query->orderBy('name');
        }])->get();

        return view('services', compact('types'));
    }

    public function showHaircuts()
    {
        $type = Type::where('name', 'Стрижки')->firstOrFail();
        $services = Services::where('type_id', $type->id)->get();

        return view('services.haircuts', compact('type', 'services'));
    }

    public function showShaving()
    {
        // Страница услуг стрижек
        $type = Type::where('name', 'Бритьё')->firstOrFail();
        $services = Services::where('type_id', $type->id)->get();

        return view('services.haircuts', compact('type', 'services'));
    }

    public function showFacialTreatment()
    {
        // Страница услуг стрижек
        $type = Type::where('name', 'Уход за лицом')->firstOrFail();
        $services = Services::where('type_id', $type->id)->get();

        return view('services.haircuts', compact('type', 'services'));
    }
}
