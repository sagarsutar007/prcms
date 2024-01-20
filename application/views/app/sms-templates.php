<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/summernote/summernote-bs4.min.css'); ?>">

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
                <h1 class="m-0"><?= $title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('Settings'); ?>">Settings</a></li>
                  <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 mx-auto">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">SMS Template Settings</h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="scheduled_exam">Scheduled Exam SMS Template</label>
                                <br>
                                <input type="text" class="form-control" name="schexm_tempid" value="<?= $site_data['schexm_tempid']; ?>" placeholder="Template ID"> <br>
                                <textarea name="scheduled_exam" id="scheduled_exam" class="form-control"><?= $site_data['scheduled_exam']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              <div class="d-flex align-items-center justify-content-between">
                                <label for="new_registered">New Registered User SMS</label>
                                <div class="form-group mb-0">
                                  <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="on" name="new_user_sms_notif" value="on" class="custom-control-input" <?= $site_data['new_user_sms_notif']=='on'?'checked':''; ?>>
                                    <label class="custom-control-label" for="on">On</label>
                                  </div>
                                  <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="off" name="new_user_sms_notif" value="off" class="custom-control-input" <?= $site_data['new_user_sms_notif']=='off'?'checked':''; ?>>
                                    <label class="custom-control-label" for="off">Off</label>
                                  </div>
                                </div>
                              </div>
                              <br>
                                <input type="text" class="form-control" name="newusr_tempid" value="<?= $site_data['newusr_tempid']; ?>" placeholder="Template ID"> 
                              <br>
                              <textarea name="new_registered" id="new_registered" class="form-control"><?= $site_data['new_registered']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="candidate_login">Candidate User Login SMS</label>
                                <br>
                                  <input type="text" class="form-control" name="cdtlog_tempid" value="<?= $site_data['cdtlog_tempid']; ?>" placeholder="Template ID"> 
                                <br>
                                <textarea name="candidate_login" id="candidate_login" class="form-control"><?= $site_data['candidate_login']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fp_sms">Forget Password SMS</label>
                                <br>
                                  <input type="text" class="form-control" name="fp_sms_tempid" value="<?= $site_data['fp_sms_tempid']; ?>" placeholder="Template ID"> 
                                <br>
                                <textarea name="fp_sms" id="fp_sms" class="form-control"><?= $site_data['fp_sms']; ?></textarea>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                            <div class="form-group">
                              <label for="otp">OTP Template ID</label>
                              <input type="text" name="otp_tempid" class="form-control" id="otp" value="<?= $site_data['otp_tempid']; ?>" placeholder="Template ID">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 text-right">
                          <button type="submit" class="btn btn-primary px-3 btn-sm">SAVE</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Dynamic Fields</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-dark">
                                <strong>${name}</strong> :- User's fullname <br>
                                <strong>${firstname}</strong> :- User's firstname <br>
                                <strong>${middlename}</strong> :- User's middlename <br>
                                <strong>${lastname}</strong> :- User's lastname <br>
                                <strong>${exam_date}</strong> :- Exam Date 20-06-2023 <br>
                                <strong>${exam_time}</strong> :- Exam Time 02:45pm <br>
                                <strong>${exam_datetime}</strong> :- Exam Date & Time 20-06-2023 02:45pm <br>
                                <strong>${company_name}</strong> :- Company Name<br>
                                <strong>${business_name}</strong> :- Business Unit Name<br>
                                <strong>${business_addr}</strong> :- Business Unit Address<br>
                                <strong>${login_url}</strong> :- Candidate login link<br>
                                <strong>${exam_login_url}</strong> :- Exam login link<br>
                                <strong>${reset_password_url}</strong> :- Reset Account Password Link
                            </p>
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

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <!-- Summernote -->
    <script src="<?= base_url('assets/admin/plugins/summernote/summernote-bs4.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
        // const config = {
        //         toolbar: [
        //             ['style', ['bold', 'underline']],
        //         ]
        //     }
        // $('#scheduled_exam').summernote(config);
        // $('#new_registered').summernote(config);
      });
    </script>
  </body>
</html>
