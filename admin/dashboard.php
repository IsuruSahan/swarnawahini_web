<?php
$page_title = "Admin Dashboard | TV Channel";
require '../components/db_connect.php';

// Initialize message variables
$teledrama_message = '';
$banner_message = '';
$special_program_message = '';

// Handle Teledrama Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && !isset($_POST['special_program_id'])) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $youtube_playlist = filter_input(INPUT_POST, 'youtube_playlist', FILTER_SANITIZE_STRING);
    $cover_image = '';

    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $cover_image = basename($_FILES['cover_image']['name']);
        $target_file = $target_dir . $cover_image;
        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_file)) {
            $teledrama_message = "Teledrama added successfully!";
        } else {
            $teledrama_message = "Error uploading cover image.";
        }
    }

    $stmt = $conn->prepare("INSERT INTO teledramas (title, description, youtube_playlist, cover_image) VALUES (:title, :description, :youtube_playlist, :cover_image)");
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':youtube_playlist' => $youtube_playlist,
        ':cover_image' => $cover_image
    ]);
    if (!$teledrama_message) {
        $teledrama_message = "Teledrama added successfully!";
    }
}

// Handle Banner Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['banner_image'])) {
    $target_dir = "../uploads/banners/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $banner_image = basename($_FILES['banner_image']['name']);
    $target_file = $target_dir . $banner_image;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['banner_image']['tmp_name']);
    if ($check !== false && in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO banners (image_path) VALUES (:image_path)");
            $stmt->execute([':image_path' => $banner_image]);
            $banner_message = "Banner uploaded successfully!";
        } else {
            $banner_message = "Error uploading banner.";
        }
    } else {
        $banner_message = "Invalid image file. Please upload JPG, PNG, or GIF.";
    }
}

// Handle Banner Deletion
if (isset($_GET['delete_banner']) && is_numeric($_GET['delete_banner'])) {
    $id = (int)$_GET['delete_banner'];
    $stmt = $conn->prepare("SELECT image_path FROM banners WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $banner = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($banner) {
        $file_path = "../uploads/banners/" . $banner['image_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $conn->prepare("DELETE FROM banners WHERE id = :id")->execute([':id' => $id]);
        $banner_message = "Banner deleted successfully!";
    } else {
        $banner_message = "Banner not found.";
    }
}

// Handle Special Program Submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['special_program_title'])) {
    $special_program_id = filter_input(INPUT_POST, 'special_program_id', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'special_program_title', FILTER_SANITIZE_STRING);
    $youtube_url = filter_input(INPUT_POST, 'youtube_url', FILTER_SANITIZE_URL);

    // Extract YouTube video ID from URL
    $video_id = '';
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtube_url, $match)) {
        $video_id = $match[1];
    }

    if (!$video_id) {
        $special_program_message = "Invalid YouTube URL. Please use a URL like https://www.youtube.com/watch?v=VIDEO_ID";
    } else {
        // Construct thumbnail URL directly from video ID
        $thumbnail_url = "https://i.ytimg.com/vi/{$video_id}/hqdefault.jpg";

        // Verify thumbnail URL accessibility (optional, for debugging)
        $headers = @get_headers($thumbnail_url);
        if ($headers && strpos($headers[0], '200') === false) {
            error_log("Thumbnail URL inaccessible: $thumbnail_url, Headers: " . implode(", ", $headers));
            $thumbnail_url = 'default.jpg';
            $special_program_message = "Thumbnail URL inaccessible. Using default image.";
        }

        if ($special_program_id) {
            // Update existing special program
            $stmt = $conn->prepare("UPDATE special_programs SET title = :title, youtube_url = :youtube_url, thumbnail_url = :thumbnail_url WHERE id = :id");
            $stmt->execute([
                ':title' => $title,
                ':youtube_url' => $youtube_url,
                ':thumbnail_url' => $thumbnail_url,
                ':id' => $special_program_id
            ]);
            $special_program_message = "Special program updated successfully!";
        } else {
            // Add new special program
            $stmt = $conn->prepare("INSERT INTO special_programs (title, youtube_url, thumbnail_url) VALUES (:title, :youtube_url, :thumbnail_url)");
            $stmt->execute([
                ':title' => $title,
                ':youtube_url' => $youtube_url,
                ':thumbnail_url' => $thumbnail_url
            ]);
            $special_program_message = "Special program added successfully!";
        }
    }
}

