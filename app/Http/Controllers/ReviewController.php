<?php

namespace App\Http\Controllers;

use App\Models\Records;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Records $record)
    {
        if ($record->user_id !== Auth::id() || $record->date_time->isFuture()) {
            abort(403);
        }

        return view('review.create', compact('record'));
    }

    // Отправка отзыва
    public function store(Request $request, Records $record)
    {
        // Повторная проверка
        if ($record->user_id !== Auth::id() || $record->date_time->isFuture()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string|min:10|max:1000',
        ]);

        Reviews::create([
            'surname' => Auth::user()->surname,
            'name' => Auth::user()->name,
            'patronymic' => Auth::user()->patronymic,
            'description' => $request->description,
            'rating' => $request->rating,
            'user_id' => Auth::id(),
            'record_id' => $record->id,
            'is_active' => false, // ожидает подтверждения
        ]);

        return redirect()->route('profile.user')->with('success', 'Отзыв отправлен на модерацию');
    }
}
