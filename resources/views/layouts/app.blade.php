<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/pagesCss/style.css') }}">
    <link rel="icon" href="{{ asset('img/Favikonka.png') }}">
    <title>UncleTolik</title>
    @yield('styles')
</head>
<body>
<header>
    <div class="Header wrapper">
        <div class="FirsteLine1">
            <a href="#">Наши мастера</a>
            <a href="#">Услуги в Tolik-е</a>
            <a href="#">Работы мсатеров</a>
            <a href="#">Отзывы о нас</a>
            <a href="#" class="openAuth"><img draggable="false" src="{{ asset('img/auth.png') }}" alt="auth"></a>
        </div>
    </div>
</header>
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
</body>
</html>
