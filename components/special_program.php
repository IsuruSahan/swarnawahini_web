<?php
// Fetch special program videos from the database
$stmt = $conn->query("SELECT * FROM special_programs ORDER BY created_at DESC");
$special_programs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($special_programs)) {
    echo '<p>No special programs available.</p>';
    return;
}

// Get the latest video for the banner
$banner_video = $special_programs[0];

// Extract video ID to ensure thumbnail URL is correct
$video_id = '';
if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $banner_video['youtube_url'], $match)) {
    $video_id = $match[1];
}

$banner_thumbnail = $video_id ? "https://i.ytimg.com/vi/{$video_id}/hqdefault.jpg" : 'default.jpg';

// Debug thumbnail URL
error_log("Special Program Banner: ID {$banner_video['id']}, Title: {$banner_video['title']}, Thumbnail URL: {$banner_thumbnail}");
?>

<!-- Banner Section -->
<div class="special-program-banner position-relative mb-5 mx-auto" style="max-width: 1200px;">
    <a href="<?php echo htmlspecialchars($banner_video['youtube_url']); ?>" target="_blank">
        <div class="glass-card position-relative overflow-hidden" style="border-radius: 20px;">
            <img src="<?php echo htmlspecialchars($banner_thumbnail); ?>" class="img-fluid w-100" alt="<?php echo htmlspecialchars($banner_video['title']); ?>" style="aspect-ratio: 16/9; object-fit: cover;" onerror="this.src='https://via.placeholder.com/1280x720?text=Image+Failed+to+Load'; this.onerror=null;">
            <!-- Play Button Overlay -->
            <div class="play-button-overlay position-absolute top-50 start-50 translate-middle">
                <svg width="100" height="70" viewBox="0 0 100 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="35" r="35" fill="#FFC107" fill-opacity="0.8"/>
                    <path d="M40 25V45L60 35L40 25Z" fill="white"/>
                </svg>
            </div>
        </div>
    </a>
</div>


<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.special-program-slider .swiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
        },
    });
</script>

<style>
/* Glassmorphism Effect */
.glass-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover Effects */
.glass-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.play-button-overlay:hover svg circle {
    fill: #FF0000;
    fill-opacity: 1;
}

/* Slider Video Title */
.video-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    font-weight: 400;
    color: #ffffff;
}

/* Swiper Navigation Buttons */
.swiper-button-next, .swiper-button-prev {
    color: #FFC107;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
}

.swiper-button-next:hover, .swiper-button-prev:hover {
    background: #FFC107;
    color: #1A237E;
}

.swiper-button-next:after, .swiper-button-prev:after {
    font-size: 20px;
}

/* Swiper Pagination */
.swiper-pagination-bullet {
    background: rgba(255, 255, 255, 0.5);
    opacity: 1;
}

.swiper-pagination-bullet-active {
    background: #FFC107;
}

/* Responsive Adjustments */
@media (max-width: 767px) {
    .special-program-banner {
        border-radius: 15px;
    }

    .glass-card {
        border-radius: 15px;
    }

    .play-button-overlay svg {
        width: 80px;
        height: 56px;
    }
}

@media (max-width: 576px) {
    .special-program-banner {
        border-radius: 10px;
    }

    .glass-card {
        border-radius: 10px;
    }

    .play-button-overlay svg {
        width: 60px;
        height: 42px;
    }
}
</style>