<?php require(__DIR__ . '/../../layouts/meta.php'); ?>
<div class="accountbg"></div>
<div class="wrapper-page">
    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash'])): ?>
    <div class="alert <?= $_SESSION['class']; ?>" role="alert">
        <?= $_SESSION['flash']; ?>
        <?php unset($_SESSION['flash']); // Hapus flash setelah ditampilkan ?>
    </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">

            <div class="logo">
                <h3 class="text-center mt-0 m-b-15">
                    <a href="" class="logo ">
                        <span class="text-dark">SEKOLAH HEBAT</span>
                    </a>
                </h3>
            </div>

            <div class="p-3">
                <form class="form-horizontal m-t-20" action="<?= $_ENV['BASE_URL']; ?>/login" method="post">

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" name="username" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" name="password" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php require(__DIR__ .'/../../layouts/script.php'); ?>