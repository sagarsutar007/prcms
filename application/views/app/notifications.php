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
        div#data-table_length {
            display: inline-block;
            margin-right: 20px;
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
            <div class="card mt-3">
              <div class="card-body" id="example1_wrapper">
                <table id="data-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <td>Sn.</td>
                      <td>Time</td>
                      <td>Recipient</td>
                      <td>Report</td>
                      <td>Type</td>
                      <td>Action</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=1; foreach ($records as $record => $rec) { ?>
                    <tr>
                      <td>
                            <?= $i; ?>
                      </td>
                      <td>
                            <?= date('d-m-Y h:ia', strtotime($rec['created_on'])); ?>
                      </td>
                      <td>
                            <?= $rec['to_recipient']; ?>
                      </td>
                      <td>
                            <?= $rec['response']; ?>
                      </td>
                      <td>
                            <?= $rec['notif_type']; ?>
                      </td>
                      <td>
                          <button class="btn btn-link btn-view-response" data-recordid="<?= $rec['id']; ?>"><i class="fas fa-eye"></i></button>
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

    <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">View Response</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="view-response-modal">
            
          </div>
        </div>
      </div>
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

        $(document).on('click', '.btn-view-response', function(event) {
          event.preventDefault();
          const notif_id = $(this).data('recordid');
          if (notif_id != null) {
            $.ajax({
              url: '<?= base_url('Notifications/ajaxView'); ?>/' + notif_id,
              type: 'GET'
            })
            .done(function(response) {
              $("#view-response-modal").empty().html(response);
              $("#modal-default").modal('show');
            });
          }
        });


        $("#data-table").DataTable({
          "searching": true, "lengthChange": true, "autoWidth": false, "paging": true, "responsive": true,
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
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      });
    </script>

  </body>
</html>
