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
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">
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
              <div class="col-sm-12">
                <h1 class="m-0"><?= $exam['name']??$title; ?></h1>
                <ol class="breadcrumb">
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
            <div class="row">
              <div class="col-md-8 mx-auto">
                <div class="card">
                  <div class="card-header p-0 px-3" id="sub-section">
                    <ul class="nav nav-pills">
                      <li class="nav-item">
                        <a class="nav-link active" href="#cecp" data-toggle="tab">Change Password</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#cecs" data-toggle="tab">Candidates Status</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#soe" data-toggle="tab">Stop Ongoing Exam</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#re" data-toggle="tab">Repair Exam Records</a>
                      </li>
                    </ul>
                  </div>
                </div>
                
                <?php if($this->session->flashdata('error')){ ?>
                <div class="row mb-3">
                  <div class="col-12 mtb-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error!</strong> <?= $this->session->flashdata('error'); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
                <?php } ?>

                <?php if($this->session->flashdata('warning')){ ?>
                <div class="row mb-3">
                  <div class="col-12 mtb-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
                <?php } ?>

                <?php if($this->session->flashdata('success')){ ?>
                <div class="row mb-3">
                  <div class="col-12 mtb-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> <?= $this->session->flashdata('success'); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
                <?php } ?>

                <div class="card">
                  <div class="card-body p-0">
                    <div class="tab-content">
                      <div class="active tab-pane p-3" id="cecp">
                        <p class="text-danger text-sm">Note: This will change password of exam candidates!</p>
                        <form action="change-candidates-password" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="password">Enter Common Password: </label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <input type="password" id="password" class="form-control" name="password" value="" placeholder="Enter password" maxlength="12">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password"><i class="fa fa-eye"></i></span>
                                    </div>
                                    <?= form_error('password', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="password">Confirm Common Password: </label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <input type="password" id="password" class="form-control" name="conf_pass" value="" placeholder="Confirm password" maxlength="12">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password"><i class="fa fa-eye"></i></span>
                                    </div>
                                    <?= form_error('conf_pass', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Update Password
                                </button>
                            </div>
                        </div>
                        </form>
                      </div>
                      <div class="tab-pane p-3" id="cecs">
                        <p class="text-danger text-sm">Note: This will impact the exam candidates authentication process.</p>
                        <form action="change-candidate-status" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="text-box">Select <b>'STATUS'</b> : </label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="candidates_status" type="radio" value="1" id="active" <?= ($exam['candidate_status'] == 1)?'checked':''; ?>>
                                    <label class="form-check-label" for="active">Active</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="candidates_status" type="radio" value="0" id="in-active" <?= ($exam['candidate_status'] == 0)?'checked':''; ?>>
                                    <label class="form-check-label" for="in-active">In-active</label>
                                  </div>
                                  <?= form_error('candidates_status', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-ban"></i> Update Status
                                </button>
                            </div>
                        </div>
                        </form>
                      </div>
                      <div class="tab-pane p-3" id="soe">
                        <p class="text-danger text-sm">Note: This will stop the exam and candidates will be automatically redirected to results page!</p>
                        <form action="stop-exam" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="text-box">Enter <b>'STOP'</b> in textbox : </label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <input type="text" id="text-box" class="form-control" name="confirm_stop" value="" placeholder="Enter STOP" maxlength="4">
                                    <?= form_error('confirm_stop', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-ban"></i> Stop Exam
                                </button>
                            </div>
                        </div>
                        </form>
                      </div>
                      <div class="tab-pane p-3" id="re">
                        <p class="text-danger text-sm">Note: This will make changes to exam records if your exam was broken!</p>
                        <h3>This will:-</h3>
                        <p><span id="check1"><i class="fas fa-exclamation-circle"></i></span> <span id="text1">Check if exam was over</span></p>
                        <p><span id="check2"><i class="fas fa-exclamation-circle"></i></span> <span id="text2">Update Exam Candidates Exit Record</span></p>
                        <p><span id="check3"><i class="fas fa-exclamation-circle"></i></span> Complete the exam process</p>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary btn-repair-exam">
                                    <i class="fas fa-tools"></i> Repair Exam Records
                                </button>
                            </div>
                        </div>
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

    <script src="<?= base_url('assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/moment/moment.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/inputmask/jquery.inputmask.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
          $('.toggle-password').click(function () {
            var passwordInput = $(this).closest('.input-group').find('.form-control');
            var icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
              passwordInput.attr('type', 'text');
              icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
              passwordInput.attr('type', 'password');
              icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
          });


          $('.btn-repair-exam').on('click', function() {
              // First Ajax request
              $(this).attr('disabled', true);
              sendAjaxRequest('<?= base_url("exam/".$exam['id']."/start-exam-repair"); ?>')
                  .done(function(response1) {
                      let parsedResponse = JSON.parse(response1);
                      if (parsedResponse.status == "SUCCESS") {
                        $("#check1").html(`<i class="fas fa-check text-success"></i>`);

                        sendAjaxRequest('<?= base_url("exam/".$exam['id']."/repair-exam-candidates"); ?>')
                          .done(function(response2) {
                              let parsedResponse2 = JSON.parse(response2);
                              if (parsedResponse2.status == "SUCCESS") {
                                $("#check2").html(`<i class="fas fa-check text-success"></i>`);
                              } else {
                                $("#check2").html(`<i class="fas fa-exclamation-circle text-warning"></i>`);
                                $("#text2").text(`No records were changed!`);
                              }
                              $("#check3").html(`<i class="fas fa-check text-success"></i>`);
                          })
                          .fail(function(error) {
                              // Handle error in the second request
                              console.error('Error in second request:', error);
                          });

                      } else {
                        $("#check1").html(`<i class="fas fa-exclamation-circle text-danger"></i>`);
                        $("#text1").text('Exam is not over!');
                      }
                      
                  })
                  .fail(function(error) {
                      // Handle error in the first request
                      console.error('Error in first request:', error);
                  });
          });

          function sendAjaxRequest(url) {
              return $.ajax({
                  url: url,
                  method: 'GET',
              });
          }

          $("button[type='submit']").on('click', function() {
            $(this).html(`<i class="fas fa-sync-alt"></i> Processing...`);
          });
          
      });
    </script>
  </body>
</html>
