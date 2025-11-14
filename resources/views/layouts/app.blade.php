<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/pagesCss/style.css') }}">
    @livewireStyles
    <link rel="icon" href="{{ asset('img/Favikonka.png') }}">
    <title>UncleTolik</title>
    @yield('styles')
</head>
<body>
@if(Request::is('/'))
    <!-- Хедер для главной страницы -->
    <header class="main-header">
        <div class="Header wrapper">
            <div class="FirsteLine1">
                @if(Auth::check() && Auth::user()->isAdmin())
                    <a href="#">Мастера</a>
                    <a href="{{ route('admin.records') }}">Записи</a>
                    <a href="#">Отзывы</a>
                    <a href="{{ route('admin.users') }}">Пользователи</a>
                    <livewire:auth-modal />
                @else
                    <a href="{{ route('masters') }}">Наши мастера</a>
                    <a href="{{ route('services') }}">Услуги в Tolik-е</a>
                    <a href="{{ route('works') }}">Работы мастеров</a>
                    <a href="#">Отзывы о нас</a>
                    <livewire:auth-modal />
                @endif
            </div>
        </div>
    </header>
@else
    <header class="internal-header">
        <div class="Header internal">
            @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('welcome') }}" class="logo">UT</a>
                <div class="nav-links">
                    <a href="#">Мастера</a>
                    <a href="{{ route('admin.records') }}">Записи</a>
                    <a href="#">Отзывы</a>
                    <a href="{{ route('admin.users') }}">Пользователи</a>
                </div>
            @else
                <a href="{{ route('welcome') }}" class="logo">UT</a>
                <div class="nav-links">
                    <a href="{{ route('masters') }}">Наши мастера</a>
                    <a href="{{ route('services') }}">Услуги в Tolik-е</a>
                    <a href="{{ route('works') }}">Работы мастеров</a>
                    <a href="#">Отзывы о нас</a>
                </div>
            @endif
        </div>
    </header>
@endif
<main>
    @yield('content')
</main>
<footer>
    <div>
        <h3>UncleTolik</h3>
    </div>
    <div>
        <div>
            <p>Наши адреса:</p>
            <a href="">г. Томск ул. Ленина д.100</a>
            <a href="">г. Томск пр. Мира д.50</a>
        </div>
        <div>
            <p>Связь с нами:</p>
            <a href="tel:+7-906-199-84-09">+7-906-199-84-09</a>
            <a href="">Мы в ВК</a>
            <a href="">Мы в Telegram-е</a>
        </div>
    </div>
</footer>
@yield('styles')
@livewireScripts
<script defer src="{{ asset('js/script.js') }}"></script>
</body>
</html>
