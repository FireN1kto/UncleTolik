document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-input');
    const whiteStar = "{{ asset('img/star-white.png') }}";
    const yellowStar = "{{ asset('img/star-yellow.png') }}";

    stars.forEach(star => {
        // Клик
        star.addEventListener('click', function () {
            const value = parseInt(this.getAttribute('data-value'));
            updateStars(value);
            ratingInput.value = value;
        });

        // Hover
        star.addEventListener('mouseover', function () {
            const value = parseInt(this.getAttribute('data-value'));
            updateStarsVisual(value);
        });

        star.addEventListener('mouseout', function () {
            const current = parseInt(ratingInput.value);
            updateStarsVisual(current);
        });
    });

    function updateStarsVisual(maxValue) {
        stars.forEach((s, i) => {
            const index = i + 1;
            s.src = index <= maxValue ? yellowStar : whiteStar;
        });
    }

    function updateStars(value) {
        stars.forEach((s, i) => {
            const index = i + 1;
            s.src = index <= value ? yellowStar : whiteStar;
        });
    }
});
