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
      #overlay {
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5); 
        z-index: 9999; 
        justify-content: center;
        align-items: center;
        color: white;
      }

      #overlay i {
        color: #fff; 
      }
    </style>
  </head>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
    <div class="wrapper">

      <?php $this->load->view('app/includes/topnavbar'); ?>
      <?php $this->load->view('app/includes/sidebar'); ?>

      <div class="content-wrapper">
        <div class="overlay" id="overlay">
          <i class="fas fa-2x fa-sync-alt fa-spin"></i>
        </div>
        
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-6">
                <h1 class="m-0"><?= $title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
              </div>
              <div class="col-6 text-end">
              </div>
            </div>
          </div>
        </div>

        <div class="content">
          <div class="container-fluid">
            <div class="row">
                
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Candidates found : <?= $total_candidates; ?></h3>
                        </div>
                        <div class="card-body" id="example1_wrapper">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SNo.</th>
                                    <th>Candidate</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Aadhaar</th>
                                    <th>Employee ID</th>
                                    <th>Business Unit</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($results as $records => $record) { ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $record['name']; ?></td>
                                    <td><?= $record['phone']; ?></td>
                                    <td><?= $record['email']; ?></td>
                                    <td><?= $record['aadhaar_number']; ?></td>
                                    <td><?= $record['empid']; ?></td>
                                    <td><?= $record['company_name']; ?></td>
                                    <td><?= ucfirst($record['status']); ?></td>
                                    <td><a href="search-candidate-exam-list?id=<?= $record['id']; ?>" target="_blank" class="btn btn-sm btn-info">View Exams List</a></td>
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
    <div id="btn-start-exam"></div>
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
      $(document).ready(function () {
        $("#data-table").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false, "paging": true,
          "buttons": [
            {
              extend: 'excel',
              exportOptions: {
                columns: [1,2,3,4,5,6]
              }
            },
            { 
              extend: 'pdf',
              exportOptions: {
                columns: [1,2,3,4,5,6]
              }
            }, 
            {
                extend: 'print',
                exportOptions: {
                  columns: [1,2,3,4,5,6]
                }
            }
          ],
          "columnDefs": [{
              "targets": [7],
              "orderable": false
          }],
          "order": [[1, 'asc']]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        
        $(document).on('click', '.btn-loader' ,function () {
            $('#overlay').css('display', 'flex');
            setTimeout(function () {
                $('#overlay').hide();
            }, 60000); 
        });
    });
</script>

  </body>
</html>
