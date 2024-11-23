<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generate Results</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- Select 2 -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2/css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/toastr/toastr.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
        .fs-50 {
            font-size: 50px;
        }
        .small-box .icon {
            color: rgb(255 255 255 / 15%);
            z-index: 0;
        } 
        #progress-bar {
          display: none;
        }
    </style>
  </head>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
    <div class="wrapper">

      <?php $this->load->view('app/includes/topnavbar'); ?>
      <?php $this->load->view('app/includes/sidebar'); ?>
      <?php
        $exam_id = $exam['id'];
      ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-12">
                <h1 class="m-0">Generate Marks for <?= $exam['name']; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('exams'); ?>">Exams</a></li>
                  <li class="breadcrumb-item active"><?= $exam['name']; ?></li>
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
            
            <div class="card mb-3" style="box-shadow: none;">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-users mr-1"></i> Appeared Candidates
                </h3>
              </div>
              <div class="card-body">
                <div id="example1_wrapper">
                    <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td><input type="checkbox" id="selectAllCandidates"></td>
                            <td>Candidate Name</td>
                            <td>Employee ID</td>
                            <td>Aadhaar</td>
                            <td>Phone</td>
                            <td>Score</td>
                            <td>Status</td>
                            <td>Time</td>
                            <td>Secured %</td>
                            <td>Result</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($candidates as $records => $record) { ?>
                        <tr>
                            <td><input type="checkbox" name="candidate[]" class="candidate" value="<?= $record['aadhaar_number']; ?>" data-name="<?= $record['name']; ?>"></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= $record['profile_img']; ?>" class="mr-2" width="30px" height="30px" alt="">
                                    <?= ucfirst(str_replace(".", "", $record['name'])); ?>
                                </div>
                            </td>
                            <td>
                                <?= $record['empid']; ?>
                            </td>
                            <td>
                                <?= $record['aadhaar_number']; ?>
                            </td>
                            <td>
                                <?= $record['phone']; ?>
                            </td>
                            <td>
                                <?= $record['score']; ?>
                            </td>
                            <td>
                                <?php 
                                    $now = time();
                                    $exm_time = strtotime($exam['exam_endtime']);
                                    if ($record['status'] == "Appearing" && $now > $exm_time ) {
                                        echo "Submitted";
                                    } else {
                                        echo $record['status']; 
                                    }
                                ?>
                            </td>
                            <td>
                                <?php echo $record['time']; ?>
                            </td>
                            <td><?= number_format($record['percentage'], 2); ?>%</td>
                            <td><?= $record['result']; ?></td>
                            <td>
                                <a class="btn btn-link m-0 p-0" data-href="<?= 'examid='.$exam_id.'&userid='.$record['aadhaar_number']; ?>" data-toggle="tooltip" data-placement="top" title="Generate Mark">
                                    <i class="fas fa-pen"></i>
                                </a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-link m-0 p-0" target="_blank" href="<?= base_url('candidate/generate-candidate-result?examid='.$exam_id.'&userid='.$record['id']); ?>"  data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-download"></i></a>
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                    </table>
                </div>
              </div>
              <div class="card-footer"></div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('app/includes/footer'); ?>
    </div>

    <div class="modal" tabindex="-1" id="markModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="mark-modal-title">Set Marks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group" id="singleMark">
              <input type="number" id="singleMarkInput" name="mark" class="form-control" placeholder="Enter Mark" max="<?= $totalQuestions; ?>" min="0">
            </div>
            <div class="row" id="multiMark">
              <div class="col">
                <div class="form-group" id="minMark">
                  <input type="number" id="minMarkInput" name="minmark" class="form-control" placeholder="Enter Minimum Mark" max="<?= $totalQuestions; ?>" min="1">
                </div>
              </div>
              <div class="col">
                <div class="form-group" id="maxMark">
                  <input type="number" id="maxMarkInput" name="maxmark" class="form-control" placeholder="Enter Maximum Mark" max="<?= $totalQuestions; ?>">
                </div>
              </div>
            </div>
            <div class="col-12 p-5" id="progress-bar">
              <h5 class="text-center gen-text mb-3">Generate Exam PDF</h5>
              <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
              </div>
              <h6 class="text-secondary text-center progress-counter">0%</h6>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="generateResult">Generate Result</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Select 2 -->
    <script src="<?= base_url('assets/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('assets/admin/plugins/chart.js/Chart.min.js'); ?>"></script>
    <!-- Google Chart -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>
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
    <!-- Toastr -->
    <script src="<?= base_url('assets/admin/plugins/toastr/toastr.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
        $(document).ready(function() {

          $(document).on('click', "#generateResult", async function (e) {
            var run = true;
            var hasMultiple = false;
            var examId = <?= $exam['id']; ?>;
            var totalCandidates = $(".candidate").length;
            var checkedCandidates = $(".candidate:checked").length;

            let minMarkInputValue, maxMarkInputValue;

            if (totalCandidates > 1) {
                if (checkedCandidates > 1) {
                    hasMultiple = true;
                    // Multiple candidates selected
                    minMarkInputValue = parseInt($("#minMarkInput").val());
                    maxMarkInputValue = parseInt($("#maxMarkInput").val());

                    var maxMarkMaxInputValue = parseInt($("#maxMarkInput").attr('max'));

                    if (minMarkInputValue < 1) {
                        e.preventDefault();
                        run = false;
                        alert('Please enter a valid mark!');
                    }

                    if (minMarkInputValue > maxMarkInputValue) {
                        e.preventDefault();
                        run = false;
                        alert('Minimum mark should not be more than maximum mark value!');
                    }

                    if (maxMarkInputValue > maxMarkMaxInputValue) {
                        e.preventDefault();
                        run = false;
                        alert('Maximum mark value cannot be more than ' + maxMarkMaxInputValue);
                    }

                    if (minMarkInputValue >= maxMarkMaxInputValue) {
                        e.preventDefault();
                        run = false;
                        alert('Minimum mark value cannot be more than or equal to ' + maxMarkMaxInputValue);
                    }
                } else {
                    // Single candidate selected
                    var singleMarkInputValue = parseInt($("#singleMarkInput").val());
                    var singleMarkMaxInputValue = parseInt($("#singleMarkInput").attr('max'));

                    if (singleMarkInputValue < 1) {
                        e.preventDefault();
                        run = false;
                        alert('Please enter a valid mark!');
                    }
                }
            }

            if (run) {
                // Make AJAX request to selected candidates one by one
                $("#progress-bar").show();
                $('#multiMark').hide();
                $("#singleMark").hide();
                $("#generateResult").prop('disabled', true).html(`
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Processing...
                `);

                var selectedCandidates = $(".candidate:checked").map(function () {
                    return {
                        id: $(this).val(),
                        name: $(this).data('name')
                    };
                }).get();

                for (const candidate of selectedCandidates) {
                    const candidateId = candidate.id;
                    let mark;

                    if (hasMultiple) {
                        mark = Math.floor(Math.random() * (maxMarkInputValue - minMarkInputValue + 1)) + minMarkInputValue;
                    } else {
                        mark = singleMarkInputValue;
                    }

                    try {
                        const newUrl = `<?= base_url('exams/generateFakeAnswers'); ?>` +
                            `?examid=${examId}&userid=${candidateId}&mark=${mark}`;
                        await sendAjaxRequest(newUrl);
                        updateProgressBar(
                            (selectedCandidates.indexOf(candidate) + 1) / selectedCandidates.length * 100,
                            candidate.name
                        );
                    } catch (error) {
                        console.error("Error generating mark for candidate:", candidate.name, error);
                    }
                }

                $('.gen-text').text("Process Complete!");
                $("#generateResult")
                    .removeClass('btn-primary')
                    .addClass('btn-success')
                    .text('Reloading Page...');

                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
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
              $('.gen-text').text("Generating Mark For " + name);
          }

          $('[data-toggle="tooltip"]').tooltip();
          
          $("#data-table").DataTable({
              "responsive": true, 
              "lengthChange": false, 
              "autoWidth": false, 
              "paging": false,
              "scrollY": 400,
              "lengthMenu": [
                  [ 10, 25, 50, 100, 500, 1000,  -1 ],
                  [ '10', '25',  '50', '100', '500', '1000', 'All' ]
              ],
              "buttons": [
                  {
                    extend: 'excel',
                    exportOptions: {
                      columns: [1,2,3,4,5,6,7,8,9]
                    }
                  },
                  { 
                    extend: 'pdf',
                    exportOptions: {
                      columns: [1,2,3,4,5,6,7,8,9]
                    }
                  }, 
                  {
                    extend: 'print',
                    exportOptions: {
                      columns: [1,2,3,4,5,6,7,8,9]
                    }
                  },
                  {
                      text: 'Set Marks',
                      action: function (e, dt, node, config) {
                        var totalCandidates = $(".candidate").length;
                        var checkedCandidates = $(".candidate:checked").length;
                        
                        if (totalCandidates > 1 && checkedCandidates > 1) {
                          $("#mark-modal-title").text('Set Marks');
                          $('#multiMark').show();
                          $("#singleMark").hide();
                          $("#markModal").modal('show');
                        } else if(checkedCandidates == 1) {
                          $("#mark-modal-title").text('Set Mark');
                          $('#multiMark').hide();
                          $("#singleMark").show();
                          $("#markModal").modal('show');
                        } else {
                          alert('Please select candidate(s)');
                        }
                      }
                  }
              ],
              "columnDefs": [{
                "targets": [0, 9],
                "orderable": false
              }]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

          $(document).on('click', '#download-result', function(event) {
            event.preventDefault();
            toastr.info('Your download will begin shortly!');
            $(this).attr('disabled', true).html(`
                <div class="spinner-border spinner-border-sm text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                Downloading...
            `);

            $.ajax({
                url: '<?= base_url('exams/downloadResult/' . $exam_id); ?>',
                type: 'GET',
            })
            .done(function(response) {
                var data = JSON.parse(response);

                if (data.status === 'SUCCESS') {
                    window.location.href = data.file;
                } else {
                    console.error('Download failed:', data.message);
                    toastr.error('Download failed. Please try again.');
                }
            })
            .fail(function() {
                console.error('Download failed.');
                toastr.error('Download failed. Please try again.');
            })
            .always(function() {
                $('#download-result').attr('disabled', false).html(`
                    <i class="fas fa-download"></i>&nbsp;Redownload
                `);
            });
          });

          $(document).on('click', "#selectAllCandidates", function() {
            $(".candidate").prop('checked', $(this).is(':checked'));
          });

          $(document).on('click', ".candidate", function() {
              if ($(".candidate:checked").length !== $(".candidate").length) {
                $("#selectAllCandidates").prop('checked', false);
              } else {
                $("#selectAllCandidates").prop('checked', true);
              }
          });

          $('#markModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $("#progress-bar").hide();
          })
        });
    </script>
  </body>
</html>
