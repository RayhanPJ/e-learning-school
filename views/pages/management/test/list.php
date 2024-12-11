<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>

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
                                    <th>Test From</th>
                                    <th>Test Name</th>
                                    <th>Subject</th>
                                    <th>Test Date</th>
                                    <th>Test Major</th>
                                    <th>Total Questions</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($tests as $test): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= strtoupper($test['teacher_username']) ?></td>
                                        <td><?= $test['name'] ?></td>
                                        <td><?= $test['subject'] ?></td>
                                        <td><?= $test['date'] ?></td>
                                        <td><?= $test['major_name'] ?></td>
                                        <td><?= $test['total_questions'] ?></td>
                                        <td><?= $test['status_name'] ?></td> <!-- Assuming status_name is fetched -->
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <a class="btn btn-sm btn-primary w-100" style="margin-right: 12px;" href="<?= $_ENV['BASE_URL']; ?>/tests-edit/<?= $test['id'] ?>">Edit</a>
                                                <a class="btn btn-sm btn-danger w-100" href="<?= $_ENV['BASE_URL']; ?>/tests/delete/<?= $test['id'] ?>">Delete</a>
                                            </div>
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
<?php require(__DIR__ . '/../../../layouts/footer.php'); ?>
<!-- End Footer -->

<!-- Scripts -->
<?php require(__DIR__ . '/../../../layouts/script.php'); ?>
