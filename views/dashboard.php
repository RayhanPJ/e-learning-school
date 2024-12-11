<?php require('layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require('layouts/header.php'); ?>

<div class="wrapper">
    <div class="container-fluid">
        <!-- Flash Message -->
        <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert <?= $_SESSION['class']; ?>" role="alert">
            <?= $_SESSION['flash']; ?>
            <?php unset($_SESSION['flash']); // Remove flash after displaying ?>
        </div>
        <?php endif; ?>
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
                <?php if (!empty($preparedTests)): ?>
                    <?php foreach ($preparedTests as $test): ?>
                        <div class="card" style="background:#ededed; cursor: <?= $test['clickable'] ? 'pointer' : 'not-allowed'; ?>;" 
                            onclick="<?= $test['clickable'] ? "window.location.href='" . $test['url'] . "'" : ''; ?>">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="badge <?= $test['badgeColor']; ?>"><?= $test['badgeText']; ?></span>
                                        <span class="badge <?= $test['studentBadgeColor']; ?>"><?= $test['studentBadgeText']; ?></span>
                                        <?php if ($test['studentStatus'] === 1): ?>
                                            <p style="text-align:right;">Score: <?= $test['studentScore']; ?></p>
                                            <p style="text-align:right;">Average Score: <?= number_format($test['averageScore'], 2); ?></p>
                                            <p style="text-align:right;">Grade: <?= $test['grade']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div id="no-data">
                        <center>
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
