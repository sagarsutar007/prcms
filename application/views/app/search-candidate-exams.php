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
                                    <th>Exam Name</th>
                                    <th>Business Unit</th>
                                    <th>Date Time</th>
                                    <th>Questions</th>
                                    <th>Candidates</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($results as $records => $record) { ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td>
                                    <?= $record['name']; ?>
                                    </td>
                                    <td><?= $record['company_name']; ?></td>
                                    <td class="text-sm">
                                    <?= ($record['exam_datetime'] == '0000-00-00 00:00:00' || empty($record['exam_datetime']))?'':date('d-m-Y h:ia', strtotime($record['exam_datetime'])); ?>
                                    </td>
                                    <td class="text-sm">
                                        <?= $record['questions'] ?>
                                    </td>
                                    <td>
                                    <?= $record['candidates']; ?>
                                    </td>
                                    <td>
                                    <?php if (empty($record['exam_datetime'])) { ?>
                                        <span class="badge badge-pill badge-warning">Draft</span> 
                                    <?php } else { ?>
                                    <?php if ($record['status'] == 'scheduled' && strtotime($record['exam_datetime']) < strtotime(date('Y-m-d H:i:s')) ) { 
                                        $currentDateTime = strtotime(date('Y-m-d H:i:s'));
                                        $examStartTime = strtotime($record['exam_datetime']);
                                        $examEndTime = strtotime($record['exam_endtime']);
                                        if ($currentDateTime > $examStartTime && $currentDateTime < $examEndTime) {
                                        echo "<span class='badge badge-pill badge-success'>In progress</span>";
                                        } else {
                                        echo "<span class='badge badge-pill badge-primary'>Conducted</span>";
                                        }
                                        
                                    } else if ($record['status'] == 'scheduled') { ?>
                                        <span class="badge badge-pill badge-success">Scheduled</span>
                                    <?php } else if ($record['status'] == 'draft') { ?>
                                        <span class="badge badge-pill badge-warning">Draft</span> 
                                    <?php } else if ($record['status'] == 'stopped') { ?>
                                        <span class="badge badge-pill badge-danger">Stopped</span> 
                                    <?php } else { ?>
                                        <span class="badge badge-pill badge-danger">Cancelled</span> 
                                    <?php }} ?>
                                    </td>
                                    <td class="text-left">
                                    <?php 
                                        $show = false;
                                        if ($record['status'] == 'scheduled') { 
                                        if (empty($record['exam_datetime'])) {
                                            $show = true;
                                        } else if (strtotime($record['exam_datetime']) > strtotime(date('Y-m-d H:i:s'))) {
                                            $show = true;
                                        }
                                        } else if ($record['status'] == 'draft') {
                                        $show = true;
                                        }

                                        if ($show) {
                                    ?>
                                    <div class="btn-group">
                                        <?php if ($record['status'] == 'draft') { ?>
                                        <a href="<?= base_url('exams/'.$record['id'].'/schedule-exam'); ?>" type="button" class="btn btn-default btn-loader">Schedule</a>
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <?php } else { ?>
                                        <button type="button" class="btn btn-default  dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <?php }  ?>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item btn-loader" href="<?= base_url('exam/clone/').$record['id']; ?>">Clone Exam</a>
                                            <a class="dropdown-item btn-loader" href="<?= base_url('exam/edit/').$record['id']; ?>">Edit Exam</a>
                                            <a class="dropdown-item btn-loader" href="<?= base_url('exam/'.$record['id'].'/edit-questions'); ?>">Edit Question</a>
                                            <a class="dropdown-item btn-loader" href="<?= base_url('exam/'.$record['id'].'/edit-candidates'); ?>">Edit Candidate</a>
                                            <a class="dropdown-item btn-loader" href="<?= base_url('exam/'.$record['id'].'/exam-settings'); ?>" target="_blank">Exam Settings</a>
                                            <a class="dropdown-item btn-loader" href="<?= base_url('exam/delete/').$record['id']; ?>" onClick="return confirm('This exam along with its details will be deleted and can\'t be recovered. Are you sure to delete?');">Delete</a>
                                        </div>
                                    </div>
                                    <?php } else {?> 
                                    <a href="<?= base_url('exams/'.$record['id'].'/view-exam-dashboard'); ?>" data-toggle="tooltip" data-placement="top" title="View"> <i class="fas fa-eye"></i> </a>/<a href="<?= base_url('exam/clone/').$record['id']; ?>"  data-toggle="tooltip" data-placement="top" title="Clone"> <i class="fas fa-copy"></i> </a>/<a href="<?= base_url('exam/edit/').$record['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fas fa-pen"></i> </a>/<a href="<?= base_url('exam/'.$record['id'].'/exam-settings'); ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Settings"> <i class="fas fa-cog"></i> </a>
                                    <?php } ?>
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
          var serverTime = <?= $now = time() * 1000; ?>; // Get server time in milliseconds
          var examStartTime = new Date('2023-12-28 18:55:00').getTime();
          var btnStartExam = $('#btn-start-exam');

          function updateCountdown() {
              var now = serverTime; // Use server time
              var timeRemaining = examStartTime - now;

              if (timeRemaining <= 0) {
                  btnStartExam.text('Start Exam');
                  btnStartExam.prop('disabled', false);
                  clearInterval(countdownInterval);
              } else {
                  var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                  var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                  btnStartExam.text(minutes + 'm ' + seconds + 's');
              }
          }

          updateCountdown();
          var countdownInterval = setInterval(updateCountdown, 1000);
      
        <?php if($this->session->userdata('type') == 'candidate' || $this->session->userdata('type') == 'client'){ ?>
        $("#data-table").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false, "paging": true, "searching": false
        });
        <?php } else { ?> 
        $("#data-table").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false, "paging": true,
          "buttons": [
            {
              extend: 'excel',
              exportOptions: {
                columns: [1,2,3,4,5,6,7,8]
              }
            },
            { 
              extend: 'pdf',
              exportOptions: {
                columns: [1,2,3,4,5,6,7,8]
              }
            }, 
            {
                extend: 'print',
                exportOptions: {
                  columns: [1,2,3,4,5,6,7,8]
                }
            }
          ],
          "columnDefs": [{
              "targets": [0,9],
              "orderable": false
          }],
          "order": [[1, 'asc']]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        <?php } ?>
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
                    url: '<?= base_url("exams/delete-selected"); ?>',
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
