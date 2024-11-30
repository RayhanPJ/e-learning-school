<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="index.html"><i class="mdi mdi-airplay"></i>Dashboard</a>
                </li>

                <li class="has-submenu">
                    <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="#"><i class="mdi mdi-layers"></i>Management</a>
                    <ul class="submenu">
                        <li><a href="<?= $_ENV['BASE_URL']; ?>/users">Users</a></li>
                        <li><a href="<?= $_ENV['BASE_URL']; ?>/major">Major</a></li>
                    </ul>
                    <?php endif ?>
                    <!-- <a href=""><i class="mdi mdi"></i></a> -->
                </li>

            </ul>
            <!-- End navigation menu -->
        </div> <!-- end #navigation -->
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->