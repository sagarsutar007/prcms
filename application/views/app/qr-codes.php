<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

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
                <h1 class="m-0">QR Codes</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Qr Codes</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Candidate Login</h3>
                        </div>
                        <div class="card-body p-0">
                            <img src="<?= base_url('assets/admin/img/qrcodes/candidate-login.png'); ?>" class="img-fluid" alt="">
                            <div class="btn-group w-100">
                                <a class="btn btn-outline-success  btn-sm" href="<?= base_url('Qrcodes/generateQrPdf/candidate-login'); ?>"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="col-sm">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Client Login</h3>
                        </div>
                        <div class="card-body p-0">
                            <img src="<?= base_url('assets/admin/img/qrcodes/client-login.png'); ?>" class="img-fluid" alt="">
                            <div class="btn-group w-100">
                                <a class="btn btn-outline-success  btn-sm" href="<?= base_url('Qrcodes/generateQrPdf/client-login'); ?>"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="col-sm">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Business Login</h3>
                        </div>
                        <div class="card-body p-0">
                            <img src="<?= base_url('assets/admin/img/qrcodes/business-login.png'); ?>" class="img-fluid" alt="">
                            <div class="btn-group w-100">
                                <a class="btn btn-outline-success  btn-sm" href="<?= base_url('Qrcodes/generateQrPdf/business-login'); ?>"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="col-sm">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Client Signup</h3>
                        </div>
                        <div class="card-body p-0">
                            <img src="<?= base_url('assets/admin/img/qrcodes/client-signup.png'); ?>" class="img-fluid" alt="">
                            <div class="btn-group w-100">
                                <a class="btn btn-outline-success  btn-sm" href="<?= base_url('Qrcodes/generateQrPdf/client-signup'); ?>"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="col-sm">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Candidate Signup</h3>
                        </div>
                        <div class="card-body p-0">
                            <img src="<?= base_url('assets/admin/img/qrcodes/candidate-signup.png'); ?>" class="img-fluid" alt="">
                            <div class="btn-group w-100">
                                <a class="btn btn-outline-success  btn-sm" href="<?= base_url('Qrcodes/generateQrPdf/candidate-signup'); ?>"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
            <br><br>
            <div class="row">
            <?php
              if (isset($companies)) {
                foreach ($companies as $company => $com) {
            ?>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-12">
                  <h5 class="mb-3"><i class="fas fa-university"></i> <?= $com['company_name']; ?></h5>   
                </div>
                <div class="col-sm">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Client SignUp</h3>
                        </div>
                        <div class="card-body p-0">
                            <img src="<?= base_url('assets/admin/img/qrcodes/client-'.$com['id'].'-signup.png'); ?>" class="img-fluid" alt="">
                            <div class="btn-group w-100">
                                <a class="btn btn-outline-success  btn-sm" href="<?= base_url('Qrcodes/generateQrPdf/client-signup?com_id='.$com['id']); ?>"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">Candidate SignUp</h3>
                      </div>
                      <div class="card-body p-0">
                          <img src="<?= base_url('assets/admin/img/qrcodes/candidate-'.$com['id'].'-signup.png'); ?>" class="img-fluid" alt="">
                          <div class="btn-group w-100">
                              <a class="btn btn-outline-success  btn-sm" href="<?= base_url('Qrcodes/generateQrPdf/candidate-signup?com_id='.$com['id']); ?>"><i class="fas fa-print"></i> Print</a>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
                }
              }
            ?>
            </div>
          </div>
        </section>
      </div>
      <?php $this->load->view('app/includes/footer'); ?>
    </div>
    <!-- Scripts -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
  </body>
</html>
