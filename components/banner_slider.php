<?php
require 'components/db_connect.php';
$banner_stmt = $conn->query("SELECT * FROM banners ORDER BY created_at DESC");
$banners = $banner_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (!empty($banners)) { ?>
    <div class="banner-slider">
        <div class="banner-slides">
            <?php foreach ($banners as $index => $banner) { ?>
                <div class="banner-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                    <img src="/swarnawahini_web/uploads/banners/<?php echo htmlspecialchars($banner['image_path']); ?>" alt="Banner <?php echo $index + 1; ?>">
                </div>
            <?php } ?>
        </div>
        <button class="banner-prev">&#10094;</button>
        <button class="banner-next">&#10095;</button>
        <div class="banner-dots">
            <?php foreach ($banners as $index => $banner) { ?>
                <span class="banner-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>"></span>
            <?php } ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.banner-slide');
            const dots = document.querySelectorAll('.banner-dot');
            const prevButton = document.querySelector('.banner-prev');
            const nextButton = document.querySelector('.banner-next');
            let currentIndex = 0;

            function updateSlider(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === index);
                });
                currentIndex = index;
            }

            // Initial slide
            updateSlider(currentIndex);

            // Dot click
            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    updateSlider(i);
                });
            });

            // Previous button
            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateSlider(currentIndex);
            });

            // Next button
            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSlider(currentIndex);
            });

            // Auto-slide every 5 seconds
            setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSlider(currentIndex);
            }, 5000);
        });
    </script>
<?php } ?>