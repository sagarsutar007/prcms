<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- Select 2 -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2/css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
      .fs-50 {
        font-size: 50px;
      }
    </style>
  </head>
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">

      <?php $this->load->view('app/includes/topnavbar'); ?>
      <?php $this->load->view('app/includes/sidebar'); ?>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"><?= $title; ?></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('exams'); ?>">Exams</a></li>
                  <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content">
          <div class="container-fluid">
            <?php if($this->session->flashdata('error')){ ?>
            <div class="row">
              <div class="col-12 mtb-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong><?= $this->session->flashdata('error'); ?></strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php if($this->session->flashdata('success')){ ?>
            <div class="row">
              <div class="col-12 mtb-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong><?= $this->session->flashdata('success'); ?></strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-12">
                <div class="card mt-3">
                  <div class="card-header">
                    <div class="card-tools">
                      <a target="_blank" href="<?= base_url('candidate/generate-candidate-result?examid='.$_GET['examid'].'&userid='.$_GET['userid']); ?>" class="btn btn-primary btn-sm "><i class="fas fa-file pdf"></i> Download PDF</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <?php 
                      $i= 1; 
                      foreach ($result as $key => $obj) { 
                        if (!empty($obj['question_en']) && !empty($obj['question_hi'])) {
                    ?>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <?= "<h6 class='font-weight-bold mb-3'>".$i.". ".$obj['question_en']."</h6>"; ?>
                        <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
                        <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="60%" alt="">
                        <?php } ?>
                        <?php if ($obj['question_type'] != 'text') { ?>
                          <ol type="A">
                            <?php foreach ($obj['answers'] as $answers => $ans){ ?>
                              <li>
                                <?= $ans['answer_text_en']??'';?>
                              </li>
                            <?php } ?>
                          </ol>
                        <?php } ?>
                        <div> Correct answer: <?= $obj['correct_answer_en']; ?></div>
                        <div> User answer: <?= $obj['correct_user_answer_en']; ?></div>
                        <div> Result:
                          <?php
                            if ($obj['answer_status'] == 2) {
                              echo '<strong class="text-dark">Skipped</strong>';
                            } else if ($obj['answer_status'] == 1) {
                              echo '<strong class="text-success">Correct</strong>';
                            } else if ($obj['answer_status'] == 3) {
                              echo '<strong class="text-danger">Incorrect</strong>';
                            }
                          ?>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <?= "<h6 class='font-weight-bold mb-3'>".$i.".".$obj['question_hi']."</h6>"; ?>
                        <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
                        <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="60%" alt="">
                        <?php } ?>
                        <?php if ($obj['question_type'] != 'text') { ?>
                          <ol type="A">
                            <?php foreach ($obj['answers'] as $answers => $ans){ ?>
                              <li>
                                <?= $ans['answer_text_hi']??'';?>
                              </li>
                            <?php } ?>
                          </ol>
                        <?php } ?>
                        <div> सही जवाब: <?= $obj['correct_answer_hi']; ?></div>
                        <div> प्रयोक्ता उत्तर: <?= $obj['correct_user_answer_hi']; ?></div>
                        <div> परिणाम:
                          <?php
                            if ($obj['answer_status'] == 2) {
                              echo '<strong class="text-dark">छोड़ा</strong>';
                            } else if ($obj['answer_status'] == 1) {
                              echo '<strong class="text-success">सही</strong>';
                            } else if ($obj['answer_status'] == 3) {
                              echo '<strong class="text-danger">ग़लत</strong>';
                            } else {

                            }
                          ?>
                        </div>
                      </div>
                    </div>
                    <?php } else if (!empty($obj['question_en']) && empty($obj['question_hi'])) { ?>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <?= "<h6 class='font-weight-bold mb-3'>".$i.". ".$obj['question_en']."</h6>"; ?>
                        <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
                        <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="60%" alt="">
                        <?php } ?>
                        <?php if ($obj['question_type'] != 'text') { ?>
                          <ol type="A">
                            <?php foreach ($obj['answers'] as $answers => $ans){ ?>
                              <li>
                                <?= $ans['answer_text_en']??'';?>
                              </li>
                            <?php } ?>
                          </ol>
                        <?php } ?>
                        <div> Correct answer: <?= $obj['correct_answer_en']; ?></div>
                        <div> User answer: <?= $obj['correct_user_answer_en']; ?></div>
                        <div> Result:
                          <?php
                            if ($obj['answer_status'] == 2) {
                              echo '<strong class="text-dark">Skipped</strong>';
                            } else if ($obj['answer_status'] == 1) {
                              echo '<strong class="text-success">Correct</strong>';
                            } else if ($obj['answer_status'] == 3) {
                              echo '<strong class="text-danger">Incorrect</strong>';
                            } else {

                            }
                          ?>
                        </div>
                      </div>
                    </div>
                    <?php } else { ?>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <?= "<h6 class='font-weight-bold mb-3'>".$i.". ".$obj['question_hi']."</h6>"; ?>
                        <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
                        <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="60%" alt="">
                        <?php } ?>
                        <?php if ($obj['question_type'] != 'text') { ?>
                          <ol type="A">
                            <?php foreach ($obj['answers'] as $answers => $ans){ ?>
                              <li>
                                <?= $ans['answer_text_hi']??'';?>
                              </li>
                            <?php } ?>
                          </ol>
                        <?php } ?>
                        <div> सही जवाब: <?= $obj['correct_answer_hi']; ?></div>
                        <div> प्रयोक्ता उत्तर: <?= $obj['correct_user_answer_hi']; ?></div>
                        <div> परिणाम:
                          <?php
                            if ($obj['answer_status'] == 2) {
                              echo '<strong class="text-dark">छोड़ा</strong>';
                            } else if ($obj['answer_status'] == 1) {
                              echo '<strong class="text-success">सही</strong>';
                            } else if ($obj['answer_status'] == 3) {
                              echo '<strong class="text-danger">ग़लत</strong>';
                            } else {
                              
                            }
                          ?>
                        </div>
                      </div>
                    </div>  
                    <?php } $i++; } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('app/includes/footer'); ?>
    </div>
    <!-- Scripts -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Select 2 -->
    <script src="<?= base_url('assets/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {

      });
    </script>
  </body>
</html>
