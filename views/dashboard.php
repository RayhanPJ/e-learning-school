<?php require('layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require('layouts/header.php'); ?>

<div class="wrapper">
    <div class="container-fluid">
        <h1>Dashboard</h1>
        <div class="card" style="min-height:400px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="title">Tests</h5>
                    </div>
                    <div class="col-md-4">
                        <?php if($_SESSION['role'] === 'admin'): ?>
                        <a href="<?= $_ENV['BASE_URL']; ?>/tests-create" class="btn btn-primary" style="margin-top:0px;width:100px !important;float:right !important;">NEW</a>
                        <?php endif ?>
                    </div>
                </div>  
            </div>
            <div class="card-body">
                <?php if (!empty($tests) && count($tests) > 0): ?>
                    <?php foreach ($tests as $test): ?>
                        <div class="card" style="background:#ededed; cursor: pointer;" 
                        onclick="window.location.href='<?= ($_SESSION['role'] === 'student') ? $_ENV['BASE_URL'] . '/questions-show/' . $test['id'] : $_ENV['BASE_URL'] . '/tests-detail/' . $test['id']; ?>'">
                            <div class="card-body">
                                <h6><?= $test["name"]; ?></h6>
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>Subject - <?= $test["subject"]; ?></p>
                                    </div>
                                    <div class="col-md-4"> 
                                        <p style="text-align:right;">Date - <?= $test["date"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div id="no-data">
                        <center>
                            <img src="../assets/img/no-data.svg" height="400" width="400"/>
                            <center><h5>No Data</h5></center>
                        </center>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php require('layouts/footer.php'); ?>
<!-- End Footer -->

<!-- Scripts -->
<?php require('layouts/script.php'); ?>
