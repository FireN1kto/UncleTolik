<div>
    <!-- Кнопка открытия модального окна -->
    @auth
        <div class="user-menu">
            <span>Привет, {{ Auth::user()->name }}!</span>
            <button wire:click="logout" class="logout-btn">Выйти</button>
        </div>
    @else
        <a href="#" class="openAuth" wire:click.prevent="openModal">
            <img draggable="false" src="{{ asset('img/auth.png') }}" alt="auth">
        </a>
    @endauth

    <!-- Модальное окно аутентификации -->
    @if($isOpen)
        <div class="overlay" wire:click="closeModal">
            <div class="popup" wire:click.stop>
                <button class="closePopup" wire:click="closeModal">UncleTolik</button>

                @if($isLogin)
                    <!-- Форма входа -->
                    <form wire:submit.prevent="login">
                        @csrf
                        <legend>Авторизация</legend>

                        <div class="auth-login">
                            <label for="auth-login">Ваш login:</label>
                            <input type="text" id="login" wire:model="login" required>
                            @error('login') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="password">
                            <label for="password">Ваш пароль:</label>
                            <input type="password" id="password" wire:model="password" required>
                            @error('password') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="login">
                            <input type="submit" value="Вход">
                        </div>

                        <div class="Registr">
                            <a href="#" wire:click.prevent="switchToRegister">Регистрация</a>
                        </div>
                    </form>
                @else
                    <!-- Форма регистрации -->
                    <form wire:submit.prevent="register">
                        @csrf
                        <legend>Регистрация</legend>

                        <div class="auth-login">
                            <label for="reg_surname">Фамилия:</label>
                            <input type="text" id="reg_surname" wire:model="reg_surname" required>
                            @error('reg_surname') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="auth-login">
                            <label for="reg_name">Имя:</label>
                            <input type="text" id="reg_name" wire:model="reg_name" required>
                            @error('reg_name') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="auth-login">
                            <label for="reg_patronymic">Отчество:</label>
                            <input type="text" id="reg_patronymic" wire:model="reg_patronymic" required>
                            @error('reg_patronymic') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="login-for-reg">
                            <div class="auth-login-reg">
                                <label for="reg_email">Email:</label>
                                <input type="email" id="reg_email" wire:model="reg_email" required>
                                @error('reg_email') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            <div class="auth-login-reg">
                                <label for="reg_login">Логин:</label>
                                <input type="text" id="reg_login" wire:model="reg_login" required>
                                @error('reg_login') <span class="error-text">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="password-for-reg">
                            <div class="password-reg">
                                <label for="reg_password">Пароль:</label>
                                <input type="password" id="reg_password" wire:model="reg_password" required>
                                @error('reg_password') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            <div class="password-reg">
                                <label class="password-confirmation" for="reg_password_confirmation">Подтвердите пароль:</label>
                                <input type="password" id="reg_password_confirmation" wire:model="reg_password_confirmation" required>
                            </div>

                        </div>

                        <div class="registr-form">
                            <input type="submit" value="Зарегистрироваться">
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif

    <!-- Сообщения -->
    @if (session()->has('auth_message'))
        <div class="success-message">
            {{ session('auth_message') }}
        </div>
    @endif
</div>
