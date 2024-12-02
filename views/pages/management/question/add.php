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

                        <h2 class="mt-0 header-title">Add Question</h2>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/questions-store">                            
                            <div class="form-group" hidden>
                                <label>Tests ID</label>
                                <input type="text" class="form-control" name="tests_id" value="<?= $tests_id ?>" />
                            </div>
                            <div class="form-group">
                                <label>Question Title</label>
                                <input type="text" class="form-control" name="title" 
                                    placeholder="Enter question title" value="<?= $old['title'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['title'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Option A</label>
                                <input type="text" class="form-control" name="optionA" 
                                    placeholder="Enter option A" value="<?= $old['optionA'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['optionA'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Option B</label>
                                <input type="text" class="form-control" name="optionB" 
                                    placeholder="Enter option B" value="<?= $old['optionB'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['optionB'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Option C</label>
                                <input type="text" class="form-control" name="optionC" 
                                    placeholder="Enter option C" value="<?= $old['optionC'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['optionC'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Option D</label>
                                <input type="text" class="form-control" name="optionD" 
                                    placeholder="Enter option D" value="<?= $old['optionD'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['optionD'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Correct Answer</label>
                                <input type="text" class="form-control" name="correctAns" 
                                    placeholder="Enter correct answer (A/B/C/D)" value="<?= $old['correctAns'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['correctAns'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Score</label>
                                <input type="number" class="form-control" name="score" 
                                    placeholder="Enter score" value="<?= $old['score'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['score'] ?? '' ?>
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
