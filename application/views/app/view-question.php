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
      #sub-section .nav-pills .nav-link {
        border-radius: 0px;
      }
      #sub-section .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #007bff;
        background-color: transparent;
        border-bottom: 3px solid #007bff;
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
                  <li class="breadcrumb-item"><a href="<?= base_url('question-bank'); ?>">Question Bank</a></li>
                  <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-10 mx-auto">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <?php if (!empty($question['question_img']) && file_exists('./assets/img/'.$question['question_img'])) { ?>
                      <div class="col-md-4">
                        <img src="<?= base_url('assets/img/'.$question['question_img']); ?>" class="img-fluid img-responsive" alt="">
                      </div>
                      <?php } ?>
                      <div class="col-md">
                        <?php 
                          $que = "";
                          if (strlen($question['question_en']) > 2) {
                            $que .= "Q. " . $question['question_en'];
                          }

                          if (strlen($question['question_hi']) > 2) {
                            $que .= "<div class='mb-2'></div> स. " . $question['question_hi'];
                          }
                        ?>
                        <h3><strong><?= $que; ?></strong></h3>
                        <br>
                        <?php 
                          if ($question['question_type'] != 'text') {
                            $i = 1;
                            foreach ($answers as $answers => $ans) {
                        ?>
                        <div class="form-group m-0 p-0 d-flex align-items-top">
                          <div>
                            <?= $i; ?>. &nbsp;
                          </div>
                          <label style="font-weight: 400;">
                            <?php 
                              if (strlen($ans['answer_text_en']) > 0) {
                                echo $ans['answer_text_en'];
                              }

                              if (strlen($ans['answer_text_hi']) > 0) {
                                echo "<br>" . $ans['answer_text_hi'];
                                $fs = "30px";
                              }
                            ?>
                          </label>
                          <?php if ($ans['isCorrect'] == 1) { ?>
                            <i class="fas fa-check text-success ml-3" style="font-size: <?= $fs??'20px'; ?>; padding-top: 5px;"></i>
                          <?php } ?>
                        </div>
                        <?php $i++; } } else { ?>
                        <div class="form-group m-0 p-0">
                          <textarea name="answerId" id="<?= 'ans-'.$ans['id']; ?>" cols="30" rows="10"></textarea>
                        </div>
                        <?php } ?>
                      </div>
                    </div>    
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
