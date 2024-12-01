<?php
$base_url = "/e-learning-school/public/assets/template";

?>
<div class="menu-extras topbar-custom">
    <ul class="list-inline float-right mb-0">
        <!-- User-->
        <li class="list-inline-item dropdown notification-list">
            <?php if($_SESSION['role'] == 'guest'): ?>
                <a class="btn btn-sm btn-primary w-100 m-t-10" href="<?= $_ENV['BASE_URL']; ?>/login">Login</a>
            <?php else : ?>
            <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <img src="<?= $base_url; ?>/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5>Welcome <?= $_SESSION['username'] ?></h5>
                </div>
                <a class="dropdown-item" href="<?= $_ENV['BASE_URL']; ?>/logout"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
            </div>
            <?php endif ?>
        </li>
        <li class="menu-item list-inline-item">
            <!-- Mobile menu toggle-->
            <a class="navbar-toggle nav-link">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
            <!-- End mobile menu toggle-->
        </li>

    </ul>
</div>