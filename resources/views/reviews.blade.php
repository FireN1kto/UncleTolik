@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleReviews.css') }}">
@endsection

@section('content')
    <div class="reviews-page">
        <h1 class="page-title">Отзывы клиентов о нас</h1>

        <div class="reviews">
            @foreach($reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        <img src="{{ $review->user->avatar ? Storage::url($review->user->avatar) : asset('img/default_avatar.png') }}" alt="Аватар" class="review-avatar">
                        <div class="review-name">{{ $review->surname }} {{ $review->name }}</div>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <img src="{{ asset('img/star-yellow.png') }}" alt="★" width="24" height="24" style="margin-right: 2px;">
                                @else
                                    <img src="{{ asset('img/star-white.png') }}" alt="☆" width="24" height="24" style="margin-right: 2px;">
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div class="review-text">
                        <p>{{ $review->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
