<?php require(__DIR__ . '/../../layouts/meta.php'); ?>
<div class="accountbg"></div>
<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <h3 class="text-center mt-0 m-b-15">
                <a href="index.html" class="logo logo-admin"><img src="../public/assets/template/images/logo.png" height="24" alt="logo"></a>
            </h3>

            <div class="p-3">
                <form class="form-horizontal m-t-20" action="<?= $_ENV['BASE_URL']; ?>/login" method="post">

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" name="username" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" name="password" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-sm-5 m-t-20">
                            <a href="<?= $_ENV['BASE_URL']; ?>/register" class="text-muted"><i class="mdi mdi-account-circle"></i> <small>Create an account ?</small></a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php require(__DIR__ .'../../layouts/script.php'); ?>