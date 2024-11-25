<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="index.html"><i class="mdi mdi-airplay"></i>Dashboard</a>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="mdi mdi-layers"></i>Management</a>
                    <?php if($_SESSION['role'] == 'admin'): ?>
                    <ul class="submenu">
                        <li><a href="<?= $_ENV['BASE_URL']; ?>/users">Users</a></li>
                    </ul>
                    <?php endif ?>
                </li>

            </ul>
            <!-- End navigation menu -->
        </div> <!-- end #navigation -->
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->