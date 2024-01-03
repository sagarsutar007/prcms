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
                <?php if($this->session->userdata('type') != 'candidate') { ?>
                <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                <?php } ?>
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><?= $title; ?></h3>
                    </div>
                    <div class="card-body">                      
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>User's Name</label>
                            <div class="row">
                              <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" name="firstname" value="<?= $record['firstname']??set_value('firstname'); ?>" placeholder="First name*">
                                <?= form_error('firstname', '<div class="text-danger">', '</div>'); ?>
                              </div>
                              <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" name="middlename" value="<?= $record['middlename']??set_value('middlename'); ?>" placeholder="Middle name">
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="lastname" value="<?= $record['lastname']??set_value('lastname'); ?>" placeholder="Last name">
                                <?= form_error('lastname', '<div class="text-danger">', '</div>'); ?>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cn">Contact Number</label>
                                <input type="number" id="cn" class="form-control" name="phone" value="<?= $record['phone']??set_value('phone'); ?>" placeholder="9337xxxxxx">
                                <?= form_error('phone', '<div class="text-danger">', '</div>'); ?>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="ce">Contact Email</label>
                                <input type="email" id="ce" class="form-control" name="email" value="<?= $record['email']??set_value('email'); ?>" placeholder="example@email.com">
                                <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="contact-person-picture">Profile Picture</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" name="profile_img_file" class="custom-file-input" id="contact-person-picture">
                                    <label class="custom-file-label" for="contact-person-picture">Choose file</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-3"><strong>Gender</strong></div>
                              <div class="form-group">
                                <input type="radio" name="gender" value="male" <?= (isset($record) && $record['gender'] == 'male')?'checked':''; ?>>
                                <label for="gender-m" class="mr-3">Male</label>

                                <input type="radio" name="gender" value="female" <?= (isset($record) && $record['gender'] == 'female')?'checked':''; ?>>
                                <label for="gender-f" class="mr-3">Female</label>

                                <input type="radio" name="gender" value="other" <?= (isset($record) && $record['gender'] == 'other')?'checked':''; ?>>
                                <label for="gender-o">Others</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer clearfix">
                      <div class="float-right">
                        <?php if($this->session->userdata('type') != 'candidate') { ?>
                        <button type="submit" class="btn btn-primary "><i class="fas fa-check"></i> SUBMIT</button>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <?php if($this->session->userdata('type') != 'candidate') { ?>
                </form>
                <?php } ?>
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
