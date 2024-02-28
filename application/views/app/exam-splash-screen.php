<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Start <?= $exam_info['name']; ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
	<style>
			.text-sm {
				font-size: 14px;
			}
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
<body>
	<section class="wrapper">
		<div class="overlay" id="overlay">
      <i class="fas fa-2x fa-sync-alt fa-spin"></i>
    </div>
		<div class="container">
			<div class="row">
				<div class="col-md-6 mx-auto">
					<div style="height:50px;"></div>
					<div class="card">
					  <div class="card-body">
					    <div class="text-center">
					    	<h4><?= $exam_info['name']; ?></h4>
					    	<p class="m-0 p-0 text-secondary text-sm"><?= "Duration: " . $exam_info['duration']." mins"; ?></p>
					    	<p class="m-0 p-0 text-secondary text-sm"><?= "Languages: " . ucfirst($exam_info['lang']); ?></p>
					    	<p class="text-secondary text-sm"><?= "Total Questions: " . ucfirst($exam_info['total_question']); ?></p>

					    	<h6 class="mt-5">Exam Starting in</h6>
					    	<button class="btn btn-primary btn-sm" id="btn-start-exam" disabled></button>
					    </div>
					  </div>
					</div>
					<div style="height:50px;"></div>
				</div>
			</div>
		</div>
	</section>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script>
	// $(document).ready(function () {
	//     var examStartTime = new Date('<?=$exam_info['exam_datetime'];?>').getTime();
	//     var btnStartExam = $('#btn-start-exam');
	//     function updateCountdown() {
	//         var now = new Date().getTime();
	//         // var serverTime = <?= $now = time() * 1000; ?>;
	//         var timeRemaining = examStartTime -  now;
	//         // var timeRemaining = examStartTime - serverTime + now;

	//         if (timeRemaining <= 0) {
	//             btnStartExam.text('Start Exam');
	//             btnStartExam.prop('disabled', false);
	//             clearInterval(countdownInterval);
	//         } else {
	//             var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
	//             var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
	//             btnStartExam.text(minutes + 'm ' + seconds + 's');
	//         }
	//     }
	//     updateCountdown();
	//     var countdownInterval = setInterval(updateCountdown, 1000);
	// });

	$(document).ready(function () {
      var serverTime = <?= $now = time() * 1000; ?>; // Get server time in milliseconds
	    var examStartTime = new Date('<?=$exam_info['exam_datetime'];?>').getTime();
	    var btnStartExam = $('#btn-start-exam');

	    function updateCountdown() {
	    	serverTime += 1000;
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

	    // $(document).on('click', '#btn-start-exam', function () {
      //     $('#overlay').css('display', 'flex');
      // });
	});

	function enableButtonAndNavigate() {
	    var myButton = document.getElementById('btn-start-exam');
	    var myOverlay = document.getElementById('overlay');

	    if (myButton && !myButton.hasAttribute('disabled')) {
	    		myButton.innerHTML = `
	    			<div class="spinner-border spinner-border-sm" role="status">
						  <span class="visually-hidden">Loading...</span>
						</div> Starting Exam...
	    		`;
	    		myButton.setAttribute('disabled', true);
	    		myOverlay.style.display = "flex";
	        window.location.href = "<?= base_url('exams/' . $exam_info['url'] . '/exam'); ?>";
	    }

	}
	var myButton = document.getElementById('btn-start-exam');
	myButton.addEventListener('click', enableButtonAndNavigate);

	</script>



</body>
</html>