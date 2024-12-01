<?php
$base_url = "/e-learning-school/public/assets/template";
?>
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <a href="" class="logo ">
                    <span class="text-dark">SEKOLAH HEBAT</span>
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
    
    <?php if($_SESSION['role'] == 'guest'): ?>
    <?php else : ?>
        <?php require('navbar.php');?>
    <?php endif ?>
</header>       