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
      .modal-header {
          padding: 0.7rem 1rem;
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
                  <li class="breadcrumb-item"><a href="<?= base_url('candidates'); ?>">Candidates</a></li>
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
                  <strong>Error! </strong><?= strip_tags($this->session->flashdata('error')); ?>
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
              <div class="col-md-6 mx-auto">
                <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                  <input type="hidden" name="type" value="business unit">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><?= $title; ?></h3>
                    </div>
                    <div class="card-body" id="classes-form">
                      
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="upload-excel">Upload Excel</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="excel_file" class="custom-file-input" id="upload-excel">
                                <label class="custom-file-label" for="upload-excel">Choose file</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 text-center">
                          <a href="<?= base_url('assets/admin/formats/joining-form.xlsx'); ?>" class="btn btn-outline-info "><i class="fas fa-download"></i> Download Format </a>
                          <button type="submit" class="btn btn-primary "><i class="fas fa-check"></i> Submit</button>
                          <?php if (count($error)) { ?>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-errors"><i class="fas fa-bug"></i> Show Errors</button>
                          <?php } ?>
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

    <div class="modal fade" id="modal-errors">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h6 class="modal-title text-white">Check Errors</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="errors-section">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Row No</th>
                  <th>Error Message</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if (count($error)) {
                      foreach ($error as $key => $err) {
                        echo "<tr><td>Row:<b> ". $err['row'] . "</b></td><td class='text-danger'>".strip_tags($err['message'])."</td></tr>";
                      }
                  }
                ?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer text-end">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
          $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
          });
          <?php if (count($error)) { ?> $("#modal-errors").modal('show'); <?php } ?>
      });
    </script>
  </body>
</html>
