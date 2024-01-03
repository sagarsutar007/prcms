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
      #sub-section .nav-pills .nav-link {
        border-radius: 0px;
      }
      #sub-section .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #007bff;
        background-color: transparent;
        border-bottom: 3px solid #007bff;
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
              <div class="col-6">
                <h1 class="m-0"><?= $title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('question-bank/categories'); ?>">Categories</a></li>
                  <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
              </div>
              <div class="col-6 d-flex align-items-center justify-content-end">
                <button class="btn btn-warning btn-sm " id="move-button" disabled>
                  <i class="fas fa-exchange-alt"></i> Change Category
                </button>
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
              <div class="col-md-12">
                <div class="card mt-3">
                  <div class="card-body" id="example1_wrapper">
                    <table id="data-table" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="check-all" class="check-all"> </th>
                          <th style="width: 1%">
                              SNo.
                          </th>
                          <th>
                              Question 
                          </th>
                          <th>
                              Type
                          </th>
                          <th>
                              Options
                          </th>
                          <th> Actions </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; foreach ($questions as $question => $que) { ?>
                        <tr>
                          <td><input type="checkbox" name="recs[]" class="check" value="<?= $que['question_id']; ?>"></td>
                          <td><?= $i; ?></td>
                          <td><?= $que['question_en']??$que['question_hi']; ?></td>
                          <td><?= strtoupper($que['question_type']); ?></td>
                          <td><?= $que['total']; ?></td>
                          <td class="text-center">
                            <a class="btn btn-link btn-sm" href="<?= base_url('question-bank/view/').$que['question_id']; ?>"><i class="fas fa-eye"></i> </a>
                          </td>
                        </tr>
                        <?php $i++; } ?>
                      </tbody>
                    </table>  
                  </div>
                </div>  
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('app/includes/footer'); ?>
    </div>

    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Move Selected Questions</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="category-dd">Select Category</label>
              <select name="category_id" class="custom-select select2" id="category-dd">
                <?php
                  if (isset($categories)) {
                    foreach ($categories as $key => $obj) {
                      echo '<option value='.$obj["id"].'>'.$obj["category_name"].'</option>';
                    }
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-move-ques">Move Questions</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
        $(".select2").select2();
        $("#data-table").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false, "paging": true,
          "buttons": [
            {
              extend: 'excel',
              exportOptions: {
                columns: [1,2,3,4]
              }
            },
            { 
              extend: 'pdf',
              exportOptions: {
                columns: [1,2,3,4]
              }
            }, 
            {
                extend: 'print',
                exportOptions: {
                  columns: [1,2,3,4]
                }
            }
          ],
          "columnDefs": [ {
              "targets": [0,5],
              "orderable": false
            }
          ],
          "order": [[1, 'asc']]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#check-all").on("change", function() {
            var isChecked = $(this).prop("checked");
            $(".check").prop("checked", isChecked);
            $("#move-button").prop("disabled", !isChecked);
        });

        $(".check").on("change", function() {
            var allChecked = $(".check:checked").length === $(".check").length;
            $("#check-all").prop("checked", allChecked);
            if ($(".check:checked").length > 0 ){
              $("#move-button").prop("disabled", false);
            } else {
              $("#move-button").prop("disabled", true);
            }
        });

        $("#move-button").on('click', function () {
          $("#modal-default").modal('show');
        });

        $(".btn-move-ques").on('click', function(e) {
          e.preventDefault();
          let checkedValues = $(".check:checked:not(:disabled)").map(function() {
                    return $(this).val();
                }).get();
          const categoryId = $("#category-dd").val();

          console.log(categoryId, checkedValues);
          if (categoryId != null) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url("categories/moveQuestions"); ?>',
                data: {
                    checkedValues: JSON.stringify(checkedValues),
                    categoryId: categoryId
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
          } else {
            alert('Please select category id to move questions.');
          }
        });
      });
    </script>
  </body>
</html>
