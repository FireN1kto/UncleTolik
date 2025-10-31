@extends('layouts.app')

@section('title', 'Профиль - UncleTolik')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleProfile.css') }}">
@endsection

@section('content')
    <div class="profile-card">
        <div class="profile-card">
            <div class="profile-avatar">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="Аватар" class="avatar-preview">
                @else
                    <img src="{{ asset('img/default_avatar.jpg') }}" class="avatar-preview">
                @endif
            </div>
            <div class="profile-info">
                <h2>{{ $user->surname }}
                    {{ $user->name }} {{ $user->patronymic }}</h2>
                <p>{{ $user->email }}</p>
                <a href="{{ route('profile.edit') }}" class="edit-profile-btn">Редактировать профиль</a>
            </div>
        </div>
    </div>

    {{-- Актуальные записи --}}
    <div class="section-title">Мои записи</div>

    @if($upcomingRecords->count() > 0)
        <div class="sessions-grid">
            @foreach($upcomingRecords as $record)
                <div class="session-card">
                    <div class="session-header">
                        <h3 class="session-service">{{ $record->service->name }}</h3>
                        <span class="session-date">{{ $record->date_time->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="session-details">
                        <div class="session-detail">
                            <span>Мастер:</span>
                            <strong>{{ $record->master->surname }} {{ $record->master->name }}</strong>
                        </div>
                        <div class="session-detail">
                            <span>Стоимость:</span>
                            <strong>{{ $record->service->price }} ₽</strong>
                        </div>
                        <div class="session-detail">
                            <span>Телефон:</span>
                            <strong>{{ $record->number }}</strong>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-sessions">
            <p>У вас пока нет активных записей</p>
            <p>Запишитесь на услугу, чтобы увидеть её здесь</p>
        </div>
    @endif

    {{-- Прошедшие записи --}}
    @if($pastRecords->count() > 0)
        <div class="section-title">Прошедшие записи</div>
        <div class="sessions-grid">
            @foreach($pastRecords as $record)
                <div class="session-card past-session">
                    <div class="session-header">
                        <h3 class="session-service">{{ $record->service->name }}</h3>
                        <span class="session-date">{{ $record->date_time->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="session-details">
                        <div class="session-detail">
                            <span>Мастер:</span>
                            <strong>{{ $record->master->surname }} {{ $record->master->name }}</strong>
                        </div>
                        <div class="session-detail">
                            <span>Стоимость:</span>
                            <strong>{{ $record->service->price }} ₽</strong>
                        </div>
                        <div class="session-detail">
                            <span>Телефон:</span>
                            <strong>{{ $record->number }}</strong>
                        </div>
                    </div>

                    {{-- Кнопка "Написать отзыв" --}}
                    <div class="session-actions">
                        <button class="review-btn" data-record-id="{{ $record->id }}">
                            Написать отзыв
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
