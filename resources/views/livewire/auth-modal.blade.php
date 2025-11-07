<div>
    <!-- Кнопка открытия модального окна -->
    @auth
        <div class="user-menu">
            <div class="profile-dropdown">
                <button class="profile-btn">
                    <img draggable="false" src="{{ asset('img/profile.png') }}" alt="profile">
                </button>
                <div class="dropdown-content">
                    @if(Auth::user()->isMaster())
                        <a href="{{ route('profile.master') }}" class="dropdown-item">
                            <i class="fas fa-user-tie"></i>
                            Профиль мастера
                        </a>
                    @elseif(Auth::user()->isAdmin())
                        <p>Здравствуйте {{ Auth::user()->name }}!</p>
                    @else
                        <a href="{{ route('profile.user') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            Мой профиль
                        </a>
                    @endif

                    <div class="dropdown-divider"></div>
                    <button wire:click="logout" class="dropdown-item logout-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Выйти
                    </button>
                </div>
            </div>
        </div>
    @else
        <a href="#" class="openAuth" wire:click.prevent="$set('show', true)">
            <img draggable="false" src="{{ asset('img/auth.png') }}" alt="auth">
        </a>
    @endauth

    <!-- Модальное окно аутентификации -->
    @if($show)
        <div class="overlay">
            <div class="popup">
                <button class="closePopup" wire:click="$set('show', false)">UncleTolik</button>

                @if($activeTab === 'submit')
                    <!-- Форма входа -->
                    <form wire:submit="submit">
                        @csrf
                        <legend>Авторизация</legend>

                        <div class="auth-login">
                            <label for="login_email">Ваш email</label>
                            <input id="login_email" name="login_email" type="email" wire:model="login_email">
                            @error('login_email') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="password">
                            <label for="login_password">Ваш пароль:</label>
                            <input type="password" name="login_password" id="login_password" wire:model="login_password">
                            @error('login_password') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="login">
                            <input type="submit" value="Войти">
                        </div>

                        <div class="Registr">
                            <a href="#" wire:click="switchTab('register')">Регистрация</a>
                        </div>
                    </form>
                @endif
                @if($activeTab === 'register')
                    <!-- Форма регистрации -->
                    <form wire:submit="register">
                        @csrf
                        <legend>Регистрация</legend>

                        <div class="auth-fio">
                            <label for="FIO"></label>
                            <input id="FIO" name="FIO" type="text" placeholder="ФИО" wire:model="FIO">
                            @error('FIO') <span class="error">{{ $message }}</span> @enderror
                            <label for="tel"></label>
                        </div>

                        <div class="login-for-reg">
                            <div class="auth-login-reg">
                                <label for="email">Email:</label>
                                <input type="email" id="email" wire:model="email">
                                @error('email') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            <div class="auth-login-reg">
                                <label for="login">Логин:</label>
                                <input type="text" id="login" wire:model="login">
                                @error('login') <span class="error-text">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="password-for-reg">
                            <div class="password-reg">
                                <label for="password">Пароль:</label>
                                <input type="password" id="password" wire:model="password">
                                @error('password') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            <div class="password-reg">
                                <label class="password-confirmation" for="password_confirmation">Подтвердите пароль:</label>
                                <input type="password" id="password_confirmation" wire:model="password_confirmation">
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
