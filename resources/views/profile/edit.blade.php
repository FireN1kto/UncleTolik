@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleReviewCreate.css') }}">
    <script defer src="{{ asset('js/review.js') }}"></script
@endsection

@section('content')
    <div class="review-form">
        <h2 style="text-align: center; margin-bottom: 24px; color: #9c4dff;">Оставить отзыв отзыв</h2>

        <p><strong>Услуга:</strong> {{ $record->service->name }}</p>
        <p><strong>Мастер:</strong> {{ $record->master->surname ?? '—' }} {{ $record->master->name ?? '' }}</p>
        <p><strong>Дата:</strong> {{ $record->date_time->format('d.m.Y H:i') }}</p>
        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #444;">

        <form action="{{ route('review.store', $record) }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Ваша оценка:</label>
                <div class="stars">
                    <img src="{{ asset('img/star-white.png') }}" class="star" data-value="1">
                    <img src="{{ asset('img/star-white.png') }}" class="star" data-value="2">
                    <img src="{{ asset('img/star-white.png') }}" class="star" data-value="3">
                    <img src="{{ asset('img/star-white.png') }}" class="star" data-value="4">
                    <img src="{{ asset('img/star-white.png') }}" class="star" data-value="5">
                    <input type="hidden" name="rating" id="rating-input" value="0" required>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Ваш отзыв:</label>
                <textarea name="description" id="description" rows="5" placeholder="Расскажите о вашем опыте..." required></textarea>
                @error('description') <span style="color: #f44336;">{{ $message }}</span> @enderror
            </div>

            <div style="text-align: center; margin-top: 24px;">
                <button type="submit" class="btn">Отправить отзыв</button>
                <a href="{{ route('profile.user') }}" class="btn" style="background: #555; margin-left: 10px;">Отмена</a>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating-input');
            const whiteStar = "{{ asset('img/star-white.png') }}";
            const yellowStar = "{{ asset('img/star-yellow.png') }}";

            stars.forEach(star => {
                // Клик
                star.addEventListener('click', function () {
                    const value = parseInt(this.getAttribute('data-value'));
                    updateStars(value);
                    ratingInput.value = value;
                });

                // Hover
                star.addEventListener('mouseover', function () {
                    const value = parseInt(this.getAttribute('data-value'));
                    updateStarsVisual(value);
                });

                star.addEventListener('mouseout', function () {
                    const current = parseInt(ratingInput.value);
                    updateStarsVisual(current);
                });
            });

            function updateStarsVisual(maxValue) {
                stars.forEach((s, i) => {
                    const index = i + 1;
                    s.src = index <= maxValue ? yellowStar : whiteStar;
                });
            }

            function updateStars(value) {
                stars.forEach((s, i) => {
                    const index = i + 1;
                    s.src = index <= value ? yellowStar : whiteStar;
                });
            }
        });
    </script>
@endsection
