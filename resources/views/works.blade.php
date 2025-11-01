@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleWorks.css') }}">
@endsection

@section('content')
    @foreach($masters as $master)
        @if($master->works->count() > 0)
            <div class="work-block">
                <h3>Работы {{ $master->name }}</h3>

                <!-- Центрированный слайдер -->
                <div class="slider-wrapper">
                    <div class="slider" data-master="{{ $master->id }}">
                        <div class="slides">
                            @foreach($master->works as $work)
                                <div class="slide">
                                    <img src="{{ Storage::url($work->image_path) }}" alt="Работа">
                                </div>
                            @endforeach
                        </div>
                        <button class="slider-btn prev" data-dir="-1">‹</button>
                        <button class="slider-btn next" data-dir="1">›</button>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
