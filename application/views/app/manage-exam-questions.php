<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
    <!-- Select 2 -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2/css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
      #question-list_wrapper > div:nth-child(1) > div:nth-child(2) {
        display: flex;
        align-items: center;
        justify-content: end;
      }

      div.dataTables_wrapper div.dataTables_filter {
          text-align: right;
          display: inline-block;
          margin-right: 5px;
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
            <div class="card">
              <div class="card-body" id="question-form">
                <div class="row">
                  <div class="col-md-12">
                    
                    <table class="table" id="question-list">
                      <thead>
                        <tr>
                          <th>SNo.</th>
                          <th>Question</th>
                          <th>Type</th>
                          <th>Category</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        if (isset($questions) && !empty($questions)){
                          $i = 1;
                          foreach ($questions as $question => $q) {
                      ?>
                      <tr>
                        <td><?= $i; ?></td>
                        <td>
                          <?= $q['question_en']??$q['question_hi']; ?>
                        </td>
                        <td><?= strtoupper($q['question_type']); ?></td>
                        <td>
                          <?= $q['category_name']; ?>
                        </td>
                        <td>
                          <?php if (isset($q['eqid'])) { ?>
                            <button data-toggle="tooltip" data-placement="top" title="Remove from Exam" data-questionid="<?= $q['question_id']; ?>" class="btn btn-default btn-sm btn-remove-question"> <i class="fa fa-minus"></i> </button>
                          <?php } else { ?>
                            <button data-toggle="tooltip" data-placement="top" title="Add to Exam" data-questionid="<?= $q['question_id']; ?>" class="btn btn-default btn-sm btn-add-question"> <i class="fa fa-plus"></i> </button>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php $i++; } } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <?php if (isset($exam_questions)) { ?>
                  <a href="<?= base_url('exams'); ?>" class="btn btn-primary">
                    Return to Exams List
                  </a>
                <?php } else { ?>
                  <a href="<?= base_url('exam/'.$exam_id.'/edit-candidates'); ?>" class="btn btn-primary">
                    Next <i class="fas fa-arrow-right"></i>
                  </a>
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
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/jszip/jszip.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>
    <!-- Select 2 -->
    <script src="<?= base_url('assets/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();

          var dataTable = $('#question-list').DataTable({

              "initComplete": function () {

                  var htmlToAppend = `
                    <div class="form-group" style="max-width: 150px;margin-bottom: 7px;">
                      <select class="form-control form-control-sm" id="categoryFilter">
                        <option value="">All Category</option>
                        <?php 
                          if (isset($categories)) {
                            foreach ($categories as $key => $obj) {
                              echo '<option value="'.$obj['category_name'].'">'.$obj['category_name'].'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>

                    <a href="<?= base_url('exams/'.$exam_id.'/download-paper'); ?>" class="btn btn-default btn-sm ml-2" style="margin-bottom: 7px;" target="_blank">Paper PDF</a>
                  `;

                  $('#question-list_wrapper > div:nth-child(1) > div:nth-child(2)').append(htmlToAppend);

                  $('#categoryFilter').on('change', function () {
                      var selectedCategory = $(this).val();
                      dataTable.columns(3).search('').draw();
                      dataTable.columns(3).search(selectedCategory).draw();
                  });
              }
          });

          $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
          });

          $("#check-all").on("change", function() {
              var isChecked = $(this).prop("checked");
              $(".check").prop("checked", isChecked);
              $("#delete-button").prop("disabled", !isChecked);
          });

          $(".check").on("change", function() {
              var allChecked = $(".check:checked").length === $(".check").length;
              $("#check-all").prop("checked", allChecked);              
          });

          $(document).on("click", ".btn-add-question", function () {
            let _obj = $(this);
            const examid = '<?= $exam_id; ?>';
            const questionid = $(this).data('questionid');

            $.ajax({
              type: 'POST',
              url: '<?= base_url("exams/addExamQuestion"); ?>',
              data: {
                  examid: examid,
                  questionid: questionid
              },
              success: function(response) {
                var data = JSON.parse(response);
                if (data.status === "SUCCESS") {
                  _obj.html('<i class="fa fa-minus"></i>')
                      .addClass('btn-remove-question')
                      .removeClass('btn-add-question')
                      .attr('title', 'Remove from Exam');
                }
              },
              error: function(xhr, status, error) {
                  alert("Error: " + error);
              }
            });

          });

          $(document).on("click", ".btn-remove-question", function () {
            let _obj = $(this);
            const examid = '<?= $exam_id; ?>';
            const questionid = $(this).data('questionid');

            $.ajax({
              type: 'POST',
              url: '<?= base_url("exams/removeExamQuestion"); ?>',
              data: {
                  examid: examid,
                  questionid: questionid
              },
              success: function(response) {
                var data = JSON.parse(response);
                if (data.status === "SUCCESS") {
                  _obj.html('<i class="fa fa-plus"></i>')
                      .addClass('btn-add-question')
                      .removeClass('btn-remove-question')
                      .attr('title', 'Add to Exam');
                }
              },
              error: function(xhr, status, error) {
                  alert("Error: " + error);
              }
            });
          });
      });
    </script>
  </body>
</html>
