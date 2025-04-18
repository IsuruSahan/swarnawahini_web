<?php
$page_title = "Home | TV Channel";
require 'components/db_connect.php';
require 'components/header.php';
?>

<?php include 'components/banner_slider.php'; ?>

<main>
    <?php require 'components/teledrama_list.php'; ?>
    <?php require 'components/split_layout.php'; ?>
</main>

<?php require 'components/footer.php'; ?>