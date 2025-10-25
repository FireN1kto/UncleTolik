<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AuthModal extends Component
{
    public $isOpen = false;
    public $isLogin = true;

    public $login = '';
    public $password = '';

    public $reg_surname = '';
    public $reg_name = '';
    public $reg_patronymic = '';
    public $reg_email = '';
    public $reg_login = '';
    public $reg_password = '';
    public $reg_password_confirmation = '';
    protected $rulesLogin = [
        'login' => 'required',
        'password' => 'required|min:6',
    ];
    protected $rulesRegister = [
        'reg_surname' => 'required|min:2',
        'reg_name' => 'required|min:2',
        'reg_patronymic' => 'required|min:2',
        'reg_email' => 'required|email|unique:users,email',
        'reg_login' => 'required|unique:users,login',
        'reg_password' => 'required|min:6|confirmed',
    ];
    protected $messages = [
        'reg_email.unique' => 'Этот email уже занят',
        'reg_login.unique' => 'Этот логин уже занят',
        'reg_password.confirmed' => 'Пароли не совпадают',
    ];
    public function openModal()
    {
        $this->isOpen = true;
        $this->resetForm();
    }
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }
    public function resetForm()
    {
        $this->reset([
            'login', 'password',
            'reg_surname', 'reg_name', 'reg_patronymic',
            'reg_email', 'reg_login', 'reg_password', 'reg_password_confirmation'
        ]);
        $this->resetErrorBag();
    }
    public function switchToRegister()
    {
        $this->isLogin = false;
        $this->resetErrorBag();
    }

    public function switchToLogin()
    {
        $this->isLogin = true;
        $this->resetErrorBag();
    }
    public function login()
    {
        $this->validate($this->rulesLogin);

        $credentials = [
            'login' => $this->login,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            session()->flash('auth_message', 'Вы успешно вошли в систему!');
            $this->closeModal();
            $this->redirect('/');
        } else {
            $this->addError('login', 'Неверный логин или пароль');
        }
    }
    public function register()
    {
        $this->validate($this->rulesRegister);

        $userRole = Role::where(name == 'user')->first();

        $user = User::create([
            'surname' => $this->reg_surname,
            'name' => $this->reg_name,
            'patronymic' => $this->reg_patronymic,
            'email' => $this->reg_email,
            'login' => $this->reg_login,
            'password' => Hash::make($this->reg_password),
            'role_id' => $userRole->id
        ]);

        Auth::login($user);

        session()->flash('auth_message', 'Регистрация прошла успешно!');
        $this->closeModal();
        $this->redirect('/');
    }
    public function logout()
    {
        Auth::logout();
        session()->flash('auth_message', 'Вы вышли из системы');
        $this->redirect('/');
    }
    public function render()
    {
        return view('livewire.auth-modal');
    }
}
