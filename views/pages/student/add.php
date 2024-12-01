<?php 
require(__DIR__ . '/../../layouts/meta.php'); ?>
<?php require(__DIR__ . '/../../layouts/header.php');?>
<?php
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">Please register your account here!</h2>
                        <!-- Flash Message -->
                        <?php if (isset($_SESSION['flash'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['flash']; ?>
                                <?php unset($_SESSION['flash']); // Hapus flash setelah ditampilkan ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/registers-store">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name" 
                                    name="name" placeholder="Enter your name" value="<?= $errors['name'] ?? '' ?>" />
                                <span id="name_error" class="error text-danger">
                                    <?= $errors['name'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" 
                                    name="date_of_birth" value="<?= $errors['date_of_birth'] ?? '' ?>" />
                                <span id="date_of_birth_error" class="error text-danger">
                                    <?= $errors['date_of_birth'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" id="phone" 
                                    name="phone" placeholder="Enter your phone number" value="<?= $errors['phone'] ?? '' ?>" />
                                <span id="phone_error" class="error text-danger">
                                    <?= $errors['phone'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Major</label>
                                <select class="form-control" id="major_id" name="major_id">
                                    <option value="">Select Major</option>
                                    <?php foreach ($majors as $major): ?>
                                        <option value="<?= $major['id'] ?>" <?= (isset($errors['major_id']) && $errors['major_id'] == $major['id']) ? 'selected' : '' ?>>
                                            <?= $major['name'] . ' - Rp.' . number_format($major['price']) ?> 
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="major_id_error" class="error text-danger">
                                    <?= $errors['major_id'] ?? '' ?>
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
<?php require(__DIR__ . '/../../layouts/footer.php'); ?>
<!-- End Footer -->
<?php require(__DIR__ .'/../../layouts/script.php'); ?>
