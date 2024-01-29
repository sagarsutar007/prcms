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
      #progress-bar { display: none; }
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
              <div class="col-sm-12">
                <h1 class="m-0"><?= $exam['name']??$title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('exams'); ?>">Exams</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('exams/' . $exam['id'] . '/view-exam-dashboard'); ?>">Exam Dashboard</a></li>
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
                
                <?php if($this->session->flashdata('error')){ ?>
                <div class="row mb-3">
                  <div class="col-12 mtb-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error!</strong> <?= $this->session->flashdata('error'); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
                <?php } ?>

                <?php if($this->session->flashdata('warning')){ ?>
                <div class="row mb-3">
                  <div class="col-12 mtb-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
                <?php } ?>

                <?php if($this->session->flashdata('success')){ ?>
                <div class="row mb-3">
                  <div class="col-12 mtb-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> <?= $this->session->flashdata('success'); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
                <?php } ?>

                <div class="card">
                  <div class="card-header">
                    <i class="fas fa-file-pdf"></i> Generate & Download Exam Result PDF
                  </div>
                  <div class="card-body p-2">
                    <div class="row" >
                      <div class="col-12">
                        <h2 class="text-center gen-text">Generate Exam PDF</h2>
                      </div>
                      <div class="col-12 p-5" id="progress-bar">
                        <div class="progress">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                        <h6 class="text-secondary text-center progress-counter">0%</h6>
                      </div>
                    </div>
                    
                  </div>
                  <div class="card-footer text-center">
                    <a href="<?= base_url('exams/'.$exam['id'].'/clear-results-pdf?ret=true'); ?>" class="btn bg-danger">
                      <i class="fas fa-trash"></i>&nbsp;Clear PDFs
                    </a>
                    <button class="btn btn-primary btn-generate-pdfs">Start Generating PDFs</button>
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

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
          const candidatesArr = <?= json_encode($candidates); ?>;

          $('.btn-generate-pdfs').on('click', async function() {
              
              var checkFileResult = await checkFile();
              if (!checkFileResult) {
                  $('#progress-bar').show();
                  for (const candidate of candidatesArr) {
                      const candidateId = candidate.id;
                      const examId = <?= $exam['id']; ?>;

                      try {
                          const url = `<?= base_url(); ?>candidate/generate-candidate-result?examid=${examId}&userid=${candidateId}&return=json`;

                          await sendAjaxRequest(url);

                          updateProgressBar((candidatesArr.indexOf(candidate) + 1) / candidatesArr.length * 100, candidate.name);
                      } catch (error) {
                          console.error("Error generating PDF for candidate:", candidateId, error);
                      }
                  }
                  downloadFile();
              } else {
                  $('#progress-bar').hide();
                  $(this).attr('disabled', false).html(`Start Generating PDFs`);
              }
          });

          function sendAjaxRequest(url) {
              return $.ajax({
                  url: url,
                  method: 'GET',
              });
          }

          function updateProgressBar(percentage, name) {
              $('.progress-bar').css('width', percentage + '%');
              $('.progress-counter').text(percentage.toFixed(2) + '%');
              $('.gen-text').text("Generating " + name +"'s PDF");
          }

          async function checkFile() {
              return new Promise((resolve, reject) => {
                  $.ajax({
                      url: '<?= base_url('exams/checkResult/' . $exam['id']); ?>',
                      type: 'GET',
                  })
                  .done(function(response) {
                      var data = JSON.parse(response);
                      if (data.status === 'SUCCESS') {
                          window.location.href = data.file;
                          resolve(true);
                      } else {
                          resolve(false);
                      }
                  })
                  .fail(function() {
                      reject(false);
                  });
              });
          }

          function downloadFile() {
              $.ajax({
                  url: '<?= base_url('exams/downloadResult/' . $exam['id']); ?>',
                  type: 'GET',
              })
              .done(function(response) {
                  var data = JSON.parse(response);

                  if (data.status === 'SUCCESS') {
                      window.location.href = data.file;
                  } else {
                      toastr.error('Download failed. Please try again.');
                  }

                  $('.btn-generate-pdfs').attr('disabled', false).html(`Start Generating PDFs`);
              })
              .fail(function() {
                  toastr.error('Download failed. Please try again.');
              });
          }

      });
    </script>
  </body>
</html>
