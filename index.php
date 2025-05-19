<?php
// $page_title = "Home | TV Channel";
require 'components/db_connect.php';
require 'components/header.php';
?>



<main>
<?php include 'components/banner_slider.php'; ?>
    <?php require 'components/teledrama_list.php'; ?>
    <?php require 'components/split_layout.php'; ?>
    <br>
    <?php require 'components/special_program.php'; ?>
    <?php require 'components/logos.php'; ?>
</main>

<?php require 'components/footer.php'; ?>