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
                  <li class="breadcrumb-item"><a href="<?= base_url('question-bank'); ?>">Question Bank Units</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('question-bank/categories'); ?>">Categories</a></li>
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
                <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><?= $title; ?></h3>
                    </div>
                    <div class="card-body" id="classes-form">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <label for="category-name">Category Name<sup>*</sup></label>
                            <input type="text" id="category-name" class="form-control" name="category_name" value="<?= $record['category_name']??set_value('category_name'); ?>" placeholder="">
                            <?= form_error('category_name', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="category-desc">Category Description</label>
                            <textarea name="category_desc" class="form-control" id="category-desc" rows="4"><?= $record['category_desc']??set_value('category_desc'); ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer clearfix">
                      <div class="float-right">
                        <button type="submit" class="btn btn-primary "><i class="fas fa-check"></i> SUBMIT</button>
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
    <!-- Select 2 -->
    <script src="<?= base_url('assets/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
          $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
          });

          $('#create-user').on('change', function () {
            $('#new-user').toggle();
            $('#existing-user').toggle();
          });

          $('.select2').select2();
      });
    </script>
  </body>
</html>
