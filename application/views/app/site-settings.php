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
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Manage Application Settings</h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="bun">Application Name<sup>*</sup></label>
                            <input type="text" id="bun" class="form-control" name="app_name" value="<?= stripslashes($record['app_name']??set_value('app_name')); ?>">
                            <?= form_error('app_name', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="business-unit-logo">Application Logo Icon</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="app_icon" class="custom-file-input" id="application-logo">
                                <label class="custom-file-label" for="application-logo">Choose file</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="app_st">App Subtitle</label>
                            <input type="text" id="app_st" class="form-control" name="app_subtitle" value="<?= stripslashes($record['app_subtitle']??set_value('app_subtitle')); ?>">
                            <?= form_error('app_subtitle', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="edart">Exam Dashboard Auto Refresh Time</label>
                            <select name="edart" id="edart" class="form-control">
                              <option value="2" <?=$record['edart']==2?'selected':''?>>2 Minutes</option>
                              <option value="3" <?=$record['edart']==3?'selected':''?>>3 Minutes</option>
                              <option value="4" <?=$record['edart']==4?'selected':''?>>4 Minutes</option>
                              <option value="5" <?=$record['edart']==5?'selected':''?>>5 Minutes</option>
                              <option value="6" <?=$record['edart']==6?'selected':''?>>6 Minutes</option>
                              <option value="7" <?=$record['edart']==7?'selected':''?>>7 Minutes</option>
                              <option value="8" <?=$record['edart']==8?'selected':''?>>8 Minutes</option>
                              <option value="9" <?=$record['edart']==9?'selected':''?>>9 Minutes</option>
                              <option value="10" <?=$record['edart']==10?'selected':''?>>10 Minutes</option>
                            </select>
                            <?= form_error('app_edart', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="tr_api">Translate API Key</label>
                            <input type="text" id="tr_api" class="form-control" name="translate_api_key" value="<?= stripslashes($record['translate_api_key']??set_value('translate_api_key')); ?>">
                            <?= form_error('translate_api_key', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="smv">Send Emails Via</label>
                            <div class="form-group mb-0">
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="smtp" name="mail_type" value="smtp" class="custom-control-input" <?= $record['mail_type']=='smtp'?'checked':''; ?>>
                                <label class="custom-control-label" for="smtp">SMTP</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="api" name="mail_type" value="api" class="custom-control-input" <?= $record['mail_type']=='api'?'checked':''; ?>>
                                <label class="custom-control-label" for="api">API</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="msg_api">Messaging API Key</label>
                            <input type="text" id="msg_api" class="form-control" name="sms_api_key" value="<?= stripslashes($record['sms_api_key']??set_value('sms_api_key')); ?>">
                            <?= form_error('sms_api_key', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="msg_send_id">Messaging Sender ID</label>
                            <input type="text" id="msg_send_id" class="form-control" name="sms_sender_id" value="<?= stripslashes($record['sms_sender_id']??set_value('sms_sender_id')); ?>">
                            <?= form_error('sms_sender_id', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="email_api">Outgoing Email Server</label>
                            <input type="text" id="email_api" class="form-control" name="out_smtp" value="<?= stripslashes($record['out_smtp']??set_value('out_smtp')); ?>">
                            <?= form_error('out_smtp', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="smtp_port">SMTP Port</label>
                            <input type="text" id="smtp_port" class="form-control" name="smtp_port" value="<?= stripslashes($record['smtp_port']??set_value('smtp_port')); ?>">
                            <?= form_error('smtp_port', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="smtp_email">SMTP Email Address</label>
                            <input type="text" id="smtp_email" class="form-control" name="smtp_email" value="<?= stripslashes($record['smtp_email']??set_value('smtp_email')); ?>">
                            <?= form_error('smtp_email', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="smtp_pass">SMTP Email Password</label>
                            <input type="password" id="smtp_pass" class="form-control" name="smtp_pass" value="<?= stripslashes($record['smtp_pass']??set_value('smtp_pass')); ?>">
                            <?= form_error('smtp_pass', '<div class="text-danger">', '</div>'); ?>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 text-right">
                          <button type="submit" class="btn btn-primary  btn-sm">SAVE</button>
                        </div>
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

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {

      });
    </script>
  </body>
</html>
