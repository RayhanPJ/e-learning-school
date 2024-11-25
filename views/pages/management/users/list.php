<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">User List</h2>
                        <a href="<?= $_ENV['BASE_URL']; ?>/users/create">Add New User</a>
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $user['username'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td><?= $user['role'] ?></td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <a class="btn btn-sm btn-primary w-100" style="margin-right: 12px;" href="<?= $_ENV['BASE_URL']; ?>/users-edit/<?= $user['id'] ?>">Edit</a>
                                                <a class="btn btn-sm btn-danger w-100" href="<?= $_ENV['BASE_URL']; ?>/users/delete/<?= $user['id'] ?>">Delete</a>
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
