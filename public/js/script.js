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

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.slider').forEach(function(slider) {
        const slides = slider.querySelector('.slides');
        const slideList = slider.querySelectorAll('.slide');
        let currentIndex = 0;
        const totalSlides = slideList.length;
        const slidesToShow = 2; // ← сколько слайдов показывать

        if (totalSlides <= slidesToShow) return;

        function updateSlider() {
            const offset = -currentIndex * (100 / slidesToShow);
            slides.style.transform = `translateX(${offset}%)`;
        }

        slider.querySelectorAll('.slider-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const dir = parseInt(this.getAttribute('data-dir'));
                currentIndex += dir * slidesToShow;

                // Ограничение: не уходить за границы
                if (currentIndex >= totalSlides) {
                    currentIndex = 0;
                }
                if (currentIndex < 0) {
                    // Перейти к последнему полному набору
                    const lastFullSet = Math.floor((totalSlides - 1) / slidesToShow) * slidesToShow;
                    currentIndex = Math.max(0, lastFullSet);
                }

                updateSlider();
            });
        });
    });
});
