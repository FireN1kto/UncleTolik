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
                        <button class="slider-btn prev" data-dir="-1">‹</button>
                        <div class="slides">
                            @foreach($master->works as $work)
                                <div class="slide">
                                    <img src="{{ Storage::url($work->image_path) }}" alt="Работа">
                                </div>
                            @endforeach
                        </div>
                        <button class="slider-btn next" data-dir="1">›</button>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.slider').forEach(function(slider) {
                const slides = slider.querySelector('.slides');
                const slideList = slider.querySelectorAll('.slide');
                let currentIndex = 0;
                const totalSlides = slideList.length;
                const slidesToShow = 2;

                if (totalSlides <= slidesToShow) return;

                function updateSlider() {
                    const offset = -currentIndex * (100 / slidesToShow);
                    slides.style.transform = `translateX(${offset}%)`;
                }

                slider.querySelectorAll('.slider-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const dir = parseInt(this.getAttribute('data-dir'));
                        currentIndex += dir * slidesToShow;

                        if (currentIndex >= totalSlides) {
                            currentIndex = 0;
                        }
                        if (currentIndex < 0) {
                            const lastFullSet = Math.floor((totalSlides - 1) / slidesToShow) * slidesToShow;
                            currentIndex = Math.max(0, lastFullSet);
                        }

                        updateSlider();
                    });
                });
            });
        });
    </script>
@endsection
