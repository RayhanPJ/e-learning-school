<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>

<?php
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
if (isset($_SESSION['old'])) {
    unset($_SESSION['old']);
}
?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">Add Teachers</h2>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/users-store">
                            <div class="form-group">
                                <label>Username :</label>
                                <input type="text" class="form-control" name="username" required placeholder="Input Username"/>
                                <span id="teacher_username_error" class="error text-danger">
                                    <?= $_SESSION['errors']['username'] ?? '' ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label>Password :</label>
                                <input type="password" class="form-control" name="password" required placeholder="Input Username"/>
                                <span id="teacher_password_error" class="error text-danger">
                                    <?= $_SESSION['errors']['password'] ?? '' ?>
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary ml-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

<!-- Footer -->
<?php require(__DIR__ . '/../../../layouts/footer.php'); ?>
<!-- End Footer -->

<!-- Scripts -->
<?php require(__DIR__ . '/../../../layouts/script.php'); ?>
