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
            <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6 mx-auto">
                <label for="scheduled_exam_mail">Scheduled Exam Template</label>
                <textarea name="scheduled_exam_mail" id="scheduled_exam_mail" class="form-control"><?= (!empty($site_data['scheduled_exam_mail']))?html_entity_decode($site_data['scheduled_exam_mail']):''; ?></textarea>
              </div>
              <div class="col-md-6">
                <h5>Dynamic Fields</h5>
                <div class="card">
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
                        </p>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="d-flex align-items-center justify-content-between">
                    <label for="new_user_mail">New Registered User</label>
                    <div class="form-group mb-0">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="on" name="new_user_mail_notif" value="on" class="custom-control-input" <?= $site_data['new_user_mail_notif']=='on'?'checked':''; ?>>
                        <label class="custom-control-label" for="on">On</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="off" name="new_user_mail_notif" value="off" class="custom-control-input" <?= $site_data['new_user_mail_notif']=='off'?'checked':''; ?>>
                        <label class="custom-control-label" for="off">Off</label>
                      </div>
                    </div>
                  </div>
                  <textarea name="new_user_mail" id="new_user_mail" class="form-control"><?= (!empty($site_data['scheduled_exam_mail']))?html_entity_decode($site_data['new_user_mail']):''; ?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="candidate_login_mail">Candidate User Login</label>
                    <textarea name="candidate_login_mail" id="candidate_login_mail" class="form-control"><?= (!empty($site_data['scheduled_exam_mail']))?html_entity_decode($site_data['candidate_login_mail']):''; ?></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 text-right mb-4">
                <button class="btn btn-primary btn-sm">SAVE</button>
              </div>
            </div>
            </form>
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
        const config = {
            height: 300,
            toolbar: [
                ['style', ['bold', 'underline', 'strikethrough']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['alignment', ['ul', 'ol', 'paragraph', 'left', 'center', 'right', 'justify']],
            ],
            styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            fontSizes: ['8', '10', '12', '14', '18', '24', '36'],
        }
        $('#scheduled_exam_mail').summernote(config);
        $('#new_user_mail').summernote(config);
        $('#candidate_login_mail').summernote(config);
      });
    </script>
  </body>
</html>
