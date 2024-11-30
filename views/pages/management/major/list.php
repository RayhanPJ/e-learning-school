<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>


<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">List Major</h2>

                         <!-- Flash Message -->
                         <?php if (isset($_SESSION['flash'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['flash']; ?>
                                <?php unset($_SESSION['flash']); // Hapus flash setelah ditampilkan ?>
                            </div>
                        <?php endif; ?>
                        <a class="btn btn-sm btn-success mb-3" href="<?= $_ENV['BASE_URL']; ?>/major-create">Add New Soal</a>
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Major</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($major as $item): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['price'] ?></td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <a class="btn btn-sm btn-primary w-100" style="margin-right: 12px;" href="<?= $_ENV['BASE_URL']; ?>/major-edit/<?= $item['id'] ?>">Edit</a>
                                                <a class="btn btn-sm btn-danger w-100" href="<?= $_ENV['BASE_URL']; ?>/major/delete/<?= $item['id'] ?>">Delete</a>
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
