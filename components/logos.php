<!-- Swiper Slider Structure -->
<div >
    <div class="container">
        <!-- Swiper Container -->
        <div class="swiper logo-slider">
            <!-- Swiper Wrapper -->
            <div class="swiper-wrapper">
                <!-- Swiper Slides -->
                <div class="swiper-slide" style="background: #ffffff; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); border: 1px solid #e0e0e0; padding: 1.25rem; text-align: center;">
                    <img src="/swarnawahini_web/uploads/efm.png" alt="TV Channel Logo" style="height: 50px; width: auto; display: block; margin: 0 auto;">
                </div>
                <div class="swiper-slide" style="background: #ffffff; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); border: 1px solid #e0e0e0; padding: 1.25rem; text-align: center;">
                    <img src="/swarnawahini_web/uploads/etv.png" alt="TV Channel Logo" style="height: 50px; width: auto; display: block; margin: 0 auto;">
                </div>
                <div class="swiper-slide" style="background: #ffffff; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); border: 1px solid #e0e0e0; padding: 1.25rem; text-align: center;">
                    <img src="/swarnawahini_web/uploads/ran2.png" alt="TV Channel Logo" style="height: 50px; width: auto; display: block; margin: 0 auto;">
                </div>
                <div class="swiper-slide" style="background: #ffffff; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); border: 1px solid #e0e0e0; padding: 1.25rem; text-align: center;">
                    <img src="/swarnawahini_web/uploads/sri.png" alt="TV Channel Logo" style="height: 50px; width: auto; display: block; margin: 0 auto;">
                </div>
                <div class="swiper-slide" style="background: #ffffff; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); border: 1px solid #e0e0e0; padding: 1.25rem; text-align: center;">
                    <img src="/swarnawahini_web/uploads/logo.png" alt="TV Channel Logo" style="height: 50px; width: auto; display: block; margin: 0 auto;">
                </div>
            </div>
            <!-- Navigation Arrows -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <!-- Pagination Dots -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<!-- Swiper Initialization Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoSlider = new Swiper('.logo-slider', {
            // Number of slides to show at once
            slidesPerView: 5, // Show 5 logos on desktop
            spaceBetween: 10, // 10px space between slides (matches previous spacing)
            loop: true, // Enable infinite loop
            autoplay: {
                delay: 3000, // Slide every 3 seconds
                disableOnInteraction: false, // Continue autoplay after user interaction
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                // Mobile: Show 1 slide at a time
                0: {
                    slidesPerView: 1,
                    spaceBetween: 8, // 8px space between slides on mobile
                },
                // Tablet: Show 3 slides at a time
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                // Desktop: Show 5 slides at a time
                992: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                },
            },
        });
    });
</script>