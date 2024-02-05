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
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
      .fw-light {
        font-weight: 400!important;
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
              <div class="col-md-10 mx-auto">
                <form action="" id="exam-form" method="post" autocomplete="off" enctype="multipart/form-data">
                  <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><?= $title; ?></h3>
                    </div>
                    <div class="card-body" id="classes-form">                      
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-8">
                              <div class="form-group">
                                <label>Exam Name<sup>*</sup></label>
                                <div class="row">
                                  <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control" name="name" value="<?= $record['name']??set_value('name'); ?>" placeholder="Enter exam name*">
                                    <?= form_error('name', '<div class="text-danger">', '</div>'); ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Select Business Unit</label>
                                <select name="company_id" id="company-dd" class="form-control">
                                  <?php
                                    if (isset($_SESSION['companies'])) {
                                      foreach ($_SESSION['companies'] as $companies => $company) {
                                        if (isset($record['company_id']) && $company['id'] == $record['company_id']) {
                                  ?>
                                  <option value="<?= $company['id']; ?>" selected><?= $company['company_name']; ?></option>
                                  <?php } else { ?>
                                  <option value="<?= $company['id']; ?>"><?= $company['company_name']; ?></option>
                                  <?php 
                                        }
                                      }
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="duration">Duration</label>
                                <input type="number" min="1" id="duration" class="form-control" name="duration" value="<?= $record['duration']??set_value('duration'); ?>" placeholder="Enter duration in mins*">
                                <?= form_error('duration', '<div class="text-danger">', '</div>'); ?>
                              </div>
                            </div>
                            <div class="col-md-4 bootstrap-timepicker">
                                <div class="form-group">
                                  <label>Time picker:</label>
                                  <div class="input-group date" id="timepicker" data-target-input="nearest">
                                    <?php 
                                    if (isset($record) && !empty($record['exam_datetime'])) {
                                      $data_time = date('h:i a', strtotime($record['exam_datetime']));
                                    } else {
                                      $data_time = '';
                                    }
                                    ?>
                                      <input type="text" name="time" class="form-control datetimepicker-input" data-target="#timepicker" value="<?= $data_time; ?>" />
                                      <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                                      </div>
                                  </div>
                                  <?= form_error('time', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label>Date:</label>
                                  <div class="input-group date" id="datepicker" data-target-input="nearest">
                                      <?php 
                                      if (isset($record) && !empty($record['exam_datetime'])) {
                                        $data_date = date('d-m-Y', strtotime($record['exam_datetime']));
                                      } else {
                                        $data_date = date('d-m-Y');
                                      }
                                      ?>
                                      <input type="text" name="date" class="form-control datetimepicker-input" data-target="#datepicker" value="<?= $data_date; ?>" />
                                      <div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                                  <?= form_error('date', '<div class="text-danger">', '</div>'); ?>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Language</label>
                                <?php 
                                  if (isset($record) && isset($record['lang'])) {
                                    if ($record['lang']=='eng') {
                                      $eng = 'checked';
                                      $hin = '';
                                      $both = '';
                                    } else if ($record['lang']=='hindi') {
                                      $eng = '';
                                      $hin = 'checked';
                                      $both = '';
                                    } else{
                                      $eng = '';
                                      $hin = '';
                                      $both = 'checked';
                                    }
                                  } else {
                                    $eng = '';
                                    $hin = '';
                                    $both = 'checked';
                                  }
                                ?>
                                <div class="d-flex align-items-center">
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="lang-eng" name="lang" value="eng" <?= $eng; ?>>
                                    <label for="lang-eng" class="custom-control-label fw-4">English</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-4">
                                    <input class="custom-control-input" type="radio" id="lang-hin" name="lang" value="hindi" <?= $hin; ?>>
                                    <label for="lang-hin" class="custom-control-label fw-4">Hindi</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-4">
                                    <input class="custom-control-input" type="radio" id="lang-both" name="lang" value="both" <?= $both; ?>>
                                    <label for="lang-both" class="custom-control-label fw-4">Both</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label>Pass Percentage</label>
                                <input type="number" name="pass_percentage" class="form-control" value="<?= $record['pass_percentage']??''; ?>" />
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="show_marks" class="mb-3">Show Marks</label>
                                <?php 
                                  if (isset($record) && isset($record['show_marks']) ) {
                                    if ($record['show_marks']=='on'){
                                      $off = '';
                                      $on = 'checked';
                                    } else {
                                      $off = 'checked';
                                      $on = '';
                                    }
                                  } else {
                                    $off = 'checked';
                                    $on = '';
                                  }
                                ?>
                                <div class="d-flex align-items-center">
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="show_marks_on" name="show_marks" value="on" <?= $on; ?> />
                                    <label for="show_marks_on" class="custom-control-label fw-4">On</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-4">
                                    <input class="custom-control-input" type="radio" id="show_marks_off" name="show_marks" value="off" <?= $off; ?> />
                                    <label for="show_marks_off" class="custom-control-label fw-4">Off</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <?php 
                                  if (isset($record) && isset($record['sms_notif']) ) {
                                    if ($record['sms_notif']=='on'){
                                      $off = '';
                                      $on = 'checked';
                                    } else {
                                      $off = 'checked';
                                      $on = '';
                                    }
                                  } else {
                                    $off = 'checked';
                                    $on = '';
                                  }
                              ?>
                              <div class="form-group">
                                <label for="sms_notif" class="mb-3">SMS Notification</label><br>
                                <div class="d-flex align-items-center">
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="sms_notif_on" name="sms_notif" value="on" <?= $on; ?> />
                                    <label for="sms_notif_on" class="custom-control-label fw-4">On</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-4">
                                    <input class="custom-control-input" type="radio" id="sms_notif_off" name="sms_notif" value="off" <?= $off; ?> />
                                    <label for="sms_notif_off" class="custom-control-label fw-4">Off</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <?php 
                                  if (isset($record) && isset($record['email_notif']) ) {
                                    if ($record['email_notif']=='on'){
                                      $off = '';
                                      $on = 'checked';
                                    } else {
                                      $off = 'checked';
                                      $on = '';
                                    }
                                  } else {
                                    $off = 'checked';
                                    $on = '';
                                  }
                              ?>
                              <div class="form-group">
                                <label for="email_notif" class="mb-3">Email Notification</label><br>
                                <div class="d-flex align-items-center">
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="email_notif_on" name="email_notif" value="on" <?= $on; ?> />
                                    <label for="email_notif_on" class="custom-control-label fw-4">On</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-4">
                                    <input class="custom-control-input" type="radio" id="email_notif_off" name="email_notif" value="off" <?= $off; ?> />
                                    <label for="email_notif_off" class="custom-control-label fw-4">Off</label>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <?php if(isset($record)) { ?>
                            <div class="col-md-2 status-dd">
                              <div class="form-group">
                                <label>Status:</label>
                                <select name="status" class="form-control select2bs4" style="width: 100%;">
                                  <option value="<?=$record['status']; ?>" selected hidden><?= ucfirst($record['status']); ?></option>
                                  <option value="scheduled">Schedule</option>
                                  <option value="cancelled">Cancel</option>
                                  <option value="draft">Draft</option>
                                </select>
                              </div>
                            </div>
                            <?php } ?>
                            <div class="col-md">
                              <div class="form-group">
                                <label for="existing-user">Select Client</label>
                                <select class="select2" name="client_ids[]" id="existing-users" style="width:100%;" multiple>
                                  <?php 
                                    if (isset($clients)) {
                                      foreach ($clients as $client => $clnt) {
                                        if (isset($exam_clients) && in_array($clnt['id'], $exam_clients)) {
                                  ?>
                                  <option value="<?= $clnt['id']; ?>" selected>
                                    <?= $clnt['company_name']; ?>
                                  </option>
                                  <?php } else { ?>
                                  <option value="<?= $clnt['id']; ?>">
                                    <?= $clnt['company_name']; ?>
                                  </option>
                                  <?php
                                        }
                                      }
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer clearfix">
                      <div class="float-right">
                        <button type="submit" class="btn btn-primary "><?= isset($exam_clients)?'Update':'Next'; ?> <i class="fas fa-arrow-right"></i></button>
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

    <script src="<?= base_url('assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/moment/moment.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/inputmask/jquery.inputmask.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
          $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
          });

          $('.select2').select2();

          $('#timepicker').datetimepicker({
            format: 'LT'
          });

          $('#datepicker').datetimepicker({
              format: 'DD-MM-YYYY',
              // minDate: new Date()
          });

          $("#company-dd").on('change', function(e){
            e.preventDefault();
            let companyId = this.value;
            $.ajax({
              url:'<?= site_url("clients/getClientsOfCompany");?>',
              method:"POST",
              data: {id:companyId},
              success:function(response)
              {
                var data = JSON.parse(response);
                if (data.status === "SUCCESS") {
                  $("#existing-users").select2('destroy').empty();
                  if (data.clients.length > 0) {
                    $.each(data.clients, function (ind, val) { 
                      $("#existing-users").append(`
                        <option value="${val.id}">${val.company_name}</option>
                      `);
                    });
                  }
                  $("#existing-users").select2();
                }
              }
            });
          });

          <?php 
          if (isset($record)){
            $dateString = $record['exam_datetime'];
            $timestamp = strtotime($dateString);
            $currentTimestamp = time();
            if ($timestamp < $currentTimestamp && $record['status'] == 'scheduled') {
          ?>
            $('#exam-form :input').not('[name="pass_percentage"]').not('[name^="show_marks"]').prop('readonly', true);
            $('select').prop('disabled', true);
            $('.status-dd').hide();
            $('[name^="show_marks"]').change(function() {
              var isChecked = $(this).prop('checked');
              var associatedInput = $(this).closest('.form-group').find('input[type="number"]');
              associatedInput.prop('readonly', !isChecked);
            });
             $('input[name="email_notif"]').prop('disabled', true);
             $('input[name="sms_notif"]').prop('disabled', true);
             $('input[name="lang"]').prop('disabled', true);
          <?php } } ?>
      });
    </script>
  </body>
</html>
