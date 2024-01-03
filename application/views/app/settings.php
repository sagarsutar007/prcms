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
              <div class="col-md-8 mx-auto">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Manage Settings</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <?php if ($this->session->userdata('type') == 'admin') { ?>
                        <div class="col-12">
                        <a href="<?= base_url('settings/site'); ?>">
                          <div class="settting-links">
                            <div>Application Settings</div>
                            <i class="fas fa-arrow-circle-right"></i>
                          </div>
                        </a>
                      </div>
                      <div class="col-12">
                        <a href="<?= base_url('settings/sms-templates'); ?>">
                          <div class="settting-links">
                            <div>SMS Template Setting</div>
                            <i class="fas fa-arrow-circle-right"></i>
                          </div>
                        </a>
                      </div>
                      <div class="col-12">
                        <a href="<?= base_url('settings/email-templates'); ?>">
                          <div class="settting-links">
                            <div>Mail Template Setting</div>
                            <i class="fas fa-arrow-circle-right"></i>
                          </div>
                        </a>
                      </div>
                      <?php } else if ($this->session->userdata('type') == 'client') { ?>
                      <div class="col-12">
                        <a href="<?= base_url('settings/company'); ?>">
                          <div class="settting-links">
                            <div>Company Settings</div>
                            <i class="fas fa-arrow-circle-right"></i>
                          </div>
                        </a>
                      </div>
                      <?php } else if ($this->session->userdata('type') == 'business unit') { ?>
                        <div class="col-12">
                          <a href="<?= base_url('settings/companies'); ?>">
                            <div class="settting-links">
                              <div>Companies Settings</div>
                              <i class="fas fa-arrow-circle-right"></i>
                            </div>
                          </a>
                        </div>
                      <?php } ?>
                      <div class="col-12">
                        <a href="<?= base_url('settings/profile'); ?>">
                          <div class="settting-links">
                            Profile Settings
                            <i class="fas fa-arrow-circle-right"></i>
                          </div>
                        </a>
                      </div>
                      <div class="col-12">
                        <a href="<?= base_url('settings/change-password'); ?>">
                          <div class="settting-links">
                            Change Password
                            <i class="fas fa-arrow-circle-right"></i>
                          </div>
                        </a>
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
          $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
          });

          $('.select2').select2();
      });
    </script>
  </body>
</html>
