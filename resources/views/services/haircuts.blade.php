@extends('layouts.app')

@section('title', 'Виды стрижек - UncleTolik')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleHaircuts.css') }}">
@endsection

@section('content')
    <div class="Block2">
        <h2>Стрижки</h2>
        <div class="Haircut">
            @foreach($services as $service)
                <div class="service-item">
                    <div class="service-info">
                        <h3>{{ $service->name }}
                            @if($service->description)
                                <span>({{ $service->description }})</span>
                            @endif
                        </h3>
                        <p>{{ $service->price }}р.</p>
                    </div>
                    <img src="{{ asset('img/row1.png') }}" alt="разделитель" class="divider">
                </div>
            @endforeach

            @if($services->isEmpty())
                <div class="no-services">
                    <div class="service-info">
                        <h3>Стрижки временно недоступны</h3>
                        <p>Свяжитесь с нами для уточнения</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
