<?php require('layouts/meta.php');?>
<!-- Navigation Bar-->
<?php require('layouts/header.php'); ?>
<!-- End Navigation Bar-->

<!-- Content -->
<div class="wrapper">
    <div class="container-fluid">
        <?php
        // Lokasi folder view
        $viewPath = __DIR__ . "/$page.php";
        // echo $viewPath;

        // Cek apakah file view ada, jika tidak tampilkan pesan error
        if (file_exists($viewPath)) {
            require($viewPath); // Muat file view
        } else {
            echo '<h1>404 - Halaman Tidak Ditemukan</h1>';
        }
        ?>
    </div>
</div>
<!-- End Content -->

<!-- Footer -->
<?php require('layouts/footer.php'); ?>
<!-- End Footer -->

<!-- Scripts -->
<?php require('layouts/script.php'); ?>

