document.addEventListener('DOMContentLoaded', function () {
    // Initialize Bootstrap Carousel with options
    var myCarousel = document.querySelector('#carouselExample');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 3000, // Adjust the speed (3000ms = 3 seconds per slide)
        ride: 'carousel', // Automatically starts the carousel
        wrap: true // Allows the carousel to loop continuously
    });
});
