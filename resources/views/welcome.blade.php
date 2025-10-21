@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/PagesCss/style.css') }}">
@endsection

@section('content')
    <div class="bg">
        <h1>UncleTolik</h1>
        <div>
            <div class="aboutUs">
                <div>
                    <h2>О НАШЕМ БАРБЕРШОПЕ:</h2>
                    <p>Наш барбершоп - место, где мужчина любого возраста почувствует себя в руках профессионалов.
                        Помимо профессионального подхода к бритью и стрижкам в барбершопе создана исконно мужская - деловая атмосфера.
                        Барберы поддержат любой разговор, администратор предложит напитки, а вы обязательно захотите посетить нас ещё раз.
                    </p>
                </div>
            </div>
            <div class="sign_up">
                <div>
                    <button class="openOverlay">Оформить запись</button>
                </div>
            </div>
        </div>
    </div>
@endsection
