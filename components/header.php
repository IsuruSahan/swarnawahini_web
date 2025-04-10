<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Add this if missing -->
    <title><?php echo isset($page_title) ? $page_title : 'TV Channel'; ?></title>
    <link rel="stylesheet" href="/swarnawahini_web/css/bootstrap.min.css">
    <link rel="stylesheet" href="/swarnawahini_web/css/custom.css">
    <!-- Add Poppins font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light">
    <!-- Replace text with logo -->
    <a class="navbar-brand" href="/swarnawahini_web/index.php">
        <img src="/swarnawahini_web/uploads/logo.png" alt="TV Channel Logo" style="height: 50px;">
    </a>
    
    <!-- Move nav items to the right -->
<div class="collapse navbar-collapse justify-content-end">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="/swarnawahini_web/pages/teledramas.php">Teledramas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/swarnawahini_web/admin/dashboard.php">News</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/swarnawahini_web/admin/dashboard.php">Contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/swarnawahini_web/admin/dashboard.php">Admin</a>
        </li>
        <!-- Add the LIVE button -->
        <li class="nav-item">
            <a href="/swarnawahini_web/live.php" class="live-button">
                <span class="live-circle"></span> LIVE
            </a>
        </li>
    </ul>
</div>
</nav>
<div class="container mt-5">