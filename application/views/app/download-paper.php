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
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
        
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
                <form action="" method="post">
                    <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-pdf"></i>Download Exam Paper PDF
                    </div>
                    <div class="card-body p-2">
                        <div class="row" >
                        <div class="col-12 pdf-configuration">
                            <div class="row">
                            <div class="col-md-12 mx-auto">
                                <table class="table table-sm" style="border: none;">
                                <tr style="border-top: 2px solid white;">
                                    <td width="20%">
                                    <div class="font-weight-bold mt-1">1.With Answer</div>
                                    </td>
                                    <td>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" name="pdf_question_options_config" id="qoc1" value="2" checked/>
                                        <label for="qoc1" class="font-weight-normal">Yes</label>
                                    </div>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" name="pdf_question_options_config" id="qoc2" value="1"/>
                                        <label for="qoc2" class="font-weight-normal">No</label>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                    <div class="font-weight-bold mt-1">2.Language</div>
                                    </td>
                                    <td>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" name="pdf_language_config" id="qlc1" value="1"/>
                                        <label for="qlc1" class="font-weight-normal">English</label>
                                    </div>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" name="pdf_language_config" id="qlc2" value="2"/>
                                        <label for="qlc2" class="font-weight-normal">Hindi</label>
                                    </div>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" name="pdf_language_config" id="qlc3" value="3" checked/>
                                        <label for="qlc3" class="font-weight-normal">Both</label>
                                    </div>
                                    </td>
                                </tr>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary btn-generate-pdfs"> <i class="fa fa-download"></i> Download Paper</button>
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
          const candidatesArr = <?= json_encode($candidates); ?>;
          const examId = <?= $exam['id']; ?>;

          $('.btn-generate-pdfs').on('click', async function() {
              $(".custom-section, .pdf-configuration").hide();
              let pdfType = $("[name='pdf_type']:checked").val();
              let url = '';
              if (pdfType == 1) {
                url = `<?= base_url('candidate/generate-candidate-omr-result'); ?>`;
              } else if (pdfType == 2) {
                url = `<?= base_url('candidate/generate-candidate-result'); ?>`;
              } else {
                url = `<?= base_url('candidate/generate-candidate-custom-result'); ?>`;
              }
              
              var checkFileResult = await checkFile(pdfType);
              if (!checkFileResult) {
                  $('#progress-bar').show();
                  for (const candidate of candidatesArr) {
                      const candidateId = candidate.id;
                      try {
                          newUrl = url + `?examid=${examId}&userid=${candidateId}&return=json`;
                          await sendAjaxRequest(newUrl);
                          updateProgressBar((candidatesArr.indexOf(candidate) + 1) / candidatesArr.length * 100, candidate.name);
                      } catch (error) {
                          console.error("Error generating PDF for candidate:", candidateId, error);
                      }
                  }
                  downloadFile(pdfType);
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

          async function checkFile(pdfType) {
              return new Promise((resolve, reject) => {
                  $.ajax({
                      url: '<?= base_url('exams/checkResult/' . $exam['id'] . '/'); ?>'+pdfType,
                      type: 'GET'
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

          function downloadFile(pdfType) {
              $.ajax({
                  url: '<?= base_url('exams/downloadResult/' . $exam['id']); ?>/'+pdfType,
                  type: 'GET',
              })
              .done(function(response) {
                  var data = JSON.parse(response);

                  if (data.status === 'SUCCESS') {
                      window.location.href = data.file;
                  } else {
                      console.error('Download failed. Please try again.');
                  }

                  $('.btn-generate-pdfs').attr('disabled', false).html(`Start Generating PDFs`);
              })
              .fail(function() {
                  console.error('Download failed. Please try again.');
              });
          }

          $(document).on('change', '[name="pdf_type"]', function () {
            const pdfType = $(this).val();
            if (pdfType == 3) {
              $(".custom-section").show();
            } else {
              $(".custom-section").hide();
            }
          });

      });
    </script>
  </body>
</html>
