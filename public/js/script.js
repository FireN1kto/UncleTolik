document.addEventListener('livewire:init', () => {});
document.addEventListener('livewire:init', () => {
    let alertTimer;

    // Функция для сброса таймера
    function resetAlertTimer() {
        clearTimeout(alertTimer);
        alertTimer = setTimeout(() => {
            Livewire.dispatch('hide-alert');
        }, 5000);
    }

    // Слушаем события от Livewire
    Livewire.on('reset-alert-timer', () => {
        resetAlertTimer();
    });

    Livewire.on('hide-alert', () => {
    @this.hideAlert();
    });

    // Автоматический запуск таймера при появлении alert-а
    Livewire.on('alert-showed', () => {
        resetAlertTimer();
    });
});
