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
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
      #progress-bar { display: none; }
      #data-table_filter {
        display: inline-block;
        float: right;
      }

      .p-adjust {
          padding: .25rem 0rem;
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
              <div class="col-sm-12">
                <h1 class="m-0"><?= $exam['name']??$title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('exams'); ?>">Exams</a></li>
                  <li class="breadcrumb-item active"><?= $exam['name']??'Not Available'; ?></li>
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

                
              </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Candidate List</h3>
                        </div>
                        <div class="card-body"  id="example1_wrapper">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" id="check-all" class="check-all">
                                        </th>
                                        <th width="5%">SNo.</th>
                                        <th>Candidate</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th width="13%">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 15px;">
                                    <?php $i=1; foreach ($candidates as $candidate) { ?>
                                    <tr>
                                        <td width="5%"><input type="checkbox" name="recs[]" class="check" value="<?= $candidate['id']; ?>"></td>
                                        <td width="5%"><?= $i; ?></td>
                                        <td><?= $candidate['name']; ?></td>
                                        <td><?= $candidate['phone']; ?></td>
                                        <td><?= $candidate['email']; ?></td>
                                        <td style="white-space: nowrap;">
                                            <div class="btn-group">
                                                <button class="btn btn-primary btn-sm send-sms-button" data-id="<?= $candidate['id']; ?>">Send SMS</button>
                                                <button class="btn btn-primary btn-sm send-email-button" data-id="<?= $candidate['id']; ?>">Send E-Mail</button>
                                            </div>
                                        </td>
                                    </tr>      
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#notifyModal" data-type="Sms">Send SMS</button>
                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#notifyModal" data-type="E-Mail">Send E-Mail</button>
                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#notifyModal" data-type="Both">Send Both</button>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('app/includes/footer'); ?>
    </div>

    <div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="notifyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notifyModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" >
                      <div class="col-12">
                        <h2 class="text-center gen-text">Sending Notifications</h2>
                        <p class="text-center">Please do not close or reload this window before the process is complete.</p>
                      </div>
                      <div class="col-12 p-5" id="progress-bar">
                        <div class="progress">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                        <h6 class="text-secondary text-center progress-counter">0%</h6>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
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
      $(document).ready(function() {
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

        $("#data-table").DataTable({
          "responsive": true,
          "dom": 'Bft',
          "autoWidth": false, 
          "paging": false,
          "scrollY": "700px",
          "scrollCollapse": true,
          "buttons": [
              {
                  extend: 'excel',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5]
                  }
              },
              { 
                  extend: 'pdf',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5]
                  }
              }, 
              {
                  extend: 'print',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5]
                  }
              }
          ],
          "columnDefs": [
              {
                  "targets": [0, 5],
                  "orderable": false
              }
          ],
          "order": [[2, 'desc']]
        }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

        let candidatesArr = []; 
        const examId = <?= $exam['id']; ?>;
        async function notify(type) {
            candidatesArr = $(".check:checked:not(:disabled)").map(function() {
                return $(this).val();
            }).get();

            $('#progress-bar').show();
            for (const candidate of candidatesArr) {
                const candidateId = candidate;
                try {
                    const url = `<?= base_url(); ?>exams/notifyCandidate?examid=${examId}&userid=${candidateId}&return=json&type=${type}`;

                    await sendAjaxRequest(url);

                    updateProgressBar((candidatesArr.indexOf(candidate) + 1) / candidatesArr.length * 100, candidate.name);
                } catch (error) {
                    console.error("Error generating PDF for candidate:", candidateId, error);
                }
            }
        }

        $('#notifyModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var type = button.data('type');
            var modal = $(this)
            modal.find('.modal-title').text("Send " + type);
            notify(type);
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
            
            if (percentage == '100') {
                $('.gen-text').text("Process Complete");
                $(".card-footer").show();
            } else {
                $('.gen-text').text("Sending notification please wait...");
                $(".card-footer").hide(); 
            }
        }

        $(".send-email-button").on('click', function () {
            var obj = $(this);
            var checkedValue = obj.data('id');
            obj.html(`
                <div class="spinner-border spinner-border-sm text-light" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            `).attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?= base_url("candidates/notify-candidate"); ?>',
                data: {
                    candidateId: checkedValue,
                    type: "mail",
                    examId: '<?= $exam['id']; ?>',
                },
                success: function(response) {
                    obj.html(`<i class="fas fa-check"></i> E-mail Sent`);
                },
                error: function(xhr, status, error) {
                    obj.removeAttr("disabled").html(`Send E-mail`);
                    alert("Error: " + error);
                }
            });
        });

        $(".send-sms-button").on('click', function () {
            var obj = $(this);
            var checkedValue = obj.data('id');
            obj.html(`
                <div class="spinner-border spinner-border-sm text-light" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            `).attr('disabled', 'disabled');
            
            $.ajax({
                type: 'POST',
                url: '<?= base_url("candidates/notify-candidate"); ?>',
                data: {
                    candidateId: checkedValue,
                    type: "sms",
                    examId: '<?= $exam['id']; ?>'
                },
                success: function(response) {
                    obj.html(`<i class="fas fa-check"></i> SMS Sent`);
                },
                error: function(xhr, status, error) {
                    obj.removeAttr("disabled").html(`Send SMS`);
                    alert("Error: " + error);
                }
            });
        });
      });
    </script>
  </body>
</html>
