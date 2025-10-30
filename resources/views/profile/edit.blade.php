@extends('layouts.app')

@section('title', 'Редактировать профиль - UncleTolik')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleEdit.css') }}">
@endsection

@section('content')
    <div class="edit-form">
        <h2 style="text-align: center; margin-bottom: 24px; color: #9c4dff;">Редактировать профиль</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="editForm">
            @csrf

            <!-- Аватар -->
            <div class="form-group">
                <label>Аватар</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
                @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" alt="Аватар" class="avatar-preview">
                @else
                    <img src="{{ $user->avatar_url }}" alt="Аватар" class="avatar-preview">
                @endif
            </div>

            <!-- ФИО -->
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" name="surname" class="form-control" value="{{ old('surname', $user->surname) }}" required>
            </div>
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label>Отчество</label>
                <input type="text" name="patronymic" class="form-control" value="{{ old('patronymic', $user->patronymic) }}" required>
            </div>

            <!-- Контакты -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- Кнопки -->
            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('profile.user') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection
