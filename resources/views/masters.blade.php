@extends('layouts.app')

@section('title', 'Наши мастера - UncleTolik')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleMasters.css') }}">
@endsection

@section('content')
    <div class="masters-container">
        @if($masters->count() > 0)
            <!-- Первая линия мастеров -->
            <div class="FiresteLine2">
                @foreach($masters->take(3) as $master)
                    <div class="Master{{ $loop->iteration }} master-card">
                        <div class="Content">
                            <h3>{{ $master->surname }} {{ $master->name }} {{ $master->patronymic }}</h3>
                            <p>
                                {{ $master->biography }}
                                @if($master->specialization)
                                    <span>«{{ $master->specialization }}»</span>
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Вторая линия мастеров -->
            <div class="SecondLine2">
                @foreach($masters->slice(3, 3) as $master)
                    <div class="Master{{ $loop->iteration + 3 }} master-card">
                        <div class="Content">
                            <h3>{{ $master->surname }} {{ $master->name }} {{ $master->patronymic }}</h3>
                            <p>
                                {{ $master->biography }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Если мастеров нет в базе -->
            <div class="no-masters">
                <h2>Наши мастера</h2>
                <p>Информация о мастерах временно недоступна. Пожалуйста, зайдите позже.</p>
            </div>
        @endif
    </div>
@endsection
