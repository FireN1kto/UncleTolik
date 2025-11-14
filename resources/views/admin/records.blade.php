@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleRecords.css') }}">
@endsection

@section('content')
    <div class="admin-page">
        <h1 class="page-title">Работа с записями</h1>

        <!-- Подтверждённые записи -->
        <div class="section-header" onclick="toggleSection('confirmed')">
            <h3>Подтверждённые записи</h3>
            <div class="icon">↓</div>
        </div>
        <div id="confirmed" class="records-list" style="display: none;">
            @if($confirmedRecords->count() > 0)
                @foreach($confirmedRecords as $record)
                    <div class="record-item">
                        <div class="record-info">
                            <strong>{{ $record->surname }} {{ $record->name }} {{ $record->patronymic }}</strong><br>
                            Телефон: {{ $record->number }}<br>
                            Услуга: {{ $record->service->name }}<br>
                            Мастер: {{ $record->master ? $record->master->surname : '—' }}<br>
                            Дата: {{ $record->date_time->format('d.m.Y H:i') }}
                        </div>
                        <div class="record-actions">
                            <span style="color: #4caf50; font-weight: bold;">Подтверждена</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-message">Нет подтверждённых записей</div>
            @endif
        </div>

        <!-- Неподтверждённые записи -->
        <div class="section-header" onclick="toggleSection('unconfirmed')">
            <h3>Неподтверждённые записи</h3>
            <div class="icon">↓</div>
        </div>
        <div id="unconfirmed" class="records-list" style="display: none;">
            @if($unconfirmedRecords->count() > 0)
                @foreach($unconfirmedRecords as $record)
                    <div class="record-item">
                        <div class="record-info">
                            <strong>{{ $record->surname }} {{ $record->name }} {{ $record->patronymic }}</strong><br>
                            Телефон: {{ $record->number }}<br>
                            Услуга: {{ $record->service->name }}<br>
                            Мастер: {{ $record->master ? $record->master->surname : '—' }}<br>
                            Дата: {{ $record->date_time->format('d.m.Y H:i') }}
                        </div>
                        <div class="record-actions">
                            <form method="POST" action="{{ route('admin.records.status.update', $record) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <div class="checkbox-wrapper">
                                    <div class="custom-checkbox {{ $record->is_active ? 'checked' : '' }}" onclick="this.classList.toggle('checked'); this.closest('form').querySelector('input[name=is_active]').value = this.classList.contains('checked') ? '1' : '0';"></div>
                                    <input type="hidden" name="is_active" value="{{ $record->is_active ? '1' : '0' }}">
                                    <label style="color: #e0e0e0; font-size: 14px;">Опубликовать</label>
                                </div>
                                <button type="submit" class="btn-publish">Сохранить</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-message">Нет неподтверждённых записей</div>
            @endif
        </div>
    </div>
    <script>
        function toggleSection(id) {
            const section = document.getElementById(id);
            const allSections = ['confirmed', 'unconfirmed'];

            allSections.forEach(sid => {
                if (sid === id) {
                    section.style.display = section.style.display === 'none' ? 'block' : 'none';
                } else {
                    document.getElementById(sid).style.display = 'none';
                }
            });
        }
    </script>
@endsection
