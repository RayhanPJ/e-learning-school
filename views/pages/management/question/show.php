<?php require(__DIR__ . '/../../../layouts/meta.php'); ?>
<!-- Navigation Bar-->
<?php require(__DIR__ . '/../../../layouts/header.php'); ?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h2 class="mt-0 header-title">Questions for Test ID: <?= htmlspecialchars($test_id) ?></h2>

                        <form method="POST" action="<?= $_ENV['BASE_URL']; ?>/submit-answers">
                            <?php foreach ($questions as $index => $question): ?>
                                <div id="content">
                                    <div class="modal-header">
                                        <h5>
                                            <span class="label label-warning" id="qid"><?= $index + 1 ?></span>
                                            <span id="question"><?= htmlspecialchars($question['title']) ?></span>
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="quiz" id="quiz" data-toggle="buttons">
                                            <label id="optionA" class="element-animation1 btn btn-lg btn-primary btn-block">
                                                <span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                                <input type="radio" name="q_answer[<?= $question['id'] ?>]" value="1" required>
                                                <?= htmlspecialchars($question['optionA']) ?>
                                            </label>
                                            <label id="optionB" class="element-animation2 btn btn-lg btn-primary btn-block">
                                                <span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                                <input type="radio" name="q_answer[<?= $question['id'] ?>]" value="2" required>
                                                <?= htmlspecialchars($question['optionB']) ?>
                                            </label>
                                            <label id="optionC" class="element-animation3 btn btn-lg btn-primary btn-block">
                                                <span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                                <input type="radio" name="q_answer[<?= $question['id'] ?>]" value="3" required>
                                                <?= htmlspecialchars($question['optionC']) ?>
                                            </label>
                                            <label id="optionD" class="element-animation4 btn btn-lg btn-primary btn-block">
                                                <span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                                <input type="radio" name="q_answer[<?= $question['id'] ?>]" value="4" required>
                                                <?= htmlspecialchars($question['optionD']) ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <button type="submit" class="btn btn-success mt-3">Submit Answers</button>
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
