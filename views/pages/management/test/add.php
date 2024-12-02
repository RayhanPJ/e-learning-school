<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>

<?php
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
if (isset($_SESSION['old'])) {
    $old = $_SESSION['old'];
    unset($_SESSION['old']);
}
?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">Add Test</h2>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/tests-store">                            
                            <div class="form-group">
                                <label>Test Name (Title)</label>
                                <input type="text" class="form-control" name="test_name" 
                                    placeholder="Test name" value="<?= $old['test_name'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['test_name'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Subject Name</label>
                                <input type="text" class="form-control" name="subject_name" 
                                    placeholder="Subject name" value="<?= $old['subject_name'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['subject_name'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Test Date</label>
                                <input type="date" class="form-control" name="test_date" 
                                    value="<?= $old['test_date'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['test_date'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Total Questions Count</label>
                                <input type="number" class="form-control" name="total_questions" 
                                    placeholder="Total Questions count" value="<?= $old['total_questions'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['total_questions'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Test Status</label>
                                        <select class="form-control" id="test_status" name="test_status">
                                            <option value="">Select Test Status</option>
                                            <?php foreach ($status as $v): ?>
                                                <option value="<?= $v['id'] ?>" <?= (isset($errors['name']) && $errors['name'] == $v['id']) ? 'selected' : '' ?>>
                                                    <?= $v['name'] ?> 
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="test_status_error" class="error text-danger">
                                            <?= $errors['test_status'] ?? '' ?>
                                        </span>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Major</label>
                                        <select class="form-control" id="major_id" name="major_id">
                                            <option value="">Select Major</option>
                                            <?php foreach ($majors as $major): ?>
                                                <option value="<?= $major['id'] ?>" <?= (isset($errors['major_id']) && $errors['major_id'] == $major['id']) ? 'selected' : '' ?>>
                                                    <?= $major['name'] ?> 
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="major_id_error" class="error text-danger">
                                            <?= $errors['major_id'] ?? '' ?>
                                        </span>
                                    </div>
                                </div>
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