<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Candidate Profile Photo | <?= (!empty($app_info['app_name']))?$app_info['app_name']:''; ?></title>
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
				<div class="col-6 mx-auto">
					<div class="cover-container container-fluid">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="userid" value="<?= $candidate['id']; ?>">
                        <div class="row">
                            <div class="col m-5">
                                <h3 class="text-center">One last Step!</h3>
                                <p class="text-secondary text-center">Please upload your passport size photograph</p>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-8 bg-white px-4 py-3 mx-auto">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="profile_img" class="custom-file-input" id="pp-pic">
                                        <label class="custom-file-label" for="pp-pic">Upload Passport Photo</label>
                                    </div>
                                </div>
                                <?= form_error('profile_img', '<div class="text-danger">', '</div>'); ?>                     
                            </div>
						</div>
                        <?php if($this->session->flashdata('error')){ ?>
                        <div class="row">
                          <div class="col-12 mtb-3 text-danger">
                            <strong>Error!</strong> <?= $this->session->flashdata('error'); ?>
                          </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6 text-center mx-auto mb-3">
                                <button class="btn btn-sm btn-primary px-4">Upload & Proceed</button>
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