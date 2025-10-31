<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Records;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class UserProfileController extends Controller
{
    public function index()
    {

        $user = auth()->user();

        // Текущее время
        $now = now();

        // Актуальные записи (будущие или сегодняшние)
        $upcomingRecords = $user->records()
            ->with('service', 'master')
            ->where('date_time', '>=', $now)
            ->orderBy('date_time', 'asc')
            ->get();

        // Прошедшие записи
        $pastRecords = $user->records()
            ->with('service', 'master', 'status')
            ->where('date_time', '<', $now)
            ->orderBy('date_time', 'desc')
            ->get();

        return view('profile.user', compact('user', 'upcomingRecords', 'pastRecords'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'surname' => 'required|min:2',
            'name' => 'required|min:2',
            'patronymic' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'number' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // до 2 МБ
        ]);

        $data = $request->only(['surname', 'name', 'patronymic', 'email', 'number']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.user')->with('success', 'Профиль успешно обновлён!');
    }
}
