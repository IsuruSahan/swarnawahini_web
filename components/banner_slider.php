<?php
require 'components/db_connect.php';
$banner_stmt = $conn->query("SELECT * FROM banners ORDER BY created_at DESC");
$banners = $banner_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (!empty($banners)) { ?>
    <div class="banner-slider-wrapper">
        <div class="banner-slider">
            <div class="banner-slides">
                <?php foreach ($banners as $index => $banner) { ?>
                    <div class="banner-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                        <img src="/swarnawahini_web/uploads/banners/<?php echo htmlspecialchars($banner['image_path']); ?>" alt="Banner <?php echo $index + 1; ?>">
                        <!-- <div class="banner-overlay"></div>
                        <div class="banner-content">
                            <h1 class="banner-title">TV DERANA</h1>
                            <p class="banner-subtitle">Sri Lanka’s Premier Entertainment Channel</p>
                            <a href="#" class="banner-button">WATCH NOW</a>
                        </div> -->
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <style>
        /* Reset all parent constraints */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            overflow-x: hidden !important;
            max-width: none !important;
        }

        /* Ensure no parent containers interfere */
        .banner-slider-wrapper, .banner-slider, .banner-slides, .banner-slide {
            margin: 0 !important;
            padding: 0 !important;
            width: 100vw !important;
            box-sizing: border-box !important;
            display: block !important;
            max-width: none !important;
            border-radius: 0 !important; /* Ensure container has no curved edges */
        }

        .banner-slider-wrapper {
            position: relative;
            overflow: hidden !important;
            left: 0 !important;
            right: 0 !important;
            transform: none !important;
            top: 0 !important; /* Ensure it sits directly below navbar */
        }

        .banner-slider {
            height: 500px; /* Matches reference image */
            position: relative;
        }

        .banner-slides {
            position: relative;
            height: 100%;
        }

        .banner-slide {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .banner-slide.active {
            opacity: 1;
        }

        .banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 0 !important; /* Remove curved edges on images */
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay for text readability */
            z-index: 5;
        }

        .banner-content {
            position: absolute;
            top: 50%;
            left: 5%;
            transform: translateY(-50%);
            color: white;
            z-index: 10 !important;
            display: block !important;
        }

        .banner-title {
            font-family: 'Poppins', sans-serif;
            font-size: 48px;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
        }

        .banner-subtitle {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 400;
            margin: 10px 0;
        }

        .banner-button {
            display: inline-block !important;
            background: #ff0000; /* Red button color */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .banner-button:hover {
            background: #cc0000; /* Darker red on hover */
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .banner-slider {
                height: 400px;
            }
            .banner-title {
                font-size: 36px;
            }
            .banner-subtitle {
                font-size: 16px;
            }
            .banner-button {
                padding: 8px 16px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .banner-slider {
                height: 300px;
            }
            .banner-title {
                font-size: 24px;
            }
            .banner-subtitle {
                font-size: 14px;
            }
            .banner-button {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.banner-slide');
            let currentIndex = 0;

            function updateSlider(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
            }

            updateSlider(currentIndex);

            // Auto-slide every 5 seconds
            setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSlider(currentIndex);
            }, 5000);
        });
    </script>
<?php } ?>