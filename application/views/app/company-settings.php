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
              <div class="col-md-8 mx-auto">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Manage Company Settings</h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="bun">Company Name<sup>*</sup></label>
                            <input type="text" id="bun" class="form-control" name="company_name" value="<?= stripslashes($record['company_name']??set_value('company_name')); ?>">
                            <?= form_error('company_name', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="business-unit-logo">Company Logo Icon</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="company_logo" class="custom-file-input" id="application-logo">
                                <label class="custom-file-label" for="application-logo">Choose file</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <textarea name="company_about" class="form-control"><?= stripslashes($record['company_about']??set_value('company_about')); ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 text-right">
                          <button type="submit" class="btn btn-primary ">SAVE</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
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
    <script>
      $(document).ready(function() {

      });
    </script>
  </body>
</html>
