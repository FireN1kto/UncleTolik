@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleUsers.css') }}">
@endsection

@section('content')
    <div class="users-table">
        <h2 style="text-align: center; padding: 20px 0; color: #9c4dff;">Управление пользователями</h2>
        <table>
            <thead>
            <tr>
                <th>ФИО</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="role-badge role-{{ $user->role->name }}">
                            {{ ucfirst($user->role->name) }}
                        </span>
                    </td>
                    <td>
                        @if(!$user->isAdmin())
                            <form method="POST" action="{{ route('admin.users.role.update', $user) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <select name="role_id" class="role-select">
                                    @foreach($roles as $id => $name)
                                        <option value="{{ $id }}" {{ $user->role_id == $id ? 'selected' : '' }}>
                                            {{ ucfirst($name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="update-btn">Сохранить</button>
                            </form>
                        @else
                            <span style="color: #666;">—</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
