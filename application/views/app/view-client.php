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
                  <li class="breadcrumb-item"><a href="<?= base_url('clients'); ?>">Clients</a></li>
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
                  <div class="card-body box-profile">
                    <div class="row">
                      <div class="col-md-2">
                        <?php if (!empty($client['company_logo']) && file_exists('./assets/img/companies/'.$client['company_logo'])) { ?>
                        <div class="box-profile">
                          <img class="profile-user-img img-circle" height="100px" src="<?= base_url('./assets/img/companies/'.$client['company_logo']); ?>" alt="">
                        </div>
                        <?php } ?>
                      </div>
                      <div class="col-md-10">
                        <h3 class="profile-username"><strong><?= $client['company_name']; ?></strong></h3>
                        <p class="text-muted text-sm text-justify"><?= $client['company_about']; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header p-0 px-3" id="sub-section">
                    <ul class="nav nav-pills">
                      <li class="nav-item">
                        <a class="nav-link active" href="#profile" data-toggle="tab">Profile</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#exams" data-toggle="tab">Exams</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="card">
                  <div class="card-body p-0">
                    <div class="tab-content">
                      <div class="active tab-pane p-3" id="profile">
                        <div class="row">
                          <div class="col-md-1">
                            <?php if (!empty($client['profile_img']) && file_exists('./assets/img/'.$client['profile_img'])) { ?>
                              <img class="img-circle" width="50px" height="50px" src="<?= base_url('./assets/img/'.$client['profile_img']); ?>" alt="">                        
                            <?php } ?>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <div class="text-secondary text-sm">Name</div>
                              <h5><?= $client['firstname'] . " " . $client['middlename'] . " " . $client['lastname']; ?></h5>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <div class="text-secondary text-sm">Gender</div>
                              <h5><?= $client['gender']?ucfirst($client['gender']):'Not Available'; ?></h5>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <div class="text-secondary text-sm">Phone</div>
                              <h5><?= $client['phone']??'Not Available'; ?></h5>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <div class="text-secondary text-sm">Email</div>
                              <h5><?= $client['email']??'Not Available'; ?></h5>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="exams">
                        <table class="table table-striped projects">
                          <thead>
                              <tr>
                                  <th style="width: 1%">
                                      Sl.
                                  </th>
                                  <th style="width: 20%">
                                      Exam Name
                                  </th>
                                  <th>
                                      Conducted By
                                  </th>
                                  <th>
                                      Total Questions
                                  </th>
                                  <th>
                                      Total Candidates
                                  </th>
                                  <th>
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php $i = 1; foreach ($exams as $exam => $exm) { ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $exm['name']; ?></td>
                              <td><?= $exm['company_name']; ?></td>
                              <td><?= $exm['total_question']; ?></td>
                              <td><?= $exm['total_candidates']; ?></td>
                              <td>
                                <a class="btn btn-primary btn-sm" href="<?= base_url('exams/'.$exm['id'].'/view-detailed-result'); ?>"><i class="fas fa-folder"></i> View Result</a>
                              </td>
                            </tr>
                            <?php $i++; } ?>
                          </tbody>
                        </table>
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
