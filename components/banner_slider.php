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
                    </div>
                <?php } ?>
            </div>
            <button class="banner-prev">❮</button>
            <button class="banner-next">❯</button>
        </div>
        <!-- Dots outside glassmorphism -->
        <div class="banner-dots">
            <?php foreach ($banners as $index => $banner) { ?>
                <span class="banner-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>"></span>
            <?php } ?>
        </div>
    </div>

    <style>
        .banner-slider-wrapper {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 10px auto;
        }

        .banner-slider {
            position: relative;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1); /* Glassmorphism only on slider */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .banner-slides {
            display: flex;
            width: 100%;
            height: 400px;
            transition: transform 0.5s ease;
        }

        .banner-slide {
            flex: 0 0 100%;
            width: 100%;
            display: none;
        }

        .banner-slide.active {
            display: block;
        }

        .banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .banner-prev, .banner-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.2);
    color: #1A237E;
    border: none;
    padding: 10px;
    cursor: pointer;
    font-size: 20px;
    border-radius: 50%; /* Ensures round shape */
    transition: background-color 0.3s ease;
    z-index: 10; /* Ensures buttons stay above slides */
}

        .banner-dots {
            text-align: center;
            padding: 10px 0;
            background: transparent; /* No glassmorphism */
        }

        .banner-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            margin: 0 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .banner-dot.active {
            background: #FFC107;
        }

        .banner-dot:hover {
            background: #ff0000;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.banner-slide');
            const dots = document.querySelectorAll('.banner-dot');
            const prev = document.querySelector('.banner-prev');
            const next = document.querySelector('.banner-next');
            let currentIndex = 0;

            function updateSlider(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === index);
                });
            }

            // Initial setup
            updateSlider(currentIndex);

            // Previous button
            prev.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateSlider(currentIndex);
            });

            // Next button
            next.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSlider(currentIndex);
            });

            // Dot navigation
            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    currentIndex = parseInt(dot.getAttribute('data-index'));
                    updateSlider(currentIndex);
                });
            });

            // Auto-slide every 5 seconds
            setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSlider(currentIndex);
            }, 5000);
        });
    </script>
<?php } ?>