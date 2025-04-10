<?php
require 'components/db_connect.php';

// Get teledrama ID from URL
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM teledramas WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$teledrama = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if teledrama exists
if (!$teledrama) {
    die("Teledrama not found.");
}

// YouTube API setup
$api_key = 'AIzaSyBAON_ChCgF5BEXX7ijp--GImeRmAHdUBY'; // Your provided API key
$playlist_id = $teledrama['youtube_playlist'];
$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=$playlist_id&key=$api_key";

// Debug: Print the playlist ID and URL
echo "Playlist ID: $playlist_id<br>";
echo "API URL: $url<br>";

// Fetch data using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    curl_close($ch);
    die("cURL Error: $error_msg");
}
curl_close($ch);

// Parse the response
$playlist_data = json_decode($response, true);
if (isset($playlist_data['error'])) {
    echo "YouTube API Error: " . $playlist_data['error']['message'] . "<br>";
    $episodes = [];
} else {
    $episodes = $playlist_data['items'] ?? [];
}

// Set page title
$page_title = $teledrama['title'] . " | TV Channel";
require 'components/header.php';
?>

<h1><?php echo $teledrama['title']; ?></h1>
<p><?php echo $teledrama['description']; ?></p>
<?php if ($teledrama['cover_image']) { ?>
    <img src="/swarnawahini_web/uploads/<?php echo $teledrama['cover_image']; ?>" class="img-fluid mb-4" alt="Cover Image" style="max-height: 300px;">
<?php } else { ?>
    <p>No cover image available.</p>
<?php } ?>

<h3>Episodes</h3>
<div class="row">
    <?php foreach ($episodes as $episode) { ?>
        <?php
        $video_id = $episode['snippet']['resourceId']['videoId'];
        $title = $episode['snippet']['title'];
        $thumbnail = $episode['snippet']['thumbnails']['medium']['url'] ?? 'default.jpg';
        $youtube_link = "https://www.youtube.com/watch?v=$video_id";
        ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?php echo $thumbnail; ?>" class="card-img-top" alt="<?php echo $title; ?>">
                <div class="card-body">
                    <h6 class="card-title"><?php echo $title; ?></h6>
                    <a href="<?php echo $youtube_link; ?>" target="_blank" class="btn btn-primary btn-sm">Watch</a>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (empty($episodes)) { ?>
        <p>No episodes found for this playlist.</p>
    <?php } ?>
</div>

<?php require 'components/footer.php'; ?>