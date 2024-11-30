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

                        <h2 class="mt-0 header-title">Add Major</h2>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/major-store">
                            <div class="form-group">
                                <label>Major name</label>
                                <input type="text" class="form-control" id="major_name" 
                                    name="name" placeholder="Major name" />
                                <span id="major_name_error" class="error text-danger">
                                    <?= $_SESSION['errors']['name'] ?? '' ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label>Major Price</label>
                                <input type="text" class="form-control" id="major_price" 
                                    name="price" placeholder="Major price" />
                                <span id="major_price_error" class="error text-danger">
                                    <?= $_SESSION['errors']['price'] ?? '' ?>
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
