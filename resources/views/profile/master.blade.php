@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/PagesCss/styleProfileMaster.css') }}">
@endsection
@section('content')
<div class="master-profile">
    <!-- Шапка профиля -->
    <div class="info">
        <h2>{{ $user->surname }} {{ $user->name }}</h2>
        <p>{{ $user->email }}</p>
        @if($user->biography)
        <p><strong>Биография:</strong> {{ $user->biography }}</p>
        @endif
    </div>

    <!-- Записи на мастера -->
    <div class="section-title">Записи на меня</div>
    @if($records->count() > 0)
    @foreach($records as $record)
    <div class="record-card">
        <div class="record-header">
            <span class="record-service">{{ $record->service->name }}</span>
            <span class="record-date">{{ $record->date_time->format('d.m.Y H:i') }}</span>
        </div>
        <div>Клиент: {{ $record->surname }} {{ $record->name }}</div>
        <div>Телефон: {{ $record->number }}</div>
    </div>
    @endforeach
    @else
    <p class="text-center">Нет подтверждённых записей</p>
    @endif

    <!-- Форма загрузки работ -->
    <div class="section-title">Мои работы</div>
    <div class="upload-form">
        <form action="{{ route('profile.master.work.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Фото работы</label>
                <input type="file" name="work_image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn">Добавить работу</button>
        </form>
    </div>

    <!-- Галерея -->
    @if($works->count() > 0)
    <div class="works-gallery">
        @foreach($works as $work)
        <div class="work-item">
            <img src="{{ Storage::url($work->image_path) }}" alt="Работа">
            <form action="{{ route('profile.master.work.delete', $work) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Удалить фото?')">✕</button>
            </form>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center">Вы ещё не добавили ни одной работы</p>
    @endif
</div>
@endsection
