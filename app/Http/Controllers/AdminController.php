<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use \App\Models\Records;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function users()
    {
        $users = User::with('role')->get();
        $roles = Role::all()->pluck('name', 'id');

        return view('admin.users', compact('users', 'roles'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:role,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        if ($role->name === 'admin') {
            $existingAdmin = User::whereHas('role', function ($q) {
                $q->where('name', 'admin');
            })->exists();

            if ($existingAdmin) {
                return back()->withErrors(['error' => 'Администратор уже существует. Нельзя создать второго.']);
            }
        }

        if ($user->isAdmin() && $request->role_id != $user->role_id) {
            return back()->withErrors(['error' => 'Нельзя изменить роль администратора']);
        }

        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', 'Роль пользователя обновлена');
    }

    public function records()
    {
        $confirmedRecords = Records::with(['user', 'service', 'master'])
            ->where('is_active', true)
            ->orderBy('date_time', 'desc')
            ->get();

        $unconfirmedRecords = Records::with(['user', 'service', 'master'])
            ->where('is_active', false)
            ->orderBy('date_time', 'desc')
            ->get();

        return view('admin.records', compact('confirmedRecords', 'unconfirmedRecords'));
    }

    public function updateRecordStatus(Request $request, Records $record)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $record->update(['is_active' => $request->is_active]);

        return back()->with('success', 'Статус записи обновлён');
    }
}
