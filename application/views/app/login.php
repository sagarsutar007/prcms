
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | <?= (!empty($app_info['app_name']))?stripslashes($app_info['app_name']):'Project Recruitment CRM'; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css')?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css')?>">
  <!-- Custom style -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css')?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?= base_url(); ?>">
      <?php 
        if (isset($app_info) && !empty($app_info['app_icon']) && file_exists('./assets/img/' . $app_info['app_icon'])) {
          $logo = base_url('assets/img/' . $app_info['app_icon']);
        } else {
          $logo = base_url('assets/img/letter-p.png');
        }
      ?>
      <img src="<?= $logo; ?>" width="80px" height="80px" alt="">
    </a>
    <?php if (isset($app_info) && !empty($app_info['app_name'])) { ?>
      <h5><?= stripslashes($app_info['app_name']); ?></h5>
    <?php } ?>
  </div>
  <?php if($this->session->flashdata('error')){ ?>
    <div class="row">
      <div class="col-12 mt-3 text">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong><?= $this->session->flashdata('error'); ?></strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>
  <?php } ?>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login to see your dashboard</p>

      <form action="<?= base_url('login'); ?>" method="post">
        <div class="input-group">
          <input type="text" name="email" class="form-control" value="<?= get_cookie('email')??strtolower(set_value('email')); ?>" placeholder="Email address">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>          
        </div>
        <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
        <div class="input-group mt-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye" id="passwordToggle"></span>
            </div>
          </div>
        </div>
        <?= form_error('password', '<div class="text-danger">', '</div>'); ?>
        <div class="row mt-3">
          <div class="col">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Remember Me </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col text-right">
            <a href="<?= base_url('account/forgot-password'); ?>">Forgot password?</a>
          </div>
          <!-- /.col -->
          <div class="col-12 mt-3">
            <button type="submit" class="btn btn-light-primary btn-block ">Login</button>
          </div>
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="<?= base_url('candidate-signup'); ?>" class="btn btn-block btn-light">Sign Up as a Candidate
        </a>
        <a href="<?= base_url('client-signup'); ?>" class="btn btn-block btn-light">Sign Up as a Client
        </a>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
<script>
  $(document).ready(function() {

    $('#passwordToggle').on('click', function(){
      var passInput=$("#password");

      if(passInput.attr('type')==='password')
      {
          $(this).removeClass('fa-eye').addClass('fa-eye-slash');
          passInput.attr('type','text');
      }else{
          $(this).removeClass('fa-eye-slash').addClass('fa-eye');
          passInput.attr('type','password');
      }

    });

  });
</script>
</body>
</html>
