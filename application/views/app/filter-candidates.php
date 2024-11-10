<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
      .p-adjust {
          padding: .25rem 0rem;
      }
    </style>
  </head>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
    <div class="wrapper">

      <?php $this->load->view('app/includes/topnavbar'); ?>
      <?php $this->load->view('app/includes/sidebar'); ?>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-6">
                <h1 class="m-0"><?= $title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('candidates'); ?>">Candidates</a></li>
                  <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
              </div>
              <div class="col-6 d-flex align-items-center justify-content-end">
                <button class="btn btn-danger btn-sm " id="delete-button" disabled>
                  <span class="d-md-none"><i class="fas fa-trash"></i></span>
                  <span class="d-none d-md-block">Delete</span>
                </button>
                <div class="btn-group ml-2">
                  <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="#" id="send-email-button">Login E-Mail</a>
                    <a class="dropdown-item" href="#" id="send-sms-button">Login SMS</a>
                  </div>
                  <button id="send-button" type="button" class="btn btn-default  btn-sm dropdown-toggle" disabled data-toggle="dropdown">
                    Send
                  </button>
                </div>
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
            <div id="messages"></div>
            <div class="row">
              <div class="col">
                <div class="card">
                  <div class="card-body">
                    <form action="" method="get" autocomplete="off">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="search_name" class="form-control" placeholder="Enter Name" value="<?= $_GET['search_name']??''; ?>">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="search_email" class="form-control" placeholder="Enter Email"value="<?= $_GET['search_email']??''; ?>">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="search_phone" class="form-control" placeholder="Enter Phone" value="<?= $_GET['search_phone']??''; ?>">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="aadhaar_number" class="form-control" placeholder="Enter Aadhaar" value="<?= $_GET['aadhaar_number']??''; ?>">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="father_name" class="form-control" placeholder="Enter Father Name" value="<?= $_GET['father_name']??''; ?>">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" id="dob" name="dob" class="form-control" placeholder="Enter Dob" value="<?= $_GET['dob']??''; ?>">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <select name="search_gender" class="form-control">
                            <option value="" hidden>Choose Gender</option>
                            <option value="male" <?= (isset($_GET['search_gender']) && $_GET['search_gender'] == 'male')?'selected':''; ?>>Male</option>
                            <option value="female" <?= (isset($_GET['search_gender']) && $_GET['search_gender'] == 'female')?'selected':''; ?>>Female</option>
                            <option value="other" <?= (isset($_GET['search_gender']) && $_GET['search_gender'] == 'other')?'selected':''; ?>>Other</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <select name="search_status" class="form-control">
                            <option value="" hidden>Choose Status</option>
                            <option value="">All</option>
                            <option value="active" <?= (isset($_GET['search_status']) && $_GET['search_status'] == 'active')?'selected':''; ?>>Active</option>
                            <option value="blocked" <?= (isset($_GET['search_status']) && $_GET['search_status'] == 'blocked')?'selected':''; ?>>Blocked</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Created Date Range" value="<?= $_GET['daterange']??''; ?>">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <select class="form-control" name="search_state">
                            <?php if(isset($_GET['search_state']) && !empty($_GET['search_state'])) { ?>
                            <option value="<?= $_GET['search_state']; ?>" selected hidden><?= $_GET['search_state']; ?></option>
                            <?php } ?>
                            <option value="" hidden>Choose State</option>
                            <option value="">Any</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Assam">Assam</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Chandigarh">Chandigarh</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                            <option value="Daman and Diu">Daman and Diu</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Lakshadweep">Lakshadweep</option>
                            <option value="Puducherry">Puducherry</option>
                            <option value="Goa">Goa</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="West Bengal">West Bengal</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <button type="submit" class="btn btn-primary  btn-block"> Filter </button>
                      </div>
                      <div class="col-md-2">
                        <a href="<?= base_url('candidates/filter'); ?>" class="btn btn-default  btn-block"> Clear Filter </a>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <?php if (isset($results)) { ?>
            <div class="card">
              <div class="card-body" id="example1_wrapper">
                <table id="data-table" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                        <th style="width: 1%">
                          <input type="checkbox" id="check-all" class="check-all">
                        </th>
                        <th>SNo.</th>
                        <th>Candidate Name</th>
                        <th>Father's Name</th>
                        <th>DOB</th>
                        <th>Aadhaar Number</th>
                        <th class="d-none d-md-table-cell ">Phone</th>
                        <th class="d-none d-md-table-cell ">Email</th>
                        <th class="d-none d-md-table-cell ">Gender</th>
                        <th style="width: 13%;">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $i=1; foreach ($results as $records => $record) { ?>
                      <tr>
                        <td>
                          <input type="checkbox" name="recs[]" class="check" value="<?= $record['id']; ?>">
                        </td>
                        <td><?= $i; ?></td>
                        <td><?= ucwords($record['firstname'] . " " . $record['middlename'] . " " . $record['lastname']); ?></td>
                        <td><?= $record['father_name']; ?></td>
                        <td><?= !empty($record['dob'])?date('d-m-Y', strtotime($record['dob'])):''; ?></td>
                        <td><?= $record['aadhaar_number']; ?></td>
                        <td class="d-none d-md-table-cell "><?= $record['phone']; ?></td>
                        <td class="d-none d-md-table-cell "><?= $record['email']; ?></td>
                        <td class="d-none d-md-table-cell "><?= $record['gender']?ucfirst($record['gender']):'Not Available'; ?></td>
                        <td class="text-center">
                          <button data-recordid="<?= $record['id']; ?>" class="btn btn-link btn-sm btn-view-candidate p-adjust" data-toggle="tooltip" data-placement="top" title="View">
                            <i class="fas fa-eye"></i>
                          </button> / <button data-recordid="<?= $record['id']; ?>" class="btn btn-link btn-sm btn-edit-candidate p-adjust" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button> / <a href="<?= base_url('candidate/delete/').$record['id']; ?>" onClick="return confirm('This candidate will be deleted and can\'t be recovered. Are you sure to delete?');" class="btn btn-link btn-sm p-adjust" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fas fa-trash"></i> </a> / <a href="<?= base_url('candidate/print/') . $record['id']; ?>" class="btn btn-link btn-sm p-adjust" data-toggle="tooltip" data-placement="top" title="Print"><i class="fas fa-print"></i></a>
                        </td>
                      </tr>
                    <?php $i++; } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?php } ?>
            <!-- <div class="row mt-3">
              <div class="col-md-12">
                <div class="pagination float-right">
                    <ul class="pagination pagination-sm">
                        <?php
                        #$total_pages = ceil($total / $limit);
                        #$prev_page = ($page > 1) ? $page - 1 : 1;
                        #echo '<li class="page-item"><a class="page-link" href="?page=' . $prev_page . '&limit=' . $limit . '&order=' . $order . '">&laquo;</a></li>';

                        #for ($i = 1; $i <= $total_pages; $i++) {
                            #$class = ($i == $page) ? 'active' : '';
                            #echo '<li class="page-item ' . $class . '"><a class="page-link" href="?page=' . $i . '&limit=' . $limit . '&order=' . $order . '">' . $i . '</a></li>';
                        #}

                        #$next_page = ($page < $total_pages) ? $page + 1 : $total_pages;
                        #echo '<li class="page-item"><a class="page-link" href="?page=' . $next_page . '&limit=' . $limit . '&order=' . $order . '">&raquo;</a></li>';
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

    <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">View Candidate</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="view-candidate-modal">
            
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Candidate</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="post" id="edit-candidate" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="ajax" value="1">
            <div class="modal-body" id="edit-candidate-modal">
              
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal -->
    <!-- Scripts -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/plugins/moment/moment.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/inputmask/jquery.inputmask.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
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

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?= base_url('assets/admin/plugins/autocomplete/autocomplete-lite.js'); ?>"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(function () {

        $('#daterange').daterangepicker({
            autoUpdateInput: false,
            locale: {
              format: 'DD/MM/YYYY',
              cancelLabel: 'Clear'
            }
        });

        $('#dob').datepicker({
          dateFormat: 'dd-mm-yy'
        });

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $("#data-table").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false, "paging": true, "searching":false,
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
          "columnDefs": [ {
              "targets": [0,9],
              "orderable": false
            }
          ],
          "order": [[1, 'asc']],
          "initComplete": function(settings, json) {
            $('[data-toggle="tooltip"]').tooltip();
          },
          "drawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
          }
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
            $("#send-button").prop("disabled", !isChecked);
        });

        $(".check").on("change", function() {
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
        
        $(document).on('click', '.btn-view-candidate', function(event) {
          event.preventDefault();
          const candidate_id = $(this).data('recordid');
          if (candidate_id != null) {
            $.ajax({
              url: '<?= base_url('Candidates/ajaxView'); ?>/' + candidate_id,
              type: 'GET'
            })
            .done(function(response) {
              $("#view-candidate-modal").empty().html(response);
              $("#modal-default").modal('show');
            });
          }
        });
        let candidate_id = 0;
        $(document).on('click', '.btn-edit-candidate', function(event) {
          event.preventDefault();
          candidate_id = $(this).data('recordid');
          if (candidate_id != null) {
            $.ajax({
              url: '<?= base_url('Candidates/ajaxEdit'); ?>/' + candidate_id,
              type: 'GET'
            })
            .done(function(response) {
              $("#edit-candidate-modal").empty().html(response);
              $("#modal-edit").modal('show');
            });
          }
        }); 

        $(document).on('click', '#btn-update-candidate', function(event) {
          event.preventDefault();

          var fn = $("#fn").val();
          var phone = $("#cn").val();
          var email = $("#ce").val();
          var aadhaar = $("#aadn").val();

          if(fn.length !=0 && phone.length !=0 && email.length !=0 && aadhaar.length !=0) {
            const form = document.getElementById("edit-candidate");
            var fd = new FormData(form);
            var img_profile = $('#contact-person-picture')[0].files[0];
            fd.append('profile_img_file', img_profile);

            var passbook_pic = $('#passbook_pic')[0].files[0];
            fd.append('passbook_pic', passbook_pic);

            var chequebook_pic = $('#chequebook_pic')[0].files[0];
            fd.append('chequebook_pic', chequebook_pic);

            var aadhaar_fp = $('#aadhaar_card_front_pic')[0].files[0];
            fd.append('aadhaar_card_front_pic', aadhaar_fp);

            var aadhaar_bp = $('#aadhaar_card_back_pic')[0].files[0];
            fd.append('aadhaar_card_back_pic', aadhaar_bp);

            var voter_id = $('#voter-id')[0].files[0];
            fd.append('voter_id', voter_id);

            var pancard_pic = $('#pancard-picture')[0].files[0];
            fd.append('pancard_pic', pancard_pic);

            $.ajax({
                url: '<?= base_url('Candidates/edit/'); ?>'+ candidate_id,
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                  const parsedResponse = JSON.parse(response);
                    if (parsedResponse.status == 'SUCCESS') {
                      $("#messages").empty().append(`
                          <div class="row">
                            <div class="col-12 mtb-3">
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>${parsedResponse.message}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                            </div>
                          </div>
                      `);
                      $('#modal-edit').modal('hide');
                    }
                },
            });
          } else {
            alert("Please enter required fields.");
          }
        });

          $(document).on('click', "#same-wn", function() {
            if ($("#same-wn").is(':checked')) {
              $("#wn").val($('#cn').val()).attr('readonly', true);
            } else {
              $("#wn").val('').attr('readonly', false);
            }
          });

          $(document).on('click', '.btn-remove-asset', function() {
            const obj = $(this);
            const asset = obj.data('asset');
            $.ajax({
              url: '<?= base_url('Candidates/removeAsset'); ?>',
              type: 'POST',
              data: {asset: asset},
            })
            .done(function(response) {
              let parsedData = JSON.parse(response);
              if (parsedData.status == "SUCCESS") {
                obj.closest('tr').remove();
              }
            });          
          });

          var maxDate = new Date();
          maxDate.setFullYear(maxDate.getFullYear() - 19);
          var bank_list = [
              "Allahabad Bank",
              "Andhra Bank",
              "Axis Bank",
              "Bank of Bahrain and Kuwait",
              "Bank of Baroda - Corporate Banking",
              "Bank of Baroda - Retail Banking",
              "Bank of India",
              "Bank of Maharashtra",
              "Canara Bank",
              "Central Bank of India",
              "City Union Bank",
              "Corporation Bank",
              "Deutsche Bank",
              "Development Credit Bank",
              "Dhanlaxmi Bank",
              "Federal Bank",
              "ICICI Bank",
              "IDBI Bank",
              "Indian Bank",
              "Indian Overseas Bank",
              "IndusInd Bank",
              "ING Vysya Bank",
              "Jammu and Kashmir Bank",
              "Karnataka Bank Ltd",
              "Karur Vysya Bank",
              "Kotak Bank",
              "Laxmi Vilas Bank",
              "Oriental Bank of Commerce",
              "Punjab National Bank - Corporate Banking",
              "Punjab National Bank - Retail Banking",
              "Punjab & Sind Bank",
              "Shamrao Vitthal Co-operative Bank",
              "South Indian Bank",
              "State Bank of Bikaner & Jaipur",
              "State Bank of Hyderabad",
              "State Bank of India",
              "State Bank of Mysore",
              "State Bank of Patiala",
              "State Bank of Travancore",
              "Syndicate Bank",
              "Tamilnad Mercantile Bank Ltd.",
              "UCO Bank",
              "Union Bank of India",
              "United Bank of India",
              "Vijaya Bank",
              "Yes Bank Ltd"
            ];
            $('#modal-edit').on('shown.bs.modal', function (e) {
              $('#dob').datepicker({
                  maxDate: maxDate,
                  dateFormat: 'dd-mm-yy',
                  changeMonth: true,
                  changeYear: true
              });
              $('#bn').autocomplete_init(bank_list);

              $("#sms-table").DataTable();
              $("#email-table").DataTable();
            });

          $('#modal-edit').on('hidden.bs.modal', function (e) {
            $('#dob').remove();
            $('#bn').remove();
            $("#sms-table").remove();
            $("#email-table").remove();
          });
          
          $('#modal-default').on('shown.bs.modal', function (e) {
            $("#sms-table").DataTable();
            $("#email-table").DataTable();
          });
      });
    </script>
  </body>
</html>
