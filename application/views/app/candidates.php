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

    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
      #data-table_filter {
        display: inline-block;
        float: right;
      }

      .p-adjust {
          padding: .25rem 0rem;
      }
    </style>
  </head>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
    <div class="wrapper">
      <?php 
        $this->load->view('app/includes/topnavbar');
        $this->load->view('app/includes/sidebar'); 
      ?>
      <div class="content-wrapper pb-3">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-4">
                <h1 class="m-0"><?= $title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
              </div>
              <div class="col-sm-8 d-none d-sm-flex align-items-center justify-content-end">
                <div class="form-group mb-0 pb-0 mr-2">
                  <select id="status-dd" class="form-control form-control-sm" style="max-width: 150px;">
                    <?php if (isset($_GET['status'])) { ?>
                    <option value="<?= $_GET['status']; ?>" selected hidden><?= ucfirst($_GET['status']); ?></option>
                    <?php } ?>
                    <option value="active">Active</option>
                    <option value="blocked">Blocked</option>
                    <option value="all">All</option>
                  </select>
                </div>
                <div class="form-group mb-0 pb-0 mr-2">
                  <select id="company-dd" class="form-control form-control-sm" style="max-width: 150px;">
                    <option value="">All Business Unit</option>
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
                  <i class="fas fa-trash"></i> <span class="d-none d-md-inline-block">Delete</span>
                </button>
                <div class="btn-group ml-2">
                  <button id="send-button" type="button" class="btn btn-default  btn-sm dropdown-toggle" disabled data-toggle="dropdown">
                    Send
                  </button>
                  <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="#" id="send-email-button">Login E-Mail</a>
                    <a class="dropdown-item" href="#" id="send-sms-button">Login SMS</a>
                  </div>
                </div>
                <a href="<?= base_url('candidates/filter'); ?>" class="btn btn-default btn-sm  ml-2">
                  <i class="fas fa-filter"></i> <span class="d-none d-md-inline-block">Filter</span>
                </a>
                <a href="<?= base_url('candidate/create'); ?>" class="btn btn-default btn-sm  ml-2">
                  <i class="fas fa-plus"></i> <span class="d-none d-md-inline-block">Add New</span>
                </a>
                <a href="<?= base_url('candidate/bulk-upload'); ?>" class="btn btn-default btn-sm  ml-2">
                  <i class="fas fa-upload"></i> <span class="d-none d-md-inline-block">Bulk Upload</span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="content">
          <div class="container-fluid mb-3 ">
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
            <div class="card mb-0">
              <div class="card-body" id="example1_wrapper">
                <table id="data-table" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                        <th>
                          <input type="checkbox" id="check-all" class="check-all">
                        </th>
                        <th>SNo.</th>
                        <th>Candidate</th>
                        <!-- <th>Father</th> -->
                        <th>DOB</th>
                        <th>Aadhaar</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th width="13%">Action</th>
                      </tr>
                  </thead>
                  <tbody style="font-size: 15px;">
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

    <?php $usrl = base_url('candidates/getData?') . $_SERVER['QUERY_STRING'];?>
    <script>
      $(function () {
        

        $("#data-table").DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
              "url": "<?= $usrl; ?>",
              "type": "POST"
          },
          "columns": [
              {"data": "checkbox"},
              {"data": "SNo", "name":"c.id"},
              {"data": "CandidateName", "name":"c.firstname"},
              // {"data": "FathersName", "name":"cd.father_name"},
              {"data": "DOB", "name":"cd.dob"},
              {"data": "AadhaarNumber", "name":"cd.aadhaar_number"},
              {"data": "Phone", "name":"c.phone"},
              {"data": "Email", "name":"c.email"},
              {"data": "Gender", "name":"c.gender"},
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
          "scrollY": 700,
          "buttons": [
              {
                  extend: 'excel',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5, 6, 7]
                  }
              },
              { 
                  extend: 'pdf',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5, 6, 7]
                  }
              }, 
              {
                  extend: 'print',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5, 6, 7]
                  }
              }
          ],
          "columnDefs": [
              {
                  "targets": [0, 1, 8],
                  "orderable": false
              }
          ],
          "order": [[1, 'desc']],
          "initComplete": function(settings, json) {
            $('[data-toggle="tooltip"]').tooltip();
          },
          "drawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
          }
        }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');


        var currentUrl = window.location.href;
        $('[data-toggle="tooltip"]').tooltip();

        $('#limit-dd').on('change', function () {
            var selectedValue = $(this).val();
            var newUrl = updateQueryStringParameter(currentUrl, 'limit', selectedValue);
            window.location.href = newUrl;
        });

        $('#status-dd').on('change', function () {
            var selectedValue = $(this).val();
            var newUrl = updateQueryStringParameter(currentUrl, 'status', selectedValue);
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
            $("#send-button").prop("disabled", !isChecked);
        });

        $(document).on("change", ".check", function() {
            var allChecked = $(".check:checked").length === $(".check").length;
            $("#check-all").prop("checked", allChecked);

            if ($(".check:checked").length > 0) {
              $("#delete-button").prop("disabled", false);
              $("#send-button").prop("disabled", false);
            } else {
              $("#delete-button").prop("disabled", true);
              $("#send-button").prop("disabled", true);
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
                    url: '<?= base_url("candidates/delete-selected"); ?>',
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

        $("#send-email-button").on('click', function () {
            var checkedValues = $(".check:checked:not(:disabled)").map(function() {
                return $(this).val();
            }).get();
            
            $.ajax({
                type: 'POST',
                url: '<?= base_url("candidates/send-login-mail"); ?>',
                data: {
                    checkedValues: JSON.stringify(checkedValues),
                },
                success: function(response) {
                  alert("Email successfully sent to candidates");
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        });

        $("#send-sms-button").on('click', function () {
            var checkedValues = $(".check:checked:not(:disabled)").map(function() {
                return $(this).val();
            }).get();
            
            $.ajax({
                type: 'POST',
                url: '<?= base_url("candidates/send-login-sms"); ?>',
                data: {
                    checkedValues: JSON.stringify(checkedValues),
                },
                success: function(response) {
                  alert("SMS successfully sent to candidates");
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
