@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/styleServices.css') }}">
@endsection

@section('content')
    <div class="Main">
        @foreach($types as $type)
            <div class="Block{{ $loop->iteration }}">
                @if($type->name == 'Бритьё')
                    <a href="#" class="shaving">
                        @elseif($type->name == 'Стрижки')
                            <a href="{{ route('services.haircuts') }}" class="haircuts">
                                @elseif($type->name == 'Уход за лицом')
                                    <a href="#" class="facialTreatment">
                                        @else
                                            <a href="#" class="coming-soon">
                                                @endif
                                                {{ $type->name }}
                                            </a>
            </div>
        @endforeach

        @for($i = count($types) + 1; $i <= 3; $i++)
            <div class="Block{{ $i }}">
                <a href="#" class="coming-soon">
                    Скоро
                </a>
            </div>
        @endfor
    </div>
    @if($types->isEmpty())
        <div class="no-services">
            <h3>Услуги временно недоступны</h3>
            <p>Пожалуйста, проверьте позже</p>
        </div>
    @endif
@endsection
