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
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
    
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
      #data-table_filter {
        display: inline-block;
        float: right;
      }

      #data-table_info {
        display: inline-block;
      }

      #data-table_paginate {
        display: inline-block;
        float: right;
      }
    </style>
  </head>
  <body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

      <?php $this->load->view('app/includes/topnavbar'); ?>
      <?php $this->load->view('app/includes/sidebar'); ?>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-12">
                <h1 class="m-0"><?= $title; ?></h1>
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
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <form action="<?= base_url('exams/bulkUpload'); ?>" enctype="multipart/form-data" method="post">
                      <input type="hidden" name="exam_id" value="<?= $exam_id??''; ?>">
                      <div class="row">
                        <div class="col-md-3">
                          <a href="<?= base_url('exams/'.$exam_id."/download-excel-format"); ?>" class="btn btn-success btn-block mb-3"><i class="fa fa-file-excel"></i> Bulk Xlsx Format</a>
                        </div>
                        <div class="col-md-7">
                          <div class="form-group">
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="excel_file" class="custom-file-input" id="upload-excel">
                                <label class="custom-file-label" for="upload-excel">Upload excel file</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2"> 
                          <button type="submit" class="btn btn-primary btn-bulk-upload  btn-block mb-3">Upload</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-4">
                    <button class="btn btn-default mr-2" id="add-candidates-button" disabled>Add Candidates</button>
                    <button class="btn btn-danger" id="remove-candidates-button" disabled>Remove Candidates</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body" id="example1_wrapper">
                    <table id="data-table" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="check-all" class="check-all"></th>
                          <th>SNo.</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Registered</th>
                          <th>SMS Sent</th>
                          <th>Email Sent</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 text-right mb-4">
                    <a href="<?= base_url('exam/edit/' . $exam_id ); ?>" class="btn btn-default btn-sm bg-white"><i class="fas fa-edit "></i>&nbsp;&nbsp;Edit Exam</a>
                    <a href="<?= base_url('exams'); ?>" class="btn btn-success btn-sm "><i class="fas fa-list"></i>&nbsp;&nbsp;Go to Exams List</a>
                    
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
    <!-- Select 2 -->
    <script src="<?= base_url('assets/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>
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

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {

        $("#data-table").DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
              "url": "<?= base_url('exams/getExamCandidateData/') . $exam_id; ?>",
              "type": "POST"
          },
          "columns": [
              {"data": "checkbox"},
              {"data": "SNo"},
              {"data": "Name", "name":"c.firstname"},
              {"data": "Phone", "name":"c.phone"},
              {"data": "Email", "name":"c.email"},
              {"data": "Registered", "name":"c.created_at"},
              {"data": "SMS Sent"},
              {"data": "Email Sent"},
              {"data": "Action"}
          ],
          "responsive": true, 
          "lengthChange": true, 
          "lengthMenu": [
            [ 10, 25, 50, 100, 200],
            [ '10', '25', '50', '100', '200']
          ],
          "dom": 'lBftip',
          "autoWidth": false, 
          "paging": true,
          "scrollY": 666,
          "buttons": [
            {
              extend: 'excel',
              exportOptions: {
                columns: [1,2,3,4,5,6,7]
              }
            },
            { 
              extend: 'pdf',
              exportOptions: {
                columns: [1,2,3,4,5,6,7]
              }
            }, 
            {
                extend: 'print',
                exportOptions: {
                  columns: [1,2,3,4,5,6,7]
                }
            }
          ],
          "columnDefs": [
              {
                  "targets": [0, 1, 6, 7, 8],
                  "orderable": false
              }
          ],
          "order": [[1, 'asc']]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

          let base_url = '<?= base_url(); ?>';
          $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
          });

          $('.select2').select2();     

          $(document).on('click', '.btn-add-candidate', function(event) {
            event.preventDefault();
            let _obj = $(this);
            let candidateId = $(this).data('user');
            $.ajax({
              type: 'POST',
              url: '<?= base_url("exam/insert-candidate-to-exam"); ?>',
              data: {
                  candidate_id: candidateId,
                  exam_id: '<?= $exam_id; ?>'
              },
              success: function(response) {
                console.log(response);
                var data = JSON.parse(response);
                if (data.status === "SUCCESS") {
                    _obj.removeClass('btn-add-candidate')
                        .addClass('btn-remove-candidate')
                        .attr('data-user', data.last_id)
                        .html(`<i class="fas fa-times"></i>`);
                } else {
                  alert(data.message);
                }
              },
              error: function(xhr, status, error) {
                  alert("Error: " + error);
              }
            });
          });

          $(document).on('click', '.btn-remove-candidate', function(event) {
            event.preventDefault();
            let _obj = $(this);
            let _id = $(this).attr('data-user');
            $.ajax({
              type: 'POST',
              url: '<?= base_url("exam/remove-candidate-from-exam"); ?>',
              data: {
                  id: _id,
              },
              success: function(response) {
                var data = JSON.parse(response);
                if (data.status === "SUCCESS") {
                  _obj.addClass('btn-add-candidate')
                      .removeClass('btn-remove-candidate')
                      .attr('data-user', data.user_id)
                      .html(`<i class="fas fa-plus"></i>`);
                } else {
                  alert(data.message);
                }
              },
              error: function(xhr, status, error) {
                  alert("Error: " + error);
              }
            });
          });

          $("#check-all").on("change", function() {
              var isChecked = $(this).prop("checked");
              $(".check").prop("checked", isChecked);
              $("#add-candidates-button").prop("disabled", !isChecked);
              $("#remove-candidates-button").prop("disabled", !isChecked);
          });

          $(document).on("change", ".check", function() {
              var allChecked = $(".check:checked").length === $(".check").length;
              $("#check-all").prop("checked", allChecked);     
              
              if ($(".check:checked").length > 0) {
                $("#add-candidates-button").prop("disabled", false);
                $("#remove-candidates-button").prop("disabled", false);
              } else {
                $("#add-candidates-button").prop("disabled", true);
                $("#remove-candidates-button").prop("disabled", true);
              }
          });

          $(document).on('click', '#add-candidates-button', function(event) {
            event.preventDefault();
            $(this).empty().html(`
              <span class="spinner-border spinner-border-sm"></span>
              <span>Loading...</span>
            `);
            var checkedValues = $(".check:checked:not(:disabled)").map(function() {
                return $(this).val();
            }).get();

            $.ajax({
                type: 'POST',
                url: '<?= base_url("exams/add-selected-candidates"); ?>',
                data: {
                    checkedValues: JSON.stringify(checkedValues),
                    examId: '<?= $exam_id; ?>'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });

          });

          $(document).on('click', '#remove-candidates-button', function(event) {
            event.preventDefault();
            $(this).empty().html(`
                <span class="spinner-border spinner-border-sm"></span>
                <span>Loading...</span>
            `);
            var checkedValues = $(".check:checked:not(:disabled)").map(function() {
                return $(this).val();
            }).get();
            
            $.ajax({
                type: 'POST',
                url: '<?= base_url("exams/remove-selected-candidates"); ?>',
                data: {
                    checkedValues: JSON.stringify(checkedValues),
                    examId: '<?= $exam_id; ?>'
                },
                success: function(response) {
                    location.reload();
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
