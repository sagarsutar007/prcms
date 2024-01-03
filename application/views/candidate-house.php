<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Candidate Documents | <?= (!empty($app_info['app_name']))?$app_info['app_name']:''; ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="<?= base_url('assets/css/signup-page.min.css'); ?>">
</head>
<body>
	<!-- <nav class="navbar navbar-light bg-light drop-shadow">
	  <a class="navbar-brand" href="<?= base_url(); ?>">
	  	<?php if (!empty($app_info['app_icon']) && file_exists('./assets/img/' . $app_info['app_icon'])) { ?>
	  	<img src="<?= base_url('./assets/img/' . $app_info['app_icon']); ?>" width="30" height="30" class="d-inline-block align-top" alt="">
	  	<?php } ?>
	    <?= (!empty($app_info['app_name']))?$app_info['app_name']:''; ?>
	  </a>
	</nav> -->
	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="cover-container container-fluid">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="d-flex align-items-center justify-content-between" style="width: 300px; margin: 20px auto;">
                                    <div class="button-circle bg-success text-white">1</div>
                                    <div class="button-circle bg-success text-white">2</div>
                                    <div class="button-circle bg-primary text-white">3</div>
                               </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-6 bg-white px-4 py-3 mx-auto">
                                <?php if (empty($candidate['whatsapp_number'])) { ?>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="whatsapp_number" placeholder="Enter WhatsApp" value="<?= set_value('whatsapp_number')??$candidate['whatsapp_number']; ?>">
                                    <?= form_error('whatsapp_number', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="father_name" placeholder="Enter Father Name" value="<?= set_value('father_name')??$candidate['father_name']; ?>">
                                    <?= form_error('father_name', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <div class="form-group">
                                    <select name="marital_status" class="custom-select d-block w-100">
                                        <option value="" hidden>Select Marital Status</option>
                                        <?php
                                            if (isset($candidate['father_name']) && !empty($candidate['father_name'])) {
                                                echo "<option value='".$candidate['father_name']."' hidden selected>'" . ucfirst($candidate['father_name']) ."'</option>";
                                            }
                                        ?>
                                        <option value="married">Married</option>
                                        <option value="unmarried">Unmarried</option>
                                        <option value="divorced">Divorced</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" maxlength="12" class="form-control" name="aadhaar_number" placeholder="Enter 12 digit Aadhaar Number" value="<?= set_value('aadhaar_number')??$candidate['aadhaar_number']; ?>">
                                    <?= form_error('aadhaar_number', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="aadhaar_card_front_pic" class="custom-file-input" id="pb-pic">
                                        <label class="custom-file-label" for="pb-pic">Upload Aadhaar Front Photo</label>
                                    </div>
                                </div>
                                <?= form_error('aadhaar_card_front_pic', '<div class="text-danger">', '</div>'); ?>
                                <div class="mb-3"></div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="aadhaar_card_back_pic" class="custom-file-input" id="pb-pic">
                                        <label class="custom-file-label" for="pb-pic">Upload Aadhaar Back Photo</label>
                                    </div>
                                </div>
                                <?= form_error('aadhaar_card_back_pic', '<div class="text-danger">', '</div>'); ?>
                                <div class="mb-3"></div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="voter_id" class="custom-file-input" id="pb-pic">
                                        <label class="custom-file-label" for="pb-pic">Upload Voter Card Photo</label>
                                    </div>
                                </div>
                                <?= form_error('voter_id', '<div class="text-danger">', '</div>'); ?>
                                <div class="mb-3"></div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="pancard_pic" class="custom-file-input" id="pb-pic">
                                        <label class="custom-file-label" for="pb-pic">Upload Pan Card Photo</label>
                                    </div>
                                </div>
                                <?= form_error('voter_id', '<div class="text-danger">', '</div>'); ?>
                                <div class="mb-3"></div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="education_proof" class="custom-file-input" id="education-proof">
                                        <label class="custom-file-label" for="education-proof">Upload Education Proof Photo</label>
                                    </div>
                                </div>
                                <?= form_error('education_proof', '<div class="text-danger">', '</div>'); ?>
                                <div class="mb-3"></div>

                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="signature" class="custom-file-input" id="signature">
                                        <label class="custom-file-label" for="signature">Upload Signature Photo</label>
                                    </div>
                                </div>
                                <?= form_error('signature', '<div class="text-danger">', '</div>'); ?>
                                <div class="mb-3"></div>
                            </div>
						</div>
                        <div class="row">
                            <div class="col-md-6 text-right mx-auto mb-3">
                                <button class="btn btn-sm btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
            });
            $(".voter-sec, .pancard-sec").hide();
            $("#doc-dd").change(function() {
                var selectedOption = $(this).val();
                $(".aadhaar-sec, .voter-sec, .pancard-sec").hide();
                if (selectedOption === "Aadhaar Card") {
                    $(".aadhaar-sec").show();
                } else if (selectedOption === "Voter Card") {
                    $(".voter-sec").show();
                } else if (selectedOption === "Pan Card") {
                    $(".pancard-sec").show();
                }
            });

            $(".btn-primary").on('click', function () {
                $(this).empty().html(`
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      <span class="sr-only">Loading...</span>
                `);
            });
        });
    </script>
</body>
</html>