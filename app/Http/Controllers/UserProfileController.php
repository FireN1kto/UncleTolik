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
            ->with('service', 'master', 'status')
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
            $uploadPath = public_path('img/avatars');

            // Создаём папку, если её нет
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Генерируем уникальное имя файла
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileName = uniqid() . '_' . time() . '.' . $extension;
            $relativePath = 'img/avatars/' . $fileName;

            // Перемещаем файл
            $request->file('avatar')->move($uploadPath, $fileName);

            // Удаляем старый аватар, если есть
            if ($user->avatar) {
                $oldPath = public_path($user->avatar);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $data['avatar'] = $relativePath; // Сохраняем путь: "img/avatars/abc123.jpg"
        }

        $user->update($data);

        return redirect()->route('profile.user')->with('success', 'Профиль успешно обновлён!');
    }
}
