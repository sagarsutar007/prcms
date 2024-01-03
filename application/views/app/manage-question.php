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

    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
      input:disabled+label {
        color: #ccc;
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
                <h1 class="m-0"><?= $title; ?></h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('question-bank'); ?>">Question Bank</a></li>
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

            <div class="row">
              <div class="col-md-9 mx-auto">
                <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="question_id" value="<?= $question['question_id']??''; ?>">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><?= $title; ?></h3>
                    </div>
                    <div class="card-body" id="question-form">
                      <h5>Question</h5>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <textarea name="question_en" class="form-control" placeholder="Enter question text in english language." required><?= (isset($question))?$question['question_en']:'';?></textarea>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <textarea name="question_hi" class="form-control" placeholder="Enter question text in hindi language."><?= (isset($question))?$question['question_hi']:'';?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4 mb-3">
                          <h6>Question Image (Optional)</h6>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                              <label class="custom-file-label">Choose file</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <h6>Question Category</h6>
                          <select name="category_id" class="select2" style="width:100%;">
                            <?php 
                              if(isset($categories)){
                                foreach ($categories as $category => $cat) {
                                  if (isset($question) && $question['category_id'] == $cat['id']) {
                            ?>
                            <option value="<?= $cat['id']; ?>" selected><?= $cat['category_name']; ?></option>
                            <?php
                                  } else {
                            ?>
                            <option value="<?= $cat['id']; ?>"><?= $cat['category_name']; ?></option>
                            <?php
                                  }
                                }
                              }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-4 mb-3">
                          <h6>Question Status</h6>
                          <div class="form-group">
                            <select name="status" class="form-control select2" style="width:100%">
                              <option value="1" <?= (isset($question) && $question['status']=='active')?'selected':''; ?>>Active</option>
                              <option value="0" <?= (isset($question) && $question['status']=='blocked')?'selected':''; ?>>In-active</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4 col-md-2">
                          <div class="form-group">
                            <input type="checkbox" name="add_options" value="1" id="add-options" <?= (isset($question) && $question['question_type']!='text' )?'checked':''; ?>> 
                            <label for="add-options" class="fw-4">Add Options</label>
                          </div>
                        </div>
                        <div class="col-8 col-md-4">
                          <div class="form-group">
                              <input type="checkbox" id="mcq_type" name="mcq_type" value="multi-select" <?= (isset($question) && $question['question_type']=='multi-select')?'checked':'disabled'; ?>>
                              <label for="mcq_type" class="font-weight-normal">Enable Multi-Selection</label>
                          </div>  
                        </div>
                      </div>
                      <div class="row">
                        <div class="col text-primary mb-3">
                          MCQ questions can have only one correct ans and should be filled up in the first answer row.
                        </div>
                      </div>
                      <div class="answer-section">
                        <div class="row" id="options-sec">
                          <?php 
                            if(isset($answers) && count($answers) > 0){
                              $i = 0;
                              foreach ($answers as $anskey => $ansobj) {
                                if ($i == 0) {
                          ?>
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input type="checkbox" class="multi-check" name="check[<?= $i; ?>]" <?= $ansobj['isCorrect']?'checked':''; ?>>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-english" name="answer_en[<?= $i; ?>]" value="<?= $ansobj['answer_text_en']; ?>" placeholder="Enter correct answer text in english" >
                                </div>
                              </div>
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-translate-option">
                                      <i class="fa fa-language"></i>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-hindi" name="answer_hi[<?= $i; ?>]" value="<?= $ansobj['answer_text_hi']; ?>" placeholder="Enter correct answer text in hindi">
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input type="checkbox" class="multi-check" name="check[<?= $i; ?>]" <?= $ansobj['isCorrect']?'checked':''; ?> <?= ($question['question_type']=='multi-select')?'':'disabled'; ?>>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-english" name="answer_en[<?= $i; ?>]" value="<?= $ansobj['answer_text_en']; ?>" placeholder="Enter correct answer text in english" >
                                </div>
                              </div>
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-translate-option">
                                      <i class="fa fa-language"></i>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-hindi" name="answer_hi[<?= $i; ?>]" value="<?= $ansobj['answer_text_hi']; ?>" placeholder="Enter answer text in hindi">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-remove-option">
                                      <i class="fa fa-times"></i>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                                } $i++;
                              }
                            } else {
                          ?>
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input type="checkbox" class="multi-check" name="check[0]" checked>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-english" name="answer_en[0]" placeholder="Enter correct answer text in english" >
                                </div>
                              </div>
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-translate-option">
                                      <i class="fa fa-language"></i>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-hindi" name="answer_hi[0]" placeholder="Enter answer text in hindi">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input type="checkbox" class="multi-check" name="check[1]" disabled>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-english" name="answer_en[1]" placeholder="Enter answer text in english">
                                </div>
                              </div>
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-translate-option">
                                      <i class="fa fa-language"></i>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-hindi" name="answer_hi[1]" placeholder="Enter answer text in hindi">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-remove-option">
                                      <i class="fa fa-times"></i>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input type="checkbox" class="multi-check" name="check[2]" disabled>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-english" name="answer_en[2]" placeholder="Enter answer text in english">
                                </div>
                              </div>
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text btn-translate-option">
                                      <i class="fa fa-language"></i>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-hindi" name="answer_hi[2]" placeholder="Enter answer text in hindi">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-remove-option">
                                      <i class="fa fa-times"></i>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input type="checkbox" class="multi-check" name="check[3]" disabled>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-english" name="answer_en[3]" placeholder="Enter answer text in english">
                                </div>
                              </div>
                              <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-translate-option">
                                      <i class="fa fa-language"></i>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control ans-opt-hindi" name="answer_hi[3]" placeholder="Enter answer text in hindi">
                                  <div class="input-group-append">
                                    <div class="input-group-text btn-remove-option">
                                      <i class="fa fa-times"></i>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer clearfix">
                      <div class="float-right">
                        <button class="btn btn-default bg-white" id="btn-translate">TRANSLATE</button>
                        <button type="submit" class="btn btn-default bg-white" id="addNewOption"><i class="fas fa-plus"></i> NEW OPTION</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> SAVE</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <?php if (isset($question) && $question['question_img']) { ?>
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Question Image</h3>
                    </div>
                    <div class="card-body p-0">
                      <img src="<?= base_url('assets/img/'.$question['question_img']); ?>" class="img-fluid">
                      <button class="btn btn-outline-danger btn-remove-img  btn-block" data-qid="<?= $question['question_id']; ?>">Remove Image</button>
                    </div>
                  </div>
                </div>
              <?php } ?>
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

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
          $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
          });

          $('.select2').select2();
          
          let counter = <?= $i??4; ?>;
          $(document).on('click', '#addNewOption', function(event) {
            event.preventDefault();
            $("#options-sec").append(`
              <div class="col-md-12">
                <div class="row">
                  <div class="col">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input type="checkbox" class="multi-check" name="check[${counter}]">
                        </div>
                      </div>
                      <input type="text" class="form-control ans-opt-english" name="answer_en[${counter}]" placeholder="Enter answer text in english">
                    </div>
                  </div>
                  <div class="col">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text btn-translate-option">
                          <i class="fa fa-language"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control ans-opt-hindi" name="answer_hi[${counter}]" placeholder="Enter answer text in hindi">
                      <div class="input-group-append">
                        <div class="input-group-text btn-remove-option">
                          <i class="fa fa-times"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `);

            if ($("#mcq_type").is(':checked')) {
              $(".multi-check").removeAttr('disabled');
            } else {
              $(".multi-check:not(:first)").attr('disabled', true);
            }
            counter +=1;
          });     

          $(document).on('click', '.btn-remove-option', function(event) {
            event.preventDefault();
            $(this).closest('.col-md-12').remove();
          });
          <?php if(isset($answers) && count($answers) > 0){ ?>
            $('.answer-section').show();
          <?php } else { ?>
            $('.answer-section').hide();
          <?php } ?>
          if ($('#add-options').is(':checked')) {
            $('#mcq_type').attr('disabled', false);
          }
          $('#add-options').on('change', function () {
            $('.answer-section').toggle();
            let checked = $(this).is(':checked');
            $('#mcq_type').attr('disabled', !checked);
          });

          $(document).on('change', '#mcq_type', function () {
            if ($(this).is(':checked')) {
              $(".multi-check").removeAttr('disabled');
            } else {
              $(".multi-check:not(:first)").attr('disabled', true);
            }
          });

          $("#btn-translate").on('click', function(event) {
            event.preventDefault();
            const _enQue = $('[name="question_en"]').val();
            const postData = {
              source_language: "en",
              target_language: "hi",
              text: _enQue
            };
            translate(postData)
            .then(function(text) {
                $('[name="question_hi"]').val(text);
            })
            .catch(function(error) {
                console.error(error);
            });
            $(".btn-translate-option").trigger('click');
          });

          $(".btn-remove-img").on('click', function(event) {
            event.preventDefault();
            let _obj = $(this);
            let _qid = _obj.data('qid');
            $.ajax({
                type: "POST",
                url: "<?= base_url('question-bank/remove-question-image'); ?>",
                data: { 'question_id': _qid },
                success: function(response) {
                    console.log(response);
                    let parsedData = JSON.parse(response);
                    if (parsedData.status == "SUCCESS") {
                      _obj.closest('.col-md-3').remove();
                    }
                }
            });
          });

          $(".btn-translate-option").on('click', function(event) {
            event.preventDefault();
            var _obj = $(this);
            const _enAnswers = _obj.closest('.row').find('.ans-opt-english');
            const translatedAnswers = [];
            _enAnswers.each(function(index, element) {
                const _enAns = $(element).val();
                const postData = {
                    source_language: "en",
                    target_language: "hi",
                    text: _enAns
                };

                translate(postData)
                  .then(function(text) {
                      translatedAnswers.push(text);
                      if (translatedAnswers.length === _enAnswers.length) {
                          _obj.closest('.row').find('.ans-opt-hindi').each(function(index, answerHiField) {
                              $(answerHiField).val(translatedAnswers[index]);
                          });
                      }
                  })
                  .catch(function(error) {
                      console.error(error);
                  });
            });
          });

          function translate(argument) {
              return new Promise(function(resolve, reject) {
                  $.ajax({
                      type: "POST",
                      url: "<?= base_url('translator'); ?>",
                      data: argument,
                      success: function(response) {
                          console.log(response);
                          let parsedData = JSON.parse(response);
                          if (parsedData.status == "SUCCESS") {
                              resolve(parsedData.translated_text);
                          } else {
                              reject("Translation failed");
                          }
                      },
                      error: function(xhr, status, error) {
                          reject("AJAX request failed: " + error);
                      }
                  });
              });
          }
      });
    </script>
  </body>
</html>
