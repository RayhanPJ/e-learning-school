<?php
$base_url = "/e-learning-school/public/assets/template";
?>
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <a href="index.html" class="logo">
                    <img src="<?= $base_url; ?>/images/logo-sm.png" alt="" height="22" class="logo-small">
                    <img src="<?= $base_url; ?>/images/logo.png" alt="" height="16" class="logo-large">
                </a>
            </div>
            <!-- End Logo container-->

            <!-- end menu-extras -->
            <?php require('nav-extra.php');?>
            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <!-- MENU Start -->
    <?php require('navbar.php');?>
</header>       