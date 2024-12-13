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

                        <h2 class="mt-0 header-title">Edit Test</h2>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/tests-update/<?= $tests['id']; ?>">
                            <div class="form-group">
                                <label>Test Name (Title)</label>
                                <input type="text" class="form-control" name="test_name" 
                                    placeholder="Test name" value="<?= $tests['name'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['test_name'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Subject Name</label>
                                <input type="text" class="form-control" name="subject_name" 
                                    placeholder="Subject name" value="<?= $tests['subject'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['subject_name'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Test Date</label>
                                <input type="date" class="form-control" name="test_date" 
                                    value="<?= $tests['date'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['test_date'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Total Questions Count</label>
                                <input type="number" class="form-control" name="total_questions" 
                                    placeholder="Total Questions count" value="<?= $tests['total_questions'] ?? '' ?>" required />
                                <span class="error text-danger">
                                    <?= $errors['total_questions'] ?? '' ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Test Status</label>
                                        <select class="form-control" id="test_status" name="test_status" required>
                                            <option value="">Select Test Status</option>
                                            <?php foreach ($status as $v): ?>
                                                <option value="<?= $v['id'] ?>" <?= ($tests['status_id'] == $v['id']) ? 'selected' : '' ?>>
                                                    <?= $v['name'] ?> 
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="test_status_error" class="error text-danger">
                                            <?= $errors['test_status'] ?? '' ?>
                                        </span>
                                    </div>

                                    <div class="col-md-6" hidden>
                                        <label>Major</label>
                                        <select class="form-control" id="major_id" name="major_id" required>
                                            <option value="">Select Major</option>
                                            <?php foreach ($majors as $major): ?>
                                                <option value="<?= $major['id'] ?>" <?= ($tests['major_id'] == $major['id']) ? 'selected' : '' ?>>
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

                            <button type="submit" class="btn btn-primary ml-2">Update Test</button>
                        </form>

                        <?php if($page == 'detail'): ?>
                        <!-- Questions Table -->
                        <h3 class="mt-4">Associated Questions</h3>
                            <?php if($isQuestionLimit == false): ?>
                                <a class="btn btn-sm btn-success mb-3" href="<?= $_ENV['BASE_URL']; ?>/questions-create/<?= $tests['id']?>">Add New Question</a>
                            <?php endif; ?>
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Question Title</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
                                    <th>Correct Answer</th>
                                    <th>Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($questions as $question): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $question['title'] ?></td>
                                        <td><?= $question['optionA'] ?></td>
                                        <td><?= $question['optionB'] ?></td>
                                        <td><?= $question['optionC'] ?></td>
                                        <td><?= $question['optionD'] ?></td>
                                        <td><?= $question['correctAns'] ?></td>
                                        <td><?= $question['score'] ?></td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <a class="btn btn-sm btn-primary w-100" style="margin-right: 12px;" href="<?= $_ENV['BASE_URL']; ?>/questions-edit/<?= $question['id'] ?>">Edit</a>
                                                <!-- <a class="btn btn-sm btn-danger w-100" href="<?= $_ENV['BASE_URL']; ?>/questions/delete/<?= $question['id'] ?>/<?= $tests['id']; ?>">Delete</a> -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif ?>
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
