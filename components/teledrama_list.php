<?php
$api_key = 'AIzaSyBAON_ChCgF5BEXX7ijp--GImeRmAHdUBY';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = (basename($_SERVER['PHP_SELF']) === 'index.php') ? 3 : 9;
$offset = ($page - 1) * $items_per_page;

$total_stmt = $conn->query("SELECT COUNT(*) FROM teledramas");
$total_items = $total_stmt->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

$stmt = $conn->prepare("SELECT * FROM teledramas LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

// Function to fetch YouTube thumbnail using cURL
function getYouTubeThumbnail($playlist_id, $api_key, $conn, $teledrama_id) {
    // Check if thumbnail is already cached
    $stmt = $conn->prepare("SELECT thumbnail FROM teledramas WHERE id = :id");
    $stmt->bindValue(':id', $teledrama_id, PDO::PARAM_INT);
    $stmt->execute();
    $cached_thumbnail = $stmt->fetchColumn();

    if ($cached_thumbnail && $cached_thumbnail !== 'default.jpg') {
        return $cached_thumbnail; // Use cached thumbnail if available
    }

    // Fetch thumbnail from YouTube API
    $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=1&playlistId=$playlist_id&key=$api_key";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    // Log the response for debugging
    if ($http_code !== 200 || !$response) {
        error_log("YouTube API Error: HTTP Code $http_code, Error: $error, URL: $url, Response: $response");
        $thumbnail = 'default.jpg';
    } else {
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['items'][0]['snippet']['thumbnails']['medium']['url'])) {
            error_log("YouTube API JSON Error: " . json_last_error_msg() . ", Response: $response");
            $thumbnail = 'default.jpg';
        } else {
            $thumbnail = $data['items'][0]['snippet']['thumbnails']['medium']['url'];
        }
    }

    // Cache the thumbnail in the database
    $update_stmt = $conn->prepare("UPDATE teledramas SET thumbnail = :thumbnail WHERE id = :id");
    $update_stmt->bindValue(':thumbnail', $thumbnail, PDO::PARAM_STR);
    $update_stmt->bindValue(':id', $teledrama_id, PDO::PARAM_INT);
    $update_stmt->execute();

    return $thumbnail;
}
?>

<div class="container mt-5">
    <h1 class="page-title"><?php echo isset($page_title) ? $page_title : 'Teledramas'; ?></h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php
            $playlist_id = $row['youtube_playlist'];
            $thumbnail = getYouTubeThumbnail($playlist_id, $api_key, $conn, $row['id']);
            ?>
            <div class="col">
                <div class="card mb-4">
                    <img src="<?php echo htmlspecialchars($thumbnail); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <div class="card-body">
                        <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                        <a href="/swarnawahini_web/teledrama_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Episodes</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php if ($total_pages > 1) { ?>
        <nav aria-label="Teledrama pagination" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?php echo $page === $i ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php } ?>
</div>