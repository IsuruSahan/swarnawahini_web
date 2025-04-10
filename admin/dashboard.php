<?php
$page_title = "Admin Dashboard | TV Channel";
require '../components/db_connect.php';

// Initialize message variables
$teledrama_message = '';
$banner_message = '';

// Handle Teledrama Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
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

// Fetch all banners
$banners = $conn->query("SELECT * FROM banners ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

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
    <section>
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
</div>

<?php require '../components/footer.php'; ?>