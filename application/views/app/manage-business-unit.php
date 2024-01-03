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
                  <li class="breadcrumb-item"><a href="<?= base_url('business-units'); ?>">Business Units</a></li>
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
              <?php if (isset($company) && !empty($company['company_logo'])) { ?>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <img src="<?= base_url('assets/img/companies/'.$company['company_logo']); ?>" class="img-fluid" alt="">
                  </div>
                  <div class="card-footer">
                    <a href="<?= base_url('BusinessUnits/removeCompanyImage/'.$company['id']); ?>" class="btn btn-default btn-block"><i class="fas fa-trash"></i> Remove Company Image</a>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="col-md-8 mx-auto">
                <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                  <input type="hidden" name="type" value="business unit">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><?= $title; ?></h3>
                    </div>
                    <div class="card-body" id="classes-form">
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="bun">Business Unit Name<sup>*</sup></label>
                            <input type="text" id="bun" class="form-control" name="company_name" value="<?= $company['company_name']??set_value('company_name'); ?>" placeholder="">
                            <?= form_error('company_name', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="business-unit-logo">Business Unit Logo</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="company_logo_file" class="custom-file-input" id="business-unit-logo">
                                <label class="custom-file-label" for="business-unit-logo">Choose file</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="com_abt">Business Address</label>
                            <textarea id="com_abt" class="form-control" name="company_address" placeholder="Enter Company Address"><?= $company['company_address']??set_value('company_address'); ?></textarea>
                            <?= form_error('company_address', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="com_abt">About this business</label>
                            <textarea id="com_abt" class="form-control" name="company_about" placeholder="Enter something about this company"><?= $company['company_about']??set_value('company_about'); ?></textarea>
                            <?= form_error('company_about', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                      </div>
                      
                      <?php if (!isset($company)) { ?>
                      <div class="form-group">
                        <input type="checkbox" name="create_user" value="1" id="create-user" <?= isset($assoc_users)?'':'checked'; ?>> 
                        <label for="create-user" class="fw-4">Create a new user</label>
                      </div>
                      <?php } ?>

                      <div class="row">
                        <div class="col-md-12" id="existing-user" style="display: <?= isset($assoc_users)?'block':'none'; ?>;">
                          <div class="form-group">
                            <label for="existing-user">Associate existing user</label>
                            <select class="select2" name="user_ids[]" id="existing-users" style="width:100%;" multiple>
                              <?php 
                                if (isset($users)) {
                                  foreach ($users as $user => $usr) {
                                    if (isset($assoc_users) && in_array($usr['id'], $assoc_users)) {
                              ?>
                              <option value="<?= $usr['id']; ?>" selected>
                                <?= $usr['firstname'] . " " . $usr['middlename']. " " . $usr['lastname']; ?>
                              </option>
                              <?php } else { ?>
                              <option value="<?= $usr['id']; ?>">
                                <?= $usr['firstname'] . " " . $usr['middlename']. " " . $usr['lastname']; ?>
                              </option>
                              <?php
                                    }
                                  }
                                }
                              ?>
                            </select>
                          </div>
                          <div class="text-info">
                            Note:- <a href="<?= base_url('business-units/manager/create'); ?>">Create a new user</a> if you do not find a suitable user.
                          </div>
                        </div>
                        <div class="col-md-12" id="new-user" style="display: <?= isset($assoc_users)?'none':'block'; ?>;">
                          <div class="form-group">
                            <label>Business Unit Head Name</label>
                            <div class="row">
                              <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" name="firstname" value="<?= set_value('firstname'); ?>" placeholder="First name*">
                                <?= form_error('firstname', '<div class="text-danger">', '</div>'); ?>
                              </div>
                              <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" name="middlename" value="<?= set_value('middlename'); ?>" placeholder="Middle name">
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="lastname" value="<?= set_value('lastname'); ?>" placeholder="Last name">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cn">Contact Number</label>
                                <input type="number" id="cn" class="form-control" name="phone" value="<?= set_value('phone'); ?>" placeholder="9337xxxxxx">
                                <?= form_error('phone', '<div class="text-danger">', '</div>'); ?>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="ce">Contact Email</label>
                                <input type="email" id="ce" class="form-control" name="email" value="<?= set_value('email'); ?>" placeholder="example@email.com">
                                <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="contact-person-picture">Contact Person Picture</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" name="profile_img_file" class="custom-file-input" id="contact-person-picture">
                                    <label class="custom-file-label" for="contact-person-picture">Choose file</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="bup">Business Unit Password<sup>*</sup></label>
                                <input type="password" id="bup" class="form-control" name="password" value="" placeholder="Enter password" maxlength="12">
                                <?= form_error('password', '<div class="text-danger">', '</div>'); ?>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Status</label>
                                <div class="d-flex align-items-center">
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="status-active" name="status" value="active" checked>
                                    <label for="status-active" class="custom-control-label fw-4">Active</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-4">
                                    <input class="custom-control-input" type="radio" id="status-blocked" name="status" value="blocked">
                                    <label for="status-blocked" class="custom-control-label fw-4">Blocked</label>
                                  </div>
                                </div>
                              </div>
                            </div>
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
