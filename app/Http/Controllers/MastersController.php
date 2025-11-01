<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Records;
use App\Models\Works;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MastersController extends Controller {

    public function MastersList() {
        $masters = User::whereHas('role', function ($query) {
            $query->where('name', 'master');
        })->get();

        return view('masters', compact('masters'));
    }

    public function index()
    {
        $user = Auth::user();

        // Проверка: пользователь должен быть мастером
        if (!$user->isMaster()) {
            abort(403, 'Доступ только для мастеров');
        }

        $records = Records::with(['user', 'service'])
            ->where('master_user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('date_time', 'desc')
            ->get();

        // Фото работ мастера
        $works = $user->works;

        return view('profile.master', compact('user', 'records', 'works'));
    }

    public function uploadWork(Request $request)
    {
        $user = Auth::user();

        if (!$user->isMaster()) {
            abort(403);
        }

        $request->validate([
            'work_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('work_image')->store('works', 'public');

        Works::create([
            'user_id' => $user->id,
            'image_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Работа добавлена!');
    }

    public function deleteWork(Works $work)
    {
        $user = Auth::user();

        // Проверяем, что работа принадлежит текущему мастеру
        if ($work->user_id !== $user->id) {
            abort(403);
        }

        Storage::disk('public')->delete($work->image_path);
        $work->delete();

        return redirect()->back()->with('success', 'Работа удалена');
    }
}
