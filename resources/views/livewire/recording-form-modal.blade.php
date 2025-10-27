<div>
    <div class="sign_up">
        <div>
            <button class="openOverlay" wire:click="openModal">Оформить запись</button>
        </div>
    </div>
    @if($isOpen)
        <div class="overlay" wire:click="closeModal">
            <div class="popup" wire:click.stop>
                <button class="closePopup" wire:click="closeModal">UncleTolik</button>
                <form wire:submit.prevent="submit">
                    <legend>Записаться к нам на сеанс</legend>

                    <!-- ФИО -->
                    <div class="PersonalData">
                        <label for="FIO">Ваше Ф.И.О :</label>
                        <input type="text" id="FIO" placeholder="Иванов Иван Иванович"
                               wire:model="surname" required>
                        @error('surname') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <!-- Услуга -->
                    <div class="Servisec">
                        <label for="list_of_Services">Тип услуги :</label>
                        <select id="list_of_Services" wire:model="selected_service" required>
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
                        <select id="list_of_Masters" wire:model="selected_master" required>
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
                        <label for="nomber">Номер телефона :</label>
                        <input type="tel" id="nomber" placeholder="+7-800-555-35-35"
                               wire:model="number" required>
                        @error('number') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <!-- Дата и время (объединенные) -->
                    <div class="DateTime">
                        <label for="date_time">Дата и время :</label>
                        <input type="datetime-local" id="date_time" wire:model="date_time" required>
                        @error('date_time') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <!-- Кнопки управления -->
                    <div class="Control">
                        <div class="Reset">
                            <input type="button" value="Сбросить" wire:click="resetForm">
                        </div>
                        <div class="Send">
                            <input type="submit" value="Отправить" wire:submit.prevent="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Сообщение об успехе -->
    @if (session()->has('message'))
        <div class="success-message">
            {{ session('message') }}
        </div>
    @endif
</div>
