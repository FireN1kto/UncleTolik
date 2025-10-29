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
    public $activeTab = 'submit';

    // Поля для входа
    public $login_email = '';
    public $login_password = '';

    // Поля для регистрации
    public $FIO = '';
    public $login = '';
    public $email = '';
    public $password = '';

    public function submit()
    {
        $this->validate([
            'login_email' => 'required',
            'login_password' => 'required',
        ], [
            'login_email.regex' => 'Телефон должен быть в формате +7XXXXXXXXXX',
        ]);

        $user = User::where('email', $this->login_email)->first();

        if ($user && $user->password) {
            // Авторизуем пользователя
            Auth::login($user);

            $this->show = false;
            $this->resetForm();
            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'login_email' => 'Неверный email или пароль',
        ]);
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
