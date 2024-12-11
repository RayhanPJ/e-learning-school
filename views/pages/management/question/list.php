<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">List of Questions</h2>

                        <!-- Flash Message -->
                        <?php if (isset($_SESSION['flash'])): ?>
                            <div class="alert <?= $_SESSION['class']; ?>" role="alert">
                                <?= $_SESSION['flash']; ?>
                                <?php unset($_SESSION['flash']); // Remove flash after displaying ?>
                            </div>
                        <?php endif; ?>

                        <a class="btn btn-sm btn-success mb-3" href="<?= $_ENV['BASE_URL']; ?>/questions-create">Add New Question</a>
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
                                                <a class="btn btn-sm btn-danger w-100" href="<?= $_ENV['BASE_URL']; ?>/questions/delete/<?= $question['id'] ?>">Delete</a>
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
