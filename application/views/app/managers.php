<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Managers</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">

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
              <div class="col-6">
                <h1 class="m-0">Managers</h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active">Managers</li>
                </ol>
              </div>
              <div class="col-6 d-flex align-items-center justify-content-end">
                
                <button class="btn btn-danger btn-sm " id="delete-button" disabled>
                  <i class="fas fa-trash"></i> <span class="d-none d-sm-inline-block">Delete</span>
                </button>
                <a href="<?= base_url('business-units/manager/create'); ?>" class="btn btn-default btn-sm  ml-2">
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
            <div class="card">
              <div class="card-body" id="example1_wrapper">
                <table id="data-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>
                        <input type="checkbox" id="check-all" class="check-all"> 
                      </th>
                      <th>SNo.</th>
                      <th>Manager Name</th>
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
                      <td><?= $i ?></td>
                      <td>
                        <?= $record['firstname']." ".$record['middlename']." ".$record['lastname']; ?>
                      </td>
                      <td>
                          <?= $record['email']; ?>
                      </td>
                      <td>
                          <?= $record['phone']; ?>
                      </td>
                      <td class="text-center">
                        <!-- <a href="<?= base_url('business-units/manager/view/').$record['id']; ?>" class="btn btn-primary btn-sm "> <i class="fas fa-eye"></i> </a> -->
                        <a href="<?= base_url('business-units/manager/edit/').$record['id']; ?>" class="btn btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fas fa-edit"></i> </a>/<a href="<?= base_url('business-units/manager/delete/').$record['id']; ?>" onClick="return confirm('This manager will be deleted and can\'t be recovered. Are you sure to delete?');" class="btn btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fas fa-trash"></i> </a>
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

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(function () {

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
                    url: '<?= base_url("business-units/managers/delete-selected"); ?>',
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
