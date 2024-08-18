document.addEventListener('DOMContentLoaded', function () {
    var dropdown = document.querySelector('.dropdown');
    dropdown.addEventListener('click', function () {
        this.classList.toggle('open');
    });
});
