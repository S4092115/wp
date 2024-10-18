document.addEventListener("DOMContentLoaded", function () {
    var pageSelect = document.getElementById('pageSelect');
    if (pageSelect) {
        pageSelect.addEventListener('change', function () {
            var url = this.value;
            if (url) {
                window.location.href = url;
            }
        });
    }
});
