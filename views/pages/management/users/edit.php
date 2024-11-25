<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">Add User</h2>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/users/store">
                            <div class="form-group">
                                <label>Username :</label>
                                <input type="text" class="form-control" <?= $user['username'] ?> name="username" required placeholder="Input Username"/>
                            </div>
                            <div class="form-group">
                                <label>Password :</label>
                                <input type="password" class="form-control" <?= $user['password'] ?> name="password" required placeholder="Input Username"/>
                            </div>
                            <div class="form-group">
                                <label>Email :</label>
                                <input type="email" class="form-control" <?= $user['email'] ?> name="email" required placeholder="Input Username"/>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" name="role">
                                    <option>--- Select Role ---</option>
                                    <option value="admin">admin</option>
                                    <option value="member">member</option>
                                </select>
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