// Handle Special Program Deletion
if (isset($_GET['delete_special_program']) && is_numeric($_GET['delete_special_program'])) {
    $id = (int)$_GET['delete_special_program'];
    $stmt = $conn->prepare("DELETE FROM special_programs WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $special_program_message = "Special program deleted successfully!";
}

// Fetch all banners
$banners = $conn->query("SELECT * FROM banners ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all special programs
$special_programs = $conn->query("SELECT * FROM special_programs ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

require '../components/header.php';
?>

<div class="container mt-5">
    <h1 class="page-title"><?php echo $page_title; ?></h1>

    <!-- Teledrama Management -->
    <section class="mb-5">
        <h2 class="section-title">Add New Teledrama</h2>
        <?php if ($teledrama_message) { ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($teledrama_message); ?></div>
        <?php } ?>
        <form method="POST" enctype="multipart/form-data" class="glass-form">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="youtube_playlist" class="form-label">YouTube Playlist ID</label>
                <input type="text" id="youtube_playlist" name="youtube_playlist" class="form-control" placeholder="e.g., PLabcdef123456789" required>
            </div>
            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Image</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Add Teledrama</button>
        </form>
    </section>

    <!-- Banner Management -->
    <section class="mb-5">
        <h2 class="section-title">Manage Banners</h2>
        <?php if ($banner_message) { ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($banner_message); ?></div>
        <?php } ?>

        <!-- Banner Upload -->
        <form method="POST" enctype="multipart/form-data" class="glass-form mb-4">
            <div class="mb-3">
                <label for="banner_image" class="form-label">Upload New Banner</label>
                <input type="file" id="banner_image" name="banner_image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload Banner</button>
        </form>

        <!-- Banner List -->
        <?php if (!empty($banners)) { ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($banners as $banner) { ?>
                    <div class="col">
                        <div class="card">
                            <img src="/swarnawahini_web/uploads/banners/<?php echo htmlspecialchars($banner['image_path']); ?>" class="card-img-top" alt="Banner">
                            <div class="card-body">
                                <a href="?delete_banner=<?php echo $banner['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this banner?');">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>No banners uploaded yet.</p>
        <?php } ?>
    </section>

    <!-- Special Program Management -->
    <section>
        <h2 class="section-title">Manage Special Programs</h2>
        <?php if ($special_program_message) { ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($special_program_message); ?></div>
        <?php } ?>

        <!-- Special Program Add/Edit Form -->
        <form method="POST" class="glass-form mb-4">
            <input type="hidden" name="special_program_id" id="special_program_id" value="">
            <div class="mb-3">
                <label for="special_program_title" class="form-label">Title</label>
                <input type="text" id="special_program_title" name="special_program_title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="youtube_url" class="form-label">YouTube URL</label>
                <input type="url" id="youtube_url" name="youtube_url" class="form-control" placeholder="https://www.youtube.com/watch?v=VIDEO_ID" required>
            </div>
            <button type="submit" class="btn btn-primary" id="special_program_submit">Add Special Program</button>
        </form>

        <!-- Special Program List -->
        <?php if (!empty($special_programs)) { ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($special_programs as $program) { ?>
                    <div class="col">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($program['thumbnail_url'] ?? 'default.jpg'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($program['title']); ?>">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo htmlspecialchars($program['title']); ?></h6>
                                <p class="card-text"><?php echo htmlspecialchars($program['youtube_url']); ?></p>
                                <button class="btn btn-warning edit-special-program" data-id="<?php echo $program['id']; ?>" data-title="<?php echo htmlspecialchars($program['title']); ?>" data-url="<?php echo htmlspecialchars($program['youtube_url']); ?>">Edit</button>
                                <a href="?delete_special_program=<?php echo $program['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this special program?');">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>No special programs uploaded yet.</p>
        <?php } ?>
    </section>
</div>

<script>
document.querySelectorAll('.edit-special-program').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const url = button.getAttribute('data-url');

        document.getElementById('special_program_id').value = id;
        document.getElementById('special_program_title').value = title;
        document.getElementById('youtube_url').value = url;
        document.getElementById('special_program_submit').textContent = 'Update Special Program';
    });
});
</script>

<?php require '../components/footer.php'; ?>