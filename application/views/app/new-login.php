
<!DOCTYPE html>
<html lang="zxx">
  <head>
  <!-- Basic Page Needs
  ================================================== -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
	
  <title><?= $title; ?></title>

  <!-- Favicon -->
  <!-- <link rel="shortcut icon" type="image/icon" href="images/favicon-16x16.png"/> -->
   
  <!-- Main structure css file -->
  <link  rel="stylesheet" href="<?= base_url('assets/admin/login-css/login3-style.css'); ?>">
  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if IE]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
 
  </head>
  
  <body>
    <!-- Start Preloader -->
    <div id="preload-block">
      <div class="square-block"></div>
    </div>
    <!-- Preloader End -->
    
    <div class="container-fluid">
      <div class="row">
        <div class="authfy-container col-xs-12 col-sm-10 col-md-8 col-lg-6 col-sm-offset-1 col-md-offset-2 col-lg-offset-3">
          <div class="col-sm-5 authfy-panel-left">
            <div class="brand-col">
              <div class="headline">
                <!-- brand-logo start -->
                <div class="brand-logo text-center">
                <?php 
                    if (isset($app_info) && !empty($app_info['app_icon']) && file_exists('./assets/img/' . $app_info['app_icon'])) {
                        $logo = base_url('assets/img/' . $app_info['app_icon']);
                    } else {
                        $logo = base_url('assets/admin/img/brand-logo-white.png');
                    }
                ?>
                  <img src="<?= $logo; ?>" width="150" alt="brand-logo">
                </div><!-- ./brand-logo -->
                <p class="text-center"><?= $app_info['app_subtitle']; ?></p>
              </div>
            </div>
          </div>
          <div class="col-sm-7 authfy-panel-right">
            <!-- authfy-login start -->
            <div class="authfy-login">
              <!-- panel-login start -->
              <div class="authfy-panel panel-login text-center active">
                <div class="authfy-heading">
                  <h3 class="auth-title">Login to your account</h3>
                  <?php if (isset($type) && $type == "candidate") { ?> 
                  <p>Don't have an account? <a class="lnk-toggler" data-panel=".panel-signup" href="<?= base_url('candidate-signup'); ?>">Sign Up Now!</a></p>
                  <?php } ?>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12">
                    <form class="loginForm" action="" method="POST">
                      <?= form_error('email', '<div class="text-danger text-left">', '</div>'); ?>
                      <div class="form-group">
                        <input type="email" class="form-control email" name="email" value="<?= $email??strtolower(set_value('email')); ?>" placeholder="Email address">
                      </div>
                      <?= form_error('password', '<div class="text-danger text-left">', '</div>'); ?>
                      <div class="form-group">
                        <div class="pwdMask">
                          <input type="password" class="form-control password" name="password" value="" placeholder="Password">
                          <span class="fa fa-eye-slash pwd-toggle"></span>
                        </div>
                      </div>
                      <!-- start remember-row -->
                      <div class="row remember-row">
                        <div class="col-xs-6 col-sm-6">
                          <label class="checkbox text-left">
                            <input type="checkbox" id="remember" name="remember">
                            <span class="label-text">Remember me</span>
                          </label>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                          <p class="forgotPwd">
                            <a class="lnk-toggler" href="<?= base_url($type.'/forgot-password'); ?>">Forgot password?</a>
                          </p>
                        </div>
                      </div> <!-- ./remember-row -->
                      <?php if($this->session->flashdata('error')){ ?>
                        <div class="row">
                          <div class="col-12 my-2 text-danger">
                            <?= $this->session->flashdata('error'); ?>
                          </div>
                        </div>
                      <?php } ?>

                      <?php if($this->session->flashdata('success')){ ?>
                        <div class="row">
                          <div class="col-12 my-2 text-success">
                            <?= $this->session->flashdata('success'); ?>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Login with email</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div> <!-- ./authfy-login -->
          </div>
        </div>
      </div> <!-- ./row -->
    </div> <!-- ./container -->
    
    <!-- Javascript Files -->

    <!-- initialize jQuery Library -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
  
    <!-- for Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
  
    <!-- Custom js-->
    <script >
    ! function(a) {
        "use strict";
        a("html, body");
        var e = a(".pwdMask > .form-control"),
            t = a(".pwd-toggle");
        a(t).on("click", function(t) {
            t.preventDefault(), a(this).toggleClass("fa-eye-slash fa-eye"), a(this).hasClass("fa-eye") ? a(e).attr("type", "text") : a(e).attr("type", "password")
        }), 
        a(window).on("load", function() {
            a(".square-block").fadeOut(), a("#preload-block").fadeOut("slow", function() {
                a(this).remove()
            })
        })
    }(jQuery); </script>
  
  </body>	
</html>
