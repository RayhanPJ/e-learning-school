<?php require(__DIR__ . '/../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../layouts/header.php'); ?>
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

                        <h2 class="mt-0 header-title">List of Students</h2>

                        <!-- Flash Message -->
                        <?php if (isset($_SESSION['flash'])): ?>
                            <div class="alert <?= $_SESSION['class']; ?>" role="alert">
                                <?= $_SESSION['flash']; ?>
                                <?php unset($_SESSION['flash']); // Hapus flash setelah ditampilkan ?>
                            </div>
                        <?php endif; ?>
                        <a class="btn btn-sm btn-success mb-3" href="<?= $_ENV['BASE_URL']; ?>/registers-create">Add New Student</a>
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Phone</th>
                                    <th>Major</th>
                                    <th>Price</th>
                                    <th>Status Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($students as $student): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $student['name'] ?></td>
                                        <td><?= $student['date_of_birth'] ?></td>
                                        <td><?= $student['phone'] ?></td>
                                        <td><?= $student['major_name'] ?></td>
                                        <td><?= $student['major_price'] ?></td>
                                        <td class="text-center">
                                            <?php if($student['status_payment'] == 1): ?>
                                                <a href="<?= $_ENV['BASE_URL']; ?>/users-invoice/<?= $student['id']; ?>"><span class="badge badge-success badge-pill px-25">Paid</span></a>
                                            <?php elseif($student['status_payment'] == 0 ): ?>
                                                <span class="badge badge-warning badge-pill px-25">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <?php if($student['status_payment'] == 0): ?>
                                                    <form method="POST" style="margin-right: 12px;" action="<?= $_ENV['BASE_URL']; ?>/invoice-update/<?= $student['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-success w-100">Confirm Payment</button>
                                                    </form>
                                                <?php endif; ?>
                                                <a class="btn btn-sm btn-primary w-100" style="margin-right: 12px;" href="<?= $_ENV['BASE_URL']; ?>/registers-edit/<?= $student['id'] ?>">Edit</a>
                                                <a class="btn btn-sm btn-danger w-100" href="<?= $_ENV['BASE_URL']; ?>/registers/delete/<?= $student['id'] ?>">Delete</a>
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
<?php require(__DIR__ . '/../../layouts/footer.php'); ?>
<!-- End Footer -->

<!-- Scripts -->
<?php require(__DIR__ . '/../../layouts/script.php'); ?>
