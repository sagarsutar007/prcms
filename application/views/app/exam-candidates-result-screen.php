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
      .fs-50 {
        font-size: 50px;
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
                  <li class="breadcrumb-item"><a href="<?= base_url('exams'); ?>">Exams</a></li>
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
              <div class="col-md-12">
                <div class="card mt-3">
                  <div class="card-header">
                    <div class="card-tools">
                      <a target="_blank" href="<?= base_url('exams/download-exam-candidate/'.$exam_id); ?>" class="btn btn-primary btn-sm "><i class="fas fa-file-pdf"></i> Download PDF</a>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <table class="table table-striped projects">
                      <thead>
                          <tr>
                            <th style="width: 1%">#</th>
                            <th style="width: 20%">Candidate Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>
                            </th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; if (isset($results)) { foreach ($results as $records => $record) { ?>
                          <tr>
                            <td>
                              <?= $i; ?>
                            </td>
                            <td><?= ucwords($record['firstname'] . " " . $record['middlename'] . " " . $record['lastname']); ?></td>
                            <td><?= $record['phone']; ?></td>
                            <td><?= $record['email']; ?></td>
                            <td><?= $record['gender']?ucfirst($record['gender']):'Not Available'; ?></td>
                            <td><?= $record['ans_stats']??''; ?></td>
                            <td class="text-center">
                              <?php if (!$record['attended']) { ?>
                                <button class="btn btn-primary btn-sm " disabled><i class="fas fa-folder"></i> View Result</button>
                              <?php } else { ?>
                                <a href="<?= base_url('candidate/view-exam-result?examid='.$exam_id.'&userid='.$record['id']); ?>" class="btn btn-primary btn-sm "><i class="fas fa-folder"></i> View Result</a>
                              <?php } ?>
                            </td>
                          </tr>
                        <?php $i++; } } ?>
                      </tbody>
                    </table>
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
