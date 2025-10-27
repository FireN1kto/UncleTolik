<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Services;
use App\Models\Masters;
use App\Models\Records;

class RecordingFormModal extends Component
{
    public $isOpen = false;
    public $services;
    public $masters;

    public $surname = '';
    public $name = '';
    public $patronymic = '';
    public $number = '';
    public $selected_service = '';
    public $selected_master = '';
    public $date_time = '';

    protected $rules = [
        'surname' => 'required|min:2',
        'name' => 'required|min:2',
        'patronymic' => 'required|min:2',
        'number' => 'required|regex:/^\+7-\d{3}-\d{3}-\d{2}-\d{2}$/',
        'selected_service' => 'required',
        'selected_master' => 'required',
        'date_time' => 'required|date|after:now',
    ];

    protected $messages = [
        'number.regex' => 'Формат телефона: +7-XXX-XXX-XX-XX',
        'date_time.after' => 'Дата и время должны быть в будущем',
    ];

    public function mount()
    {
        $this->services = Services::with('type')->get();
        $this->masters = Masters::all();
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
            'surname', 'name', 'patronymic', 'number',
            'selected_service', 'selected_master', 'date_time'
        ]);
        $this->resetErrorBag();
    }

    public function submit()
    {
        $this->validate();

        // Создание записи
        Records::create([
            'surname' => $this->surname,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'number' => $this->number,
            'service_id' => $this->selected_service,
            'master_id' => $this->selected_master,
            'date_time' => $this->date_time,
            'status_id' => 1,
            'user_id' => auth()->id() ?? null,
        ]);

        session()->flash('message', 'Запись успешно создана!');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.recording-form-modal');
    }
}
