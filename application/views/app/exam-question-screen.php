<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $exam_info['name']; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
	<!-- Select 2 -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2/css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"/>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
    <style>
    	#countdown {
			margin-left: 5px;
			font-size: 20px;
			font-weight: bold;
		}

		.fa-stopwatch-20 {
			font-size: 20px;
		}

		.form-options {
			background-color: #f7f7f7;
			padding: 10px;
			border-radius: 10px;
			display: flex;
			align-items: center;
		}

		.form-options:hover {
			box-shadow: 0px 0px 3px #b0b0b0;
		}

		.form-options label {
			font-weight: 400!important;
			margin-bottom: 0px;
			margin-left: 15px;
		}

		.ans-section {
			position: relative;
			height: 300px;
			overflow: auto;
		}

		body {
            user-select: none; 
        }
    </style>
  </head>
<body class="control-sidebar-slide-open sidebar-collapse layout-footer-fixed">
	<div class="wrapper">
		<nav class="main-header navbar fixed-top navbar-expand-lg navbar-light navbar-white">
			<div class="container">
				<a href="#" class="navbar-brand">
					<?php if (!empty($company['company_logo']) && file_exists('assets/img/companies/' . $company['company_logo'])) { ?>
						<img src="<?= base_url('assets/img/companies/' . $company['company_logo']); ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; height: 30px;">
					<?php } ?>
					<span class="brand-text font-weight-bold"><?= $company['company_name']; ?></span>
				</a>
							
				<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
					<li class="nav-item dropdown">
						<?php if ($exam_info['lang'] == 'hindi') { ?>
						<a id="lang-dd" href="#" data-toggle="dropdown" class="nav-link dropdown-toggle">
							<i class="fas fa-globe-europe"></i> <span id="lang">Hindi</span>
						</a>
						<?php } else { ?>
						<a id="lang-dd" href="#" data-toggle="dropdown" class="nav-link dropdown-toggle">
							<i class="fas fa-globe-europe"></i> <span id="lang">English</span>
						</a>
						<?php } ?>
						<?php if ($exam_info['lang'] == 'both') { ?>
						<ul aria-labelledby="lang-dd" class="dropdown-menu border-0 shadow">
							<li><a href="#" class="dropdown-item change-lang lang-eng"> English </a></li>
							<li><a href="#" class="dropdown-item change-lang lang-hin"> Hindi </a></li>
						</ul>
						<?php } ?>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">
							<i class="fas fa-stopwatch-20"></i>
							<span id="countdown"></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="content-wrapper mt-5">
			<div class="content-header">
				<div class="container">
					<div class="row">
						<div class="col-sm-10">
							<h1><?= $exam_info['name']; ?></h1>
							<p class="text-muted"><?= date('jS F Y'); ?></p>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<!-- <label class="font-weight-regular" for="jumpToQuestion">Jump to question</label> -->
								<select id="select2" style="width: 100%;">
									<option></option>
									<?php 
										foreach ($questions as $question => $que) {
											echo '<option value="'.$que['qno'].'">'.$que['qno'] . '-' . strtoupper($que['question_type']).'</option>';
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content">
				<div class="container">
					<div class="row">
						<div class="col-lg-6" id="column1">
							<div class="card card-primary card-outline">
								<div class="card-body">
									<div class="eng-question">
										<h5 class="card-title font-weight-bold">English Question</h5>
									</div>
									<div class="hin-question" style="display: none;">
										<h5 class="card-title font-weight-bold">Hindi Question</h5>
									</div>
									<div id="question-img">

									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6" id="column2">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h5 class="card-title m-0 choose-ans-label">
										Choose the correct answer below:
									</h5>
								</div>
								<div class="card-body ans-section" data-simplebar>
									<div class="eng-answers">

									</div>
									<div class="hin-answers"  style="display: none;">

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-12 col-md-2">
							<button class="btn btn-primary btn-load-prev btn-block mb-3">
								<i class="fas fa-arrow-left"></i> <span id="pq-btn">Previous Question</span>
							</button>
						</div>
						<div class="col-12 col-md-8"></div>
						<div class="col-12 col-md-2 text-right">
							<button class="btn btn-primary btn-load-next btn-block mb-3">
								<span id="nq-btn">Next Question</span> <i class="fas fa-arrow-right"></i>
							</button>
							<a href="<?= base_url('exams/'. $exam_info['id'] .'/view-result'); ?>" onclick="return confirm('This will complete your exam and take you to the result page?');" class="btn btn-primary btn-submit-exam btn-block mb-3" style="display:none;">
								<span id="fe-btn">Finish Exam</span> <i class="fas fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('app/includes/footer'); ?>
	</div>
	<script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- Select 2 -->
    <script src="<?= base_url('assets/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>
	<!-- Simplebar -->
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>

    <script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
    <script>
      $(document).ready(function() {
		  		const examQuestions = <?= json_encode($queIds); ?>;
		      const examStartTime = new Date('<?= $exam_info['exam_datetime']; ?>').getTime();
		      const examDuration = <?= $exam_info['duration']; ?> * 60;
		      const timerElement = document.getElementById('countdown');
					const _questionsArr = <?= json_encode($questions); ?>;
					let arrIndex = 0;
					var serverTime = <?= $now = time() * 1000; ?>;
					
					function updateTimer() {
						serverTime += 1000;
		        var now = serverTime; 
						const timeRemaining = examStartTime + examDuration * 1000 - now;
						if (timeRemaining < 0) {
							timerElement.innerText = 'Time is up!';
							window.location.href = "<?= base_url('exams/'. $exam_info['id'] .'/view-result'); ?>";
						} else {
							const minutes = Math.floor(timeRemaining / (1000 * 60));
							const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
							timerElement.innerText = minutes + 'm ' + seconds + 's';
						}
					}
	        updateTimer();
	        setInterval(updateTimer, 1000);

			function setSameHeight() {
				var height1 = $('#column1 .card').height();
				var height2 = $('#column2 .card').height();
				if (height1 > height2) {
					$('#column2 .card').height(height1);
				} else {
					$('#column1 .card').height(height2);
				}
			}
			
			$(document).on('click', '.change-lang', function(e){
				e.preventDefault();
				_obj = $(this);
				$('#select2').select2('destroy');
				if (_obj.hasClass('lang-eng')) {
					$("#lang").text('English');
					$(".choose-ans-label").text("Choose the correct answer below:");
					$(".eng-question, .eng-answers").show();
					$(".hin-question, .hin-answers").hide();
					$("#pq-btn").text('Previous Question');
					$("#nq-btn").text('Next Question');
					$("#fe-btn").text('Finish Exam');
					$('#select2').select2({
						theme: 'bootstrap4',
						placeholder: "Jump to Question",
					});
				} else {
					$("#lang").text('Hindi');
					$(".choose-ans-label").text("नीचे सही उत्तर चुनें:");
					$(".eng-question, .eng-answers").hide();
					$(".hin-question, .hin-answers").show();
					$("#pq-btn").text('पिछला सवाल');
					$("#nq-btn").text('अगला सवाल');
					$("#fe-btn").text('परीक्षा समाप्त करें');
					$('#select2').select2({
						theme: 'bootstrap4',
						placeholder: "प्रश्न पर जाएं",
					});
				}
				setSameHeight();
			});

			function loadQuestion(index){
				const question = _questionsArr[index];
				$(".eng-question h5").text(question['qno'] + ". " + question['question_en']);
				$(".hin-question h5").text(question['qno'] + ". " + question['question_hi']);
				$('.btn-load-next').show();
				$('.btn-load-prev').show();
				if(arrIndex == 0){ 
					$('.btn-load-prev').hide(); 
				} else if(arrIndex == _questionsArr.length - 1 ){ 
					$('.btn-load-next').hide(); 
					$('.btn-submit-exam').show(); 
				} else {
					$('.btn-load-next').show(); 
					$('.btn-submit-exam').hide(); 
				}

				if (question['question_img'] != null){
					$("#question-img").empty().append(`
						<img src="${question['question_img']}" class="img-fluid" alt="">
					`);
				} else {
					$("#question-img").empty();
				}

				if (question['question_type'] == 'text') {
					$(".ans-section").empty().append(`
						<textarea class="form-control" name="answerId" rows="10">${question['answers']}</textarea>
					`);
				} else if (question['question_type'] == 'mcq') {
					let engOptions = ``;
					let hinOptions = ``;
					$(_questionsArr[index]['answers']).each(function (index, val) {
						var optionLetter = String.fromCharCode('A'.charCodeAt(0) + index);
						var checked = '';
						if (val.checked != undefined && val.checked == true) {
							checked = 'checked';
						}

						engOptions +=  `
							<div class="form-group form-options">
								<input type="radio" id="eng-ans-${val.id}" name="answeren" value="${val.id}" ${checked}>
								<label for="eng-ans-${val.id}">${optionLetter}. ${val.answer_text_en}</label>
							</div>
						`;
						if (val.answer_text_hi !="") {
							hinOptions +=  `
								<div class="form-group form-options">
									<input type="radio" id="hin-ans-${val.id}" name="answerhi" value="${val.id}" ${checked}>
									<label for="hin-ans-${val.id}">${optionLetter}. ${val.answer_text_hi}</label>
								</div>
							`;	
						}		
					});
					
					$(".ans-section")
						.empty()
						.append(`
							<div class="eng-answers">
								${engOptions}
							</div>
							<div class="hin-answers">
								${hinOptions}
							</div>
						`);
					$('input:checked').trigger('change');
				} else {
					let engOptions = ``;
					let hinOptions = ``;
					$(_questionsArr[index]['answers']).each(function (index, val) {
						var optionLetter = String.fromCharCode('A'.charCodeAt(0) + index);
						var checked = '';
						if (val.checked != undefined && val.checked == true) {
							checked = 'checked';
						}
						engOptions +=  `
							<div class="form-group form-options">
								<input type="checkbox" id="eng-ans-${val.id}" name="answeren[]" value="${val.id}" ${checked}>
								<label for="eng-ans-${val.id}">${optionLetter}. ${val.answer_text_en}</label>
							</div>
						`;
						if (val.answer_text_hi !="") {
							hinOptions +=  `
								<div class="form-group form-options">
									<input type="checkbox" id="hin-ans-${val.id}" name="answerhi[]" value="${val.id}" ${checked}>
									<label for="hin-ans-${val.id}">${optionLetter}. ${val.answer_text_hi}</label>
								</div>
							`;	
						}		
					});
					
					$(".ans-section")
						.empty()
						.append(`
							<div class="eng-answers">
								${engOptions}
							</div>
							<div class="hin-answers">
								${hinOptions}
							</div>
						`);

					$('input:checked').trigger('change');
				}

				if ($('#lang').text() === "English"){
					$(".eng-answers").show();
					$(".hin-answers").hide();
				} else {
					$(".eng-answers").hide();
					$(".hin-answers").show();
				}

				setSameHeight();
				new SimpleBar($('.ans-section')[0]);
				
			}

			loadQuestion(arrIndex);
			$('#select2').select2({
				theme: 'bootstrap4',
				placeholder: "Jump to Question",
			});

			$('#select2').on('change', function (e) {
				var selectedValue= $(this).val();
				arrIndex = selectedValue - 1;
				loadQuestion(selectedValue - 1);
				$('input:checked').trigger('click').trigger('change');
			});

			$(document).on('click', '.btn-load-prev', function(event) {
				event.preventDefault();
				arrIndex -= 1;
				loadQuestion(arrIndex);
				$('input:checked').trigger('click').trigger('change');
			});

			$(document).on('click', '.btn-load-next', function(event) {
				event.preventDefault();
				arrIndex += 1;
				loadQuestion(arrIndex);
			});

			$(document).on('change','input[type="radio"]', function(){
				if($(this).is(':checked')){
					const ansVal = $(this).val();
					const question = _questionsArr[arrIndex];
					$.each(question['answers'], function (ind, obj) { 
						if (ansVal == obj.id) {
							_questionsArr[arrIndex]['answers'][ind]['checked'] = true;
						} else {
							_questionsArr[arrIndex]['answers'][ind]['checked'] = false;
						}
					});
					submitAnswer(question['question_id'], ansVal);
				}
			});

			$(document).on('change','input[type="checkbox"]', function(){
				var checkedStat = $(this).is(':checked')
				const ansVal = $(this).val();
				const question = _questionsArr[arrIndex];
				$.each(question['answers'], function (ind, obj) { 
					if (ansVal == obj.id) {
						_questionsArr[arrIndex]['answers'][ind]['checked'] = checkedStat;
					} else {
						_questionsArr[arrIndex]['answers'][ind]['checked'] = false;
					}
				});
				submitAnswer(question['question_id'], ansVal);
			});

			$(document).on('blur','textarea', function(){
				const ansVal = $(this).val();
				const question = _questionsArr[arrIndex];
				_questionsArr[arrIndex]['answers'] = ansVal;
				submitAnswer(question['question_id'], ansVal);
			});

			function submitAnswer(que_id, ans_id){
				let answer_id = ans_id;
				let examId = <?= $exam_info['id']; ?>;
				let currentQuestionId = que_id;
				$.ajax({
			        url: '<?= base_url('exams/submitAnswer'); ?>',
			        method: 'POST',
			        data: {
									"answerId" : answer_id,
									"examId" : examId,
									"currentQuestionId" : currentQuestionId,
							},
			    success: function(response) {
						const parsedResponse = JSON.parse(response);
						if (parsedResponse.status == 'SUCCESS') {

						}
			    }
				});
			}
	    });

			// document.addEventListener("visibilitychange", function() {
			//   if (document.visibilityState === "hidden") {
			//     window.location.href = '<?= base_url("exams/" . $exam_info["id"] . "/view-result"); ?>';
			//   }
			// });
				window.onbeforeunload = function() {
            var confirmationMessage = "Are you sure you want to reload?";
            return confirmationMessage;
        };

        // JavaScript to prevent right-click context menu
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // JavaScript to prevent text selection
        document.addEventListener('selectstart', function (e) {
            e.preventDefault();
        });
    </script>
  </body>
</html>
	