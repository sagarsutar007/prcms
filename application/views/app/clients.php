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
  </head>
  <body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

      <?php $this->load->view('app/includes/topnavbar'); ?>
      <?php $this->load->view('app/includes/sidebar'); ?>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-4">
                <h1 class="m-0"><?= $title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
              </div>
              <div class="col-8 d-flex align-items-center justify-content-end">
                <div class="form-group mb-0 pb-0 mr-2">
                  <select id="company-dd" class="form-control form-control-sm" style="max-width: 150px;">
                    <option value="">All</option>
                    <?php
                      if (isset($_SESSION['companies'])) {
                        foreach ($_SESSION['companies'] as $companies => $company) {
                          if (isset($_GET['company_id']) && $company['id'] == $_GET['company_id']) {
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
                <button class="btn btn-danger btn-sm " id="delete-button" disabled>
                  <i class="fas fa-trash"></i> <span class="d-none d-sm-inline-block">Delete</span>
                </button>
                <a href="<?= base_url('client/create'); ?>" class="btn btn-default btn-sm  ml-2">
                  <i class="fas fa-plus"></i> <span class="d-none d-sm-inline-block">Add New</span>
                </a>
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
              
            </div>
            <div class="card mt-3">
              <div class="card-body" id="example1_wrapper">
                <table id="data-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="check-all" class="check-all"></th>
                      <th>SNo.</th>
                      <th>Company Name</th>
                      <th>Client Name</th>
                      <th>Business Unit</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=1; foreach ($results as $records => $record) { ?>
                    <tr class="data-row">
                      <td>
                        <input type="checkbox" name="recs[]" class="check" value="<?= $record['id']; ?>">
                      </td>
                      <td><?= $i; ?></td>
                      <td>
                        <?= $record['company_name']; ?>
                      </td>
                      <td>
                        <?= $record['firstname']." ".$record['middlename']." ".$record['lastname']; ?>
                      </td>
                      <td><?= $record['business_unit']; ?></td>
                      <td>
                          <?= $record['email']; ?>
                      </td>
                      <td>
                          <?= $record['phone']; ?>
                      </td>
                      <td class="text-center">
                        <a href="<?= base_url('client/view/').$record['id']; ?>" class="btn btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="View"> <i class="fas fa-eye"></i> </a> / <a href="<?= base_url('client/edit/').$record['id']; ?>" class="btn btn-link btn-sm " data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fas fa-edit"></i> </a> / <a href="<?= base_url('client/delete/').$record['id']; ?>" onClick="return confirm('This client will be deleted and can\'t be recovered. Are you sure to delete?');" class="btn btn-link btn-sm " data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fas fa-trash"></i> </a>
                      </td>
                    </tr>
                    <?php $i++; } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- <div class="row mt-3">
              <div class="col-md-12">
                <div class="pagination float-right">
                    <ul class="pagination pagination-sm">
                        <?php
                        // $total_pages = ceil($total / $limit);
                        // $prev_page = ($page > 1) ? $page - 1 : 1;
                        // echo '<li class="page-item"><a class="page-link" href="?page=' . $prev_page . '&limit=' . $limit . '&order=' . $order . '">&laquo;</a></li>';

                        // for ($i = 1; $i <= $total_pages; $i++) {
                        //     $class = ($i == $page) ? 'active' : '';
                        //     echo '<li class="page-item ' . $class . '"><a class="page-link" href="?page=' . $i . '&limit=' . $limit . '&order=' . $order . '">' . $i . '</a></li>';
                        // }

                        // $next_page = ($page < $total_pages) ? $page + 1 : $total_pages;
                        // echo '<li class="page-item"><a class="page-link" href="?page=' . $next_page . '&limit=' . $limit . '&order=' . $order . '">&raquo;</a></li>';
                        ?>
                    </ul>
                </div>
              </div>
            </div> -->
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
      $(function () {
        $('.select2').select2({
          theme: 'bootstrap4'
        });

        $("#data-table").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false, "paging": true,
          "buttons": [
            {
              extend: 'excel',
              exportOptions: {
                columns: [1,2,3,4,5]
              }
            },
            { 
              extend: 'pdf',
              exportOptions: {
                columns: [1,2,3,4,5]
              }
            }, 
            {
                extend: 'print',
                exportOptions: {
                  columns: [1,2,3,4,5]
                }
            }
          ],
          "columnDefs": [ {
              "targets": [0,6],
              "orderable": false
            }
          ],
          "order": [[1, 'asc']]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        var currentUrl = window.location.href;
        $('[data-toggle="tooltip"]').tooltip();

        $('#limit-dd').on('change', function () {
            var selectedValue = $(this).val();
            var newUrl = updateQueryStringParameter(currentUrl, 'limit', selectedValue);
            window.location.href = newUrl;
        });

        $('#order-dd').on('change', function () {
            var selectedValue = $(this).val();
            var newUrl = updateQueryStringParameter(currentUrl, 'order', selectedValue);
            window.location.href = newUrl;
        });

        $('#company-dd').on('change', function () {
            var selectedValue = $(this).val();
            var newUrl = updateQueryStringParameter(currentUrl, 'company_id', selectedValue);
            window.location.href = newUrl;
        });

        function updateQueryStringParameter(uri, key, value) {
            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            var separator = uri.indexOf('?') !== -1 ? "&" : "?";
            if (uri.match(re)) {
                return uri.replace(re, '$1' + key + "=" + value + '$2');
            } else {
                return uri + separator + key + "=" + value;
            }
        }

        $("#check-all").on("change", function() {
            var isChecked = $(this).prop("checked");
            $(".check").prop("checked", isChecked);
            $("#delete-button").prop("disabled", !isChecked);
        });

        $(".check").on("change", function() {
            var allChecked = $(".check:checked").length === $(".check").length;
            $("#check-all").prop("checked", allChecked);
            if ($(".check:checked").length > 0) {
              $("#delete-button").prop("disabled", false);
            } else {
              $("#delete-button").prop("disabled", true);
            }
        });

        $("#delete-button").on('click', function () {
            var confirmed = confirm("Are you sure you want to delete?");
            
            if (confirmed) {
                var checkedValues = $(".check:checked:not(:disabled)").map(function() {
                    return $(this).val();
                }).get();
                
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("clients/delete-selected"); ?>',
                    data: {
                        checkedValues: JSON.stringify(checkedValues),
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error);
                    }
                });
            }
        });
      });
    </script>

  </body>
</html>
