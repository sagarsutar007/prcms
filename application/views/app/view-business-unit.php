<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Business Unit</title>

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
                <h1 class="m-0">View Business Unit</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('business-units'); ?>">Business Units</a></li>
                  <li class="breadcrumb-item active">View Business Unit</li>
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
                    <div class="card-body" id="classes-form">
                      <div class="d-flex align-items-top justify-content-start">
                      <?php if ( !empty($company['company_logo']) && file_exists('./assets/img/companies/'.$company['company_logo']) ) { ?>
                      <div class="text-center">
                        <img src="<?= base_url('./assets/img/companies/'.$company['company_logo']); ?>" height="100px" alt="">
                      </div>
                      <?php } ?> 
                      <div class="ml-3">
                        <h3><?= $company['company_name']; ?></h3>
                        <p class="text-secondary text-sm p-0 m-0">
                          Created On:- <?= date('d M Y', strtotime($company['created_at'])); ?>
                        </p>
                      </div>
                      </div>
                      <hr>
                      <h5 class="mb-3">Associated Users</h5>
                      <table width="100%" class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Manager Info</th>
                            <th>Phone</th>
                            <th>Email</th>
                          </tr>
                        </thead>
                        <?php foreach ($users as $key => $obj) { ?>
                        <tr>
                          <td>
                            <?php if ( !empty($obj['profile_img']) && file_exists('./assets/img/'.$obj['profile_img']) ) { ?>
                              <img src="<?= base_url('./assets/img/'.$obj['profile_img']); ?>" height="40px" alt="">
                            <?php } else { ?>
                              <img src="<?= base_url('./assets/img/app-icon.png'); ?>" height="40px" alt="">
                            <?php } ?>
                            <?= $obj['firstname'] . " " . $obj['middlename'] . " " . $obj['lastname']; ?>
                          </td>
                          <td>
                            <?= $obj['phone']; ?>
                          </td>
                          <td>
                            <?= $obj['email']; ?>
                          </td>
                        </tr>
                        <?php } ?>
                      </table>          
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
