@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleReviewsAdmin.css') }}">
@endsection

@section('content')
    <div class="reviews-page">
        <h1>Работа с отзывами</h1>
        <div class="section-header">
            <h3>Неподтверждённые отзывы</h3>
        </div>
        <div class="review-list">
            @if($unpublished->count() > 0)
                @foreach($unpublished as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div class="review-client">
                                <img src="{{ $review->user->avatar ? Storage::url($review->user->avatar) : asset('img/default_avatar.png') }}" alt="Аватар" class="review-avatar">
                                {{ $review->surname }} {{ $review->name }}
                            </div>
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <img src="{{ asset('img/star-yellow.png') }}" alt="★" width="24" height="24" style="margin-right: 2px;">
                                    @else
                                        <img src="{{ asset('img/star-white.png') }}" alt="☆" width="24" height="24" style="margin-right: 2px;">
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="review-service">
                            Услуга: {{ $review->record?->service?->name ?? '—' }}
                        </div>
                        <div class="review-text">
                            {{ $review->description }}
                        </div>
                        <div class="review-actions">
                            <form method="POST" action="{{ route('admin.reviews.publish', $review) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-publish">Опубликовать</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-message">Нет неподтверждённых отзывов</div>
            @endif
        </div>
    </div>
@endsection
