<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>

<?php
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">Add Class</h2>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/class-store">
                            <div class="form-group">
                                <label>Class name</label>
                                <input type="text" class="form-control" id="class_name" 
                                    name="name" placeholder="Class name" />
                                <span id="class_name_error" class="error text-danger">
                                    <?= $_SESSION['errors']['name'] ?? '' ?>
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
