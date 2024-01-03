
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if IE]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    .com-icon i {
      font-size: 100px;
      color:green;
    }
  </style>
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
                  if(isset($company) && !empty($company['company_logo']) && file_exists('assets/img/companies/' . $company['company_logo'])){
                    $logo = base_url('assets/img/companies/' . $company['company_logo']);
                  } else if (isset($app_info) && !empty($app_info['app_icon']) && file_exists('./assets/img/' . $app_info['app_icon'])) {
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
            <div class="authfy-login">
              <!-- panel-login start -->
              <div class="authfy-panel panel-login text-center active">
                <div class="com-icon">
                  <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="authfy-heading">
                  <h3 class="auth-title">Registration Complete</h3>
                  <p>Your registration is now complete. Thank you.</p>
                </div>
                <div class="form-group">
                  <!-- <a href="<?= base_url('logout') ?>" class="btn btn-lg btn-primary btn-block" type="submit">Go to dashboard</a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- initialize jQuery Library -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
  
    <!-- for Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
  
    <!-- Custom js-->
    <script >
      ! function(a) {
          "use strict";
          a("html, body");
          a(window).on("load", function() {
              a(".square-block").fadeOut(), a("#preload-block").fadeOut("slow", function() {
                  a(this).remove()
              })
          })
      }(jQuery); 

      // var redirectUrl = '<?= base_url('logout') ?>';
      // var delay = 5000;
      // setTimeout(function () {
      //     window.location.href = redirectUrl;
      // }, delay);
    </script>
  
  </body>	
</html>
