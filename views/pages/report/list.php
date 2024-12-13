<?php 
// var_dump($preparedTests);die;
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
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">List of Tests</h2>

                        <!-- Flash Message -->
                        <?php if (isset($_SESSION['flash'])): ?>
                            <div class="alert <?= $_SESSION['class']; ?>" role="alert">
                                <?= $_SESSION['flash']; ?>
                                <?php unset($_SESSION['flash']); // Remove flash after displaying ?>
                            </div>
                        <?php endif; ?>

                        <a class="btn btn-sm btn-success mb-3" href="<?= $_ENV['BASE_URL']; ?>/tests-create">Add New Test</a>
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Student Name</th>
                                    <th>Test From</th>
                                    <th>Test Name</th>
                                    <th>Subject</th>
                                    <th>Test Date</th>
                                    <th>Test Major</th>
                                    <th>Total Questions</th>
                                    <th>Status</th>
                                    <th>Student Score</th>
                                    <th>Average Score</th>
                                    <th>Grade</th>
                                    <th>Pass/Fail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($preparedTests as $test): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= strtoupper($test['studentName']) ?></td>
                                        <td><?= strtoupper($test['teacher_username']) ?></td>
                                        <td><?= $test['name'] ?></td>
                                        <td><?= $test['subject'] ?></td>
                                        <td><?= $test['date'] ?></td>
                                        <td><?= $test['major_name'] ?></td>
                                        <td><?= $test['total_questions'] ?></td>
                                        <td><?= $test['status_name'] ?></td>
                                        <td><?= $test['studentScore'] !== null ? $test['studentScore'] . '/' . $test['totalScore'] : 'N/A /' . $test['totalScore'] ?></td>
                                        <td><?= $test['averageScore'] !== null ? number_format($test['averageScore']) : 'N/A' ?></td>
                                        <td><?= $test['grade'] !== null ? $test['grade'] : 'N/A' ?></td>
                                        <td>
                                            <span class="badge <?= $test['grade'] === 'A' || $test['grade'] === 'B' ? 'badge-success' : 'badge-danger'; ?>">
                                                <?= $test['grade'] === 'A' || $test['grade'] === 'B' ? 'PASS' : 'FAIL'; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
