<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Role;

class AuthModal extends Component
{
    public $show = false;
    public $activeTab = 'login';

    // Поля для входа
    public $login_email = '';
    public $login_password = '';

    // Поля для регистрации
    public $FIO = '';
    public $login = '';
    public $email = '';
    public $password = '';

    public function login()
    {
        Log::info('LOGIN_ATTEMPT: Starting login process', [
            'email' => $this->login_email,
            'ip' => request()->ip(),
            'user_agent' => substr(request()->userAgent(), 0, 100)
        ]);

        try {
            $this->validate([
                'login_email' => 'required|email',
                'login_password' => 'required|min:1',
            ]);

            Log::debug('LOGIN_VALIDATION: Validation passed', [
                'email' => $this->login_email
            ]);

            $user = User::where('email', $this->login_email)->first();

            if (!$user) {
                Log::warning('LOGIN_FAILED: User not found', [
                    'email' => $this->login_email,
                    'ip' => request()->ip()
                ]);

                throw ValidationException::withMessages([
                    'login_email' => 'Неверный email или пароль',
                ]);
            }

            Log::debug('LOGIN_USER_FOUND: User exists in database', [
                'user_id' => $user->id,
                'email' => $user->email,
                'has_password' => !empty($user->password)
            ]);

            // Проверяем пароль
            if (!Hash::check($this->login_password, $user->password)) {
                Log::warning('LOGIN_FAILED: Password mismatch', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => request()->ip()
                ]);

                throw ValidationException::withMessages([
                    'login_email' => 'Неверный email или пароль',
                ]);
            }

            // Авторизуем пользователя
            Auth::login($user);

            Log::info('LOGIN_SUCCESS: User authenticated successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip()
            ]);

            $this->show = false;
            $this->resetForm();

            session()->flash('auth_message', 'Вы успешно вошли в систему!');
            return redirect('/');

        } catch (ValidationException $e) {
            Log::warning('LOGIN_VALIDATION_ERROR: Validation failed', [
                'errors' => $e->errors(),
                'email' => $this->login_email
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('LOGIN_ERROR: Unexpected error during login', [
                'error' => $e->getMessage(),
                'email' => $this->login_email,
                'trace' => $e->getTraceAsString()
            ]);

            throw ValidationException::withMessages([
                'login_email' => 'Произошла ошибка при входе. Попробуйте позже.',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('/');
    }

    public function register()
    {
        $this->validate([
            'FIO' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'min:8'],
        ], [
            'email.unique' => 'Этот email уже занят',
            'login.unique' => 'Этот логин уже занят',
            'password.confirmed' => 'Пароли не совпадают'
        ]);

        $fioParts = $this->splitFIO($this->FIO);

        // Получаем роль пользователя (по умолчанию)
        $userRole = Role::where('name', 'user')->first();

        if (!$userRole) {
            // Создаем роль по умолчанию если не существует
            $userRole = Role::create([
                'name' => 'user',
            ]);
        }

        // Создаем пользователя
        $user = User::create([
            'name' => $fioParts['name'],
            'patronymic' => $fioParts['patronymic'],
            'surname' => $fioParts['surname'],
            'email' => $this->email,
            'login' => $this->login,
            'password' => $this->password,
            'role_id' => Role::isUser()
        ]);

        Auth::login($user);

        $this->show = false;
        $this->resetForm();

        return redirect()->route('welcome');
    }

    private function splitFIO($fio)
    {
        $parts = explode(' ', trim($fio));

        $result = [
            'surname' => $parts[0] ?? '',
            'name' => $parts[1] ?? '',
            'patronymic' => $parts[2] ?? ''
        ];

        // Если только два слова - считаем первое имя, второе фамилия
        if (count($parts) == 2) {
            $result = [
                'name' => $parts[0] ?? '',
                'surname' => $parts[1] ?? '',
                'patronymic' => ''
            ];
        }

        return $result;
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset([
            'login_email', 'login_password',
            'FIO', 'email', 'password',
        ]);
    }

    public function render()
    {
        return view('livewire.auth-modal');
    }
}
