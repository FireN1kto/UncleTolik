<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
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

        // Запретить менять роль администратору (себе и другим админам)
        if ($user->isAdmin() && $request->role_id != $user->role_id) {
            return back()->withErrors(['error' => 'Нельзя изменить роль администратора']);
        }

        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', 'Роль пользователя обновлена');
    }
}
