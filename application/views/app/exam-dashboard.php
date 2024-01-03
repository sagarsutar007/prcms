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
                <h1 class="m-0"><?= $exam['name']; ?></h1>
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
            <div class="card border-0" style="background-color: transparent; box-shadow: none;">
              <div class="card-header border-0 bg-white">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Analytics
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-default btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0 pt-2 border-0">
                <div class="row">
                    <section class="col-lg-8 connectedSortable">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <?php
                                            if (isset($business['company_logo']) && !empty($business['company_logo']) && file_exists('assets/img/companies/'.$business['company_logo'])) {
                                                $company_pic = base_url('assets/img/companies/' . $business['company_logo']);
                                            } else {
                                                $company_pic = base_url('assets/admin/img/buildings.png');
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-3">
                                                <img class="profile-user-img img-fluid img-circle" style="width: 70px;" src="<?= $company_pic; ?>" alt="User profile picture">
                                            </div>
                                            <div class="col-9">
                                                <h3 class="profile-username"><?= $business['company_name']??'Not Available'; ?></h3>
                                                <p class="text-muted text-sm">
                                                    <?php 
                                                        if (isset($business['company_address']) && strlen($business['company_address']) > 25) {
                                                            echo substr($business['company_address'], 0, 25) . "...";
                                                        }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <b>Started at</b> <br>
                                                <a href="#"><?= date('h:ia d-m-Y', strtotime($exam['exam_datetime'])); ?></a>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <?php
                                                    if (time() > strtotime($exam['exam_endtime'])) {
                                                        $label = "Ended at";
                                                    } else {
                                                        $label = "Ends at";
                                                    }
                                                ?>
                                                <b><?= $label; ?></b> <br>
                                                <a href="#"><?= date('h:ia d-m-Y', strtotime($exam['exam_endtime'])); ?></a>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                    if ($exam['creator_type'] == "admin") {
                                                        $link = base_url("my-account");
                                                    } else {
                                                        $link = base_url("business-units/view/" . $business['company_id']);
                                                    }
                                                ?>
                                                <b>Created by</b> <br> 
                                                <a href="<?= $link; ?>"><?= $exam['created_by']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-gray-dark">
                                    <div class="inner">
                                        <h3><?= $exam['questions']; ?></h3>
                                        <strong>Questions</strong>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-gray-dark">
                                    <div class="inner">
                                        <h3><?= $exam['candidates']; ?></h3>
                                        <strong>Candidates</strong>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="small-box bg-gray-dark">
                                    <div class="inner">
                                        <h3><?= $exam['clients']; ?></h3>
                                        <strong>Clients</strong>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Attendance Chart</h3>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Analytics</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="pieChart" style="width: 100%; height: 250px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-4 connectedSortable">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Top Performer</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Score</th>
                                            <th>Time Taken</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (isset($candidates)) {
                                                $i=0;
                                                foreach ($candidates as $key => $obj) {
                                                    if ($i < 7 && !empty($obj['score'])){
                                        ?>
                                        <tr>
                                            <td><img src="<?= $obj['profile_img']; ?>" width="30px" alt=""></td>
                                            <td><?= ucfirst($obj['name']); ?></td>
                                            <td><?= $obj['score']; ?></td>
                                            <td><?= $obj['time']; ?></td>
                                        </tr>
                                        <?php } $i++; } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
              </div>
            </div>
            <div class="card mb-3" style="box-shadow: none;">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-users mr-1"></i>
                  Appearing Candidates
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-default btn-sm" id="download-result"><i class="fas fa-download"></i>&nbsp;Result PDF</button>
                  <button type="button" class="btn bg-default btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" id="example1_wrapper">
                                <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td>SNo.</td>
                                        <td>Candidate Name</td>
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
                                        <td><?= $i; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $record['profile_img']; ?>" class="mr-2" width="30px" alt="">
                                                <?= ucfirst($record['name']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $record['score']; ?>
                                        </td>
                                        <td>
                                            <?= $record['status']; ?>
                                        </td>
                                        <td>
                                            <?= $record['time']; ?>
                                        </td>
                                        <td><?= number_format($record['percentage'], 2); ?>%</td>
                                        <td><?= $record['result']; ?></td>
                                        <td>
                                            <a href="<?= base_url('candidate/view-exam-result?examid='.$exam_id.'&userid='.$record['id']); ?>" class="btn btn-link">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('exams/enable-rentry?examid='.$exam_id.'&userid='.$record['id']); ?>" class="btn btn-link">
                                                <i class="fas fa-pen"></i>
                                            </a>
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
              <div class="card-footer"></div>
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
        function reloadPage() {
            location.reload();
        }

        setTimeout(reloadPage, 300000);

        $(document).ready(function() {
            $("#data-table").DataTable({
               "responsive": true, "lengthChange": true, "autoWidth": false, "paging": true,
               "lengthMenu": [
                    [ 10, 25, 50, 100, 500, 1000,  -1 ],
                    [ '10', '25',  '50', '100', '500', '1000', 'All' ]
                ],
                "buttons": [
                    {
                      extend: 'excel',
                      exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                      }
                    },
                    { 
                      extend: 'pdf',
                      exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                      }
                    }, 
                    {
                        extend: 'print',
                        exportOptions: {
                          columns: [0,1,2,3,4,5,6]
                        }
                    }
                ],
                "columnDefs": [{
                  "targets": [0,7],
                  "orderable": false
                }]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Attended',
                    'Not Attended'
                ],
                datasets: [
                    {
                        data: [<?= $exam['appeared_candidates']; ?>, <?= $exam['candidates'] - $exam['appeared_candidates']; ?>],
                        backgroundColor : ['#00c0ef', '#d2d6de'],
                    }
                ]
            }
            var donutOptions = {
                maintainAspectRatio : false,
                responsive : true,
            }

            var promisedDeliveryChart = new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            Chart.pluginService.register({
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;
                    ctx.restore();
                    var fontSize = (height / 180).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle";
                    var text = "<?= $exam['appeared_candidates'] . "/" . $exam['candidates']; ?>",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = (height / 2)+15;
                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            });
        });

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.arrayToDataTable([
                ['Status', 'Count'],
                ['Appearing', <?= $appearing; ?>],
                ['Not Joined', <?= $absent; ?>],
                ['Submitted', <?= $submitted; ?>]
            ]);
            
            var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
            var options = { 'legend':'top', slices: {0: {color: '#00c0ef'}, 1:{color: '#d2d6de'}, 2:{color: '#1a73e8'}} }
            chart.draw(data, options);
        }

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

    </script>
  </body>
</html>
