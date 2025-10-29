<div>
    <div class="sign_up">
        <div>
            <button class="openOverlay" wire:click="openModal">Оформить запись</button>
        </div>
    </div>
    @if($isOpen)
        <div class="overlay">
            <div class="popup">
                <button class="closePopup" wire:click="closeModal">UncleTolik</button>
                <form wire:submit="submit">
                    @csrf
                    <legend>Записаться к нам на сеанс</legend>

                    <!-- ФИО -->
                    <div class="PersonalData">
                        <label for="FIO">Ваше Ф.И.О :</label>
                        <input type="text" id="FIO" placeholder="Иванов Иван Иванович"
                               wire:model="FIO">
                        @error('FIO') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <!-- Услуга -->
                    <div class="Servisec">
                        <label for="list_of_Services">Тип услуги :</label>
                        <select id="list_of_Services" wire:model="selected_service">
                            <option value="" disabled>Выберите тип услуги</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service->name }} - {{ $service->price }} ₽
                                </option>
                            @endforeach
                        </select>
                        @error('selected_service') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <!-- Мастер -->
                    <div class="Servisec">
                        <label for="list_of_Masters">Мастер :</label>
                        <select id="list_of_Masters" wire:model="selected_master">
                            <option value="" disabled>Выберите мастера</option>
                            @foreach($masters as $master)
                                <option value="{{ $master->id }}">
                                    {{ $master->surname }} {{ $master->name }} {{ $master->patronymic }}
                                </option>
                            @endforeach
                        </select>
                        @error('selected_master') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <!-- Телефон -->
                    <div class="Number">
                        <label for="number">Номер телефона :</label>
                        <input type="tel" id="number" placeholder="+7-800-555-35-35"
                               wire:model="number">
                        @error('number') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <!-- Дата и время (объединенные) -->
                    <div class="DateTime">
                        <label for="date_time">Дата и время :</label>
                        <input type="datetime-local" id="date_time" wire:model="date_time">
                        @error('date_time') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <!-- Кнопки управления -->
                    <div class="Control">
                        <div class="Reset">
                            <input type="button" value="Сбросить" wire:click="resetForm">
                        </div>
                        <div class="Send">
                            <input type="submit" value="Отправить">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Сообщение об успехе -->
    @if($showAlert)
        <div class="alert alert-{{ $alertType }}" wire:click="hideAlert">
            <div class="alert-content">
                <span class="alert-icon">
                    @if($alertType === 'success')
                        ✓
                    @elseif($alertType === 'error')
                        ⚠
                    @elseif($alertType === 'warning')
                        ℹ
                    @endif
                </span>
                <span class="alert-message">{{ $alertMessage }}</span>
                <button class="alert-close" wire:click="hideAlert">&times;</button>
            </div>
            <div class="alert-progress"></div>
        </div>
    @endif
</div>
