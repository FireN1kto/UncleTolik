<?php

namespace App\Livewire;

use App\Models\Records;
use App\Models\Services;
use database\Masters;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class RecordingFormModal extends Component
{
    public $isOpen = false;
    public $services;
    public $masters;

    public $FIO = '';
    public $number = '';
    public $selected_service = '';
    public $selected_master = '';
    public $date_time = '';

    public $showAlert = false;
    public $alertMessage = '';
    public $alertType = ''; // success, error, warning

    public function mount()
    {
        $this->services = Services::with('type')->get();
        $this->masters = Masters::all();

        if (Auth::check()) {
            $user = Auth::user();
            $this->FIO = trim($user->surname . ' ' . $user->name . ' ' . $user->patronymic);
        }
    }

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
            'FIO', 'number', 'selected_service', 'selected_master', 'date_time'
        ]);

        if (Auth::check()) {
            $user = Auth::user();
            $this->FIO = trim($user->surname . ' ' . $user->name . ' ' . $user->patronymic);
        }

        $this->resetErrorBag();
    }

    public function submit()
    {
        if (!Auth::check()) {
            $this->showAlert('Для записи на сеанс необходимо авторизоваться!', 'error');
            return;
        }

        $fioParts = $this->splitFIO($this->FIO);

        $this->validate([
            'FIO' => 'required|min:3|max:255',
            'number' => 'required|regex:/^\+7-\d{3}-\d{3}-\d{2}-\d{2}$/',
            'selected_service' => 'required',
            'selected_master' => 'required',
            'date_time' => 'required|date|after:now',
        ], [
            'FIO.required' => 'Поле ФИО обязательно для заполнения',
            'FIO.min' => 'ФИО должно содержать не менее 3 символов',
            'number.regex' => 'Формат телефона: +7-XXX-XXX-XX-XX',
            'date_time.after' => 'Дата и время должны быть в будущем',
        ]);

        // Создание записи
        $recordData = [
            'surname' => $fioParts['surname'],
            'name' => $fioParts['name'],
            'patronymic' => $fioParts['patronymic'],
            'number' => $this->number,
            'service_id' => $this->selected_service,
            'master_id' => $this->selected_master,
            'date_time' => $this->date_time,
            'status_id' => 1,
            'user_id' =>  Auth::id(),
        ];

        $record = Records::create($recordData);

        $this->showAlert('Запись успешно создана!', 'success');
        $this->closeModal();
    }

    public function showAlert($message, $type = 'success')
    {
        $this->alertMessage = $message;
        $this->alertType = $type;
        $this->showAlert = true;

        // Автоматическое скрытие alert-а через 5 секунд
        $this->dispatch('alert-showed');
        $this->dispatch('reset-alert-timer');
    }

    public function hideAlert()
    {
        $this->showAlert = false;
        $this->alertMessage = '';
        $this->alertType = '';
    }

    private function splitFIO($fio)
    {
        $parts = array_filter(explode(' ', trim($fio)));

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

    public function render()
    {
        return view('livewire.recording-form-modal');
    }
}
