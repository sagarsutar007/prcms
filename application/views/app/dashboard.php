<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">
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
              <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">

            <?php if($this->session->flashdata('error')){ ?>
            <div class="row">
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

            <?php if ( $this->session->userdata('type') == 'candidate') { ?>
            <div class="row">
               <div class="col-lg-4 d-none d-lg-block">
                  <div class="info-box">
                     <span class="info-box-icon bg-info"><i class="fas fa-question"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text text-dark">Total Exams</span>
                        <span class="info-box-number text-dark"><?= $total_exams; ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 d-none d-lg-block">
                  <div class="info-box">
                     <span class="info-box-icon bg-info"><i class="fas fa-question"></i></span>
                     <div class="info-box-content">
                        <a href="<?= base_url('exams/upcoming'); ?>"><span class="info-box-text text-dark">Upcoming Exams</span></a>
                        <span class="info-box-number text-dark"><?= $upcoming_exams; ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 d-none d-lg-block">
                  <div class="info-box">
                     <span class="info-box-icon bg-info"><i class="fas fa-question"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text text-dark">Completed Exams</span>
                        <span class="info-box-number text-dark"><?= $completed_exams; ?></span>
                     </div>
                  </div>
               </div>


               <div class="col d-sm-none">
                  <div class="card">
                     <div class="card-header">
                        <h3 class="card-title">Upcoming Exam</h3>
                     </div>
                     <div class="card-body">
                        <?php if (count($exams)) { $exam = $exams[0]; ?>
                        <h4><?= $exam['name']; ?></h4> 
                        <p>Duration: <?= $exam['duration']; ?></p> 
                        <a href="<?= base_url('exams/'.$exam['url'].'/begin'); ?>" class="btn btn-sm btn-primary">Goto Exam</a>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
            <?php } else if ( $this->session->userdata('type') == 'client') { ?>
            <div class="row">
               <div class="col-lg-4">
                  <div class="info-box">
                     <span class="info-box-icon bg-info"><i class="fas fa-question"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text text-dark">Total Exams</span>
                        <span class="info-box-number text-dark"><?= $total_exams; ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="info-box">
                     <span class="info-box-icon bg-info"><i class="fas fa-question"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text text-dark">Upcoming Exams</span>
                        <span class="info-box-number text-dark"><?= $upcoming_exams; ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="info-box">
                     <span class="info-box-icon bg-info"><i class="fas fa-question"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text text-dark">Conducted Exams</span>
                        <span class="info-box-number text-dark"><?= $conducted_exams; ?></span>
                     </div>
                  </div>
               </div>
            </div>
            <?php } else { ?>
            <div class="row">
               <div class="col-lg-3 col-6">
                  <a href="<?= base_url('clients'); ?>">
                     <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-university"></i></span>
                        <div class="info-box-content">
                           <span class="info-box-text text-dark">Clients</span>
                           <span class="info-box-number text-dark"><?= $total_client; ?></span>
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-3 col-6">
                  <a href="<?= base_url('candidates'); ?>">
                     <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                           <span class="info-box-text text-dark">Candidates</span>
                           <span class="info-box-number text-dark"><?= $total_candidate; ?></span>
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-3 col-6">
                  <a href="<?= base_url('exams'); ?>">
                     <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-clipboard"></i></span>
                        <div class="info-box-content">
                           <span class="info-box-text text-dark">Conducted Exams</span>
                           <span class="info-box-number text-dark"><?= $conducted_exams??0; ?></span>
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-3 col-6">
                  <a href="<?= base_url('exams'); ?>">
                     <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-question"></i></span>
                        <div class="info-box-content">
                           <span class="info-box-text text-dark">Upcoming Exams</span>
                           <span class="info-box-number text-dark"><?= $upcoming_exams??0; ?></span>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-header">
                        <h3 class="card-title">Active Users</h3>
                        <div class="card-tools d-flex align-items-center">
                           <div class="form-group m-0">
                              <select id="activeUsersSelect" class="form-control form-control-sm" style="max-width: 100px;">
                                 <option value="">All Units</option>
                                 <?php
                                    if (isset($_SESSION['companies'])) {
                                       foreach ($_SESSION['companies'] as $companies => $company) {
                                 ?>
                                 <option value="<?= $company['id']; ?>"><?= $company['company_name']; ?></option>
                                 <?php } } ?>
                              </select>
                           </div>
                           <button type="button" class="btn btn-default btn-sm active-users ml-2" title="Date range" data-fromdate="" data-todate="">
                              <i class="far fa-calendar-alt"></i>
                           </button>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="chart">
                           <div id="activeUsers" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-header">
                        <h3 class="card-title">Candidate Registrations</h3>
                        <div class="card-tools d-flex align-items-center">
                           <div class="form-group m-0">
                              <select id="candidatesSelect" class="form-control form-control-sm" style="max-width: 100px;">
                                 <option value="">All Units</option>
                                 <?php
                                    if (isset($_SESSION['companies'])) {
                                       foreach ($_SESSION['companies'] as $companies => $company) {
                                 ?>
                                 <option value="<?= $company['id']; ?>"><?= $company['company_name']; ?></option>
                                 <?php } } ?>
                              </select>
                           </div>
                           <button type="button" class="btn btn-default btn-sm candidate-registration ml-2" title="Date range" data-fromdate="" data-todate="">
                              <i class="far fa-calendar-alt"></i>
                           </button>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="chart">
                           <div id="candidateRegistrations" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
            <?php if ( $this->session->userdata('type') != 'candidate') { ?>
            <div class="row">
               <div class="col-12">
                  <div class="card">
                     <div class="card-header">
                        <h3 class="card-title">Exams Conducted</h3>
                        <div class="card-tools d-flex align-items-center">
                           <?php if ($_SESSION['type'] == 'admin' || $_SESSION['type'] == 'business unit') { ?>
                           <div class="form-group m-0">
                              <select id="exams-select" class="form-control form-control-sm" style="max-width: 100px;">
                                 <option value="">All Units</option>
                                 <?php
                                    if (isset($_SESSION['companies'])) {
                                       foreach ($_SESSION['companies'] as $companies => $company) {
                                 ?>
                                 <option value="<?= $company['id']; ?>"><?= $company['company_name']; ?></option>
                                 <?php } } ?>
                              </select>
                           </div>
                           <?php } ?>
                           <button type="button" class="btn btn-default btn-sm exams-conducted ml-2" title="Date range" data-fromdate="" data-todate="">
                              <i class="far fa-calendar-alt"></i>
                           </button>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="chart">
                           <div id="examsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php } else { ?>
            <div class="row">
               <div class="col-md-4">
                  <div class="card card-info card-outline">
                     <div class="card-header">
                         <h3 class="card-title">Attendance Chart</h3>
                     </div>
                     <div class="card-body">
                         <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                     </div>
                 </div>
               </div>
            </div>
            <?php } ?>
          </div>
        </section>
      </div>
      <?php $this->load->view('app/includes/footer'); ?>
    </div>
    <!-- Scripts -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url('assets/admin/plugins/moment/moment.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('assets/admin/plugins/chart.js/Chart.min.js'); ?>"></script>
    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>

    <script>
      $(document).ready(function () {
         var dateRangeConfig = {
            ranges: {
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
               'This Year': [moment().subtract(11, 'month').startOf('month'), moment().endOf('month')]
            },
            startDate: moment().subtract(6, 'days'),
            endDate: moment()
         };

         $('.active-users').daterangepicker(dateRangeConfig, function (start, end) {
            let from_date = start.format('YYYY-MM-DD'); 
            let to_date = end.format('YYYY-MM-DD');
            let business_unit = $("#activeUsersSelect").val();

            $('.active-users').attr('data-fromdate', from_date);
            $('.active-users').attr('data-todate', to_date);

            fetchActiveUsersData(business_unit, from_date, to_date)
            .then(function (resp) {
               let fetchedData = JSON.parse(resp);
               google.charts.load('current', { 'packages': ['bar'] });
               google.charts.setOnLoadCallback(function () {
                  drawChart(fetchedData.data);
               });
            })
            .catch(function (error) {
               console.error(error);
            });
         });

         $("#activeUsersSelect").on('change', function () {
            const _bu = $(this).val();
            const _fd = $(".active-users").attr('data-fromdate');
            const _td = $(".active-users").attr('data-todate');

            fetchActiveUsersData(_bu, _fd, _td)
            .then(function (resp) {
               let fetchedData = JSON.parse(resp);
               google.charts.load('current', { 'packages': ['bar'] });
               google.charts.setOnLoadCallback(function () {
                  drawChart(fetchedData.data);
               });

            })
            .catch(function (error) {
               console.error(error);
            });
         });

         $('.candidate-registration').daterangepicker(dateRangeConfig, function (start, end) {
            let from_date = start.format('YYYY-MM-DD'); 
            let to_date = end.format('YYYY-MM-DD');
            let business_unit = $("#activeUsersSelect").val();

            $('.candidate-registration').attr('data-fromdate', from_date);
            $('.candidate-registration').attr('data-todate', to_date);

            fetchCandidateRegsData(business_unit, from_date, to_date)
               .then(function (resp) {
                  let fetchedData = JSON.parse(resp);
                  google.charts.load('current', { 'packages': ['bar'] });
                  google.charts.setOnLoadCallback(function () {
                     drawCandidatesChart(fetchedData.data);
                  });
               })
               .catch(function (error) {
                  console.error(error);
               });
         });

         $("#candidatesSelect").on('change', function () {
            const _bu = $(this).val();
            const _fd = $(".candidate-registration").attr('data-fromdate');
            const _td = $(".candidate-registration").attr('data-todate');

            fetchCandidateRegsData(_bu, _fd, _td)
               .then(function (resp) {
                  let fetchedData = JSON.parse(resp);
                  google.charts.load('current', { 'packages': ['bar'] });
                  google.charts.setOnLoadCallback(function () {
                     drawCandidatesChart(fetchedData.data);
                  });

               })
               .catch(function (error) {
                  console.error(error);
               });
         });

         $('.exams-conducted').daterangepicker(dateRangeConfig, function (start, end) {
            let from_date = start.format('YYYY-MM-DD'); 
            let to_date = end.format('YYYY-MM-DD');
            let business_unit = $("#exams-select").val();

            $('.exams-conducted').attr('data-fromdate', from_date);
            $('.exams-conducted').attr('data-todate', to_date);

            fetchExamsChartData(business_unit, from_date, to_date)
               .then(function (resp) {
                  let fetchedData = JSON.parse(resp);
                  google.charts.load('current', { 'packages': ['bar'] });
                  google.charts.setOnLoadCallback(function () {
                     drawExamsChart(fetchedData.data);
                  });
               })
               .catch(function (error) {
                  console.error(error);
               });
         });

         $("#exams-select").on('change', function () {
            const _bu = $(this).val();
            const _fd = $(".exams-conducted").attr('data-fromdate');
            const _td = $(".exams-conducted").attr('data-todate');

            fetchExamsChartData(_bu, _fd, _td)
               .then(function (resp) {
                  let fetchedData = JSON.parse(resp);
                  google.charts.load('current', { 'packages': ['bar'] });
                  google.charts.setOnLoadCallback(function () {
                     drawExamsChart(fetchedData.data);
                  });

               })
               .catch(function (error) {
                  console.error(error);
               });
         });

         function fetchActiveUsersData(bu, fd, td){
            return new Promise(function (resolve, reject) {
               $.ajax({
                  type: "post",
                  url: "<?= base_url('Dashboard/fetchActiveUsersData'); ?>",
                  data: {"business_unit": bu, "from_date": fd, "to_date": td},
                  success: function (response) {
                     resolve(response);
                  },
                  error: function (xhr, status, error) {
                     reject(error);
                  }
               });
            });
         }

         function fetchCandidateRegsData(bu, fd, td){
            return new Promise(function (resolve, reject) {
               $.ajax({
                  type: "post",
                  url: "<?= base_url('Dashboard/fetchCandidateRegsData'); ?>",
                  data: {"business_unit": bu, "from_date": fd, "to_date": td},
                  success: function (response) {
                     resolve(response);
                  },
                  error: function (xhr, status, error) {
                     reject(error);
                  }
               });
            });
         }

         function fetchExamsChartData(bu, fd, td){
            <?php if ($this->session->userdata('type') == 'client') { ?>
               bu = <?= $company['id']; ?>;
            <?php } ?>
            return new Promise(function (resolve, reject) {
               $.ajax({
                  type: "post",
                  url: "<?= base_url('Dashboard/fetchExamsChartData'); ?>",
                  data: {"business_unit": bu, "from_date": fd, "to_date": td},
                  success: function (response) {
                     resolve(response);
                  },
                  error: function (xhr, status, error) {
                     reject(error);
                  }
               });
            });
         }

         <?php if ($this->session->userdata('type') == 'candidate') { ?>
           var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
           var donutData = {
               labels: [
                   'Attended',
                   'Not Attended'
               ],
               datasets: [
                   {
                       data: [<?= $completed_exams; ?>, <?= $total_exams - $completed_exams; ?>],
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
                  var text = "<?= $completed_exams . "/" . $total_exams; ?>",
                  textX = Math.round((width - ctx.measureText(text).width) / 2),
                  textY = (height / 2)+15;
                  ctx.fillText(text, textX, textY);
                  ctx.save();
               }
           });

         <?php } ?>
      });
      <?php if ($this->session->userdata('type') != 'candidate') { ?>
         let data = <?= $active_users??'[]'; ?>;   
         let candidates = <?= $candidate_regs??'[]'; ?>; 
         let exams = <?= $exam_records??'[]'; ?>; 

         google.charts.load('current', {'packages':['bar']});
         google.charts.setOnLoadCallback(function () {
            <?php 
               $type = $this->session->userdata('type'); 
               if ( $type == 'admin' || $type == 'business unit') { 
            ?>
            drawChart(data);
            drawCandidatesChart(candidates);
            <?php } ?>
            drawExamsChart(exams);
         });

         function drawChart(data) {
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn('string', 'Months');
            dataTable.addColumn('number', 'Candidates');
            
            for (var i = 1; i < data.length; i++) {
               dataTable.addRow([data[i][0], data[i][1]]);
            }

            var options = {
               legend: { position: 'none' },
               hAxis: { title: '', textPosition: 'none' },
               vAxis: { title: '', textPosition: 'none' }
            };

            var chart = new google.charts.Bar(document.getElementById('activeUsers'));
            chart.draw(dataTable, google.charts.Bar.convertOptions(options));
         }

         function drawCandidatesChart(candidates) {
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn('string', 'Months');
            dataTable.addColumn('number', 'Candidates');
            
            for (var i = 1; i < candidates.length; i++) {
               dataTable.addRow([candidates[i][0], candidates[i][1]]);
            }

            var options = {
               legend: { position: 'none' },
               hAxis: { title: '', textPosition: 'none' },
               vAxis: { title: '', textPosition: 'none' }
            };

            var chart = new google.charts.Bar(document.getElementById('candidateRegistrations'));
            chart.draw(dataTable, google.charts.Bar.convertOptions(options));
         }

         function drawExamsChart(exams) {
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn('string', 'Months');
            dataTable.addColumn('number', 'Exams');
            
            for (var i = 1; i < exams.length; i++) {
               dataTable.addRow([exams[i][0], exams[i][1]]);
            }

            var options = {
               legend: { position: 'none' },
               hAxis: { title: '', textPosition: 'none' },
               vAxis: { title: '', textPosition: 'none' }
            };

            var chart = new google.charts.Bar(document.getElementById('examsChart'));
            chart.draw(dataTable, google.charts.Bar.convertOptions(options));
         }
      <?php } ?>
    </script>
  </body>
</html>
