<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Candidate Register | <?= (!empty($app_info['app_name']))?$app_info['app_name']:''; ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/signup-page.min.css'); ?>">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
						<div class="row">
							<div class="col-md-6 bg-darkblue p-5 d-none d-md-block">
								<div class="d-flex justify-content-center flex-column h-5">
									<h3 class="text-white">Activate Your <span class="text-orange">Success!</span></h3>
									<p class="text-sm text-white ff-lato">Signup with us and set up your profile to unlock new possibilities.</p>

									<div class="my-4">
										<div class="d-flex align-items-center justify-content-start feature-item-list">
											<i class="bi bi-buildings text-orange"></i> Reach to top employers
										</div>
										<div class="d-flex align-items-center justify-content-start feature-item-list">
											<i class="bi bi-binoculars text-orange"></i> Get selected effortlessly
										</div>
										<div class="d-flex align-items-center justify-content-start feature-item-list">
											<i class="bi bi-bookmark-star text-orange"></i> It's free and always will be
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 bg-white px-4 py-5">
								<h5 class="text-center">Get Started!</h5>
								<p class="text-center text-secondary text-sm ff-lato">Use your information to create profile</p>
								<form action="" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First name" value="<?= set_value('firstname'); ?>" autofocus>
												<?= form_error('firstname', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											    <input type="text" name="lastname" id="lastname" class="form-control" value="<?= set_value('lastname'); ?>" placeholder="Last name">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											    <input type="email" name="email" id="email" class="form-control" placeholder="Email address" value="<?= set_value('email'); ?>">
												<?= form_error('email', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group mb-0">
											    <input type="phone" maxlength="10" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?= set_value('phone'); ?>">
												<?= form_error('phone', '<div class="text-danger">', '</div>'); ?>
											</div>
											<div class="form-group">
												<input type="checkbox" name="same_wa_num" value="1" id="samewanum">
												<label for="samewanum" class="text-sm">Same is my WhatsApp number</label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<select name="highest_qualification" class="custom-select d-block w-100" title="Select highest qualification">
													<option value="" <?= set_select('highest_qualification', '', TRUE); ?> hidden>Select Qualification</option>
													<option value="10th Pass" <?= set_select('highest_qualification', '10th Pass'); ?>>10th Pass</option>
													<option value="12th pass" <?= set_select('highest_qualification', '12th pass'); ?> >12th pass</option>
													<option value="10th + ITI" <?= set_select('highest_qualification', '10th + ITI'); ?> >10th + ITI</option>
													<option value="12+ ITI" <?= set_select('highest_qualification', '12+ ITI'); ?> >12+ ITI</option>
													<option value="B.A" <?= set_select('highest_qualification', 'B.A'); ?> >B.A</option>
													<option value="B.COM" <?= set_select('highest_qualification', 'B.COM'); ?> >B.COM</option>
													<option value="BBA" <?= set_select('highest_qualification', 'BBA'); ?> >BBA</option>
													<option value="BCA" <?= set_select('highest_qualification', 'BCA'); ?> >BCA</option>
													<option value="B.SC" <?= set_select('highest_qualification', 'B.SC'); ?> >B.SC</option>
													<option value="B.TECH" <?= set_select('highest_qualification', 'B.TECH'); ?> >B.TECH</option>
													<option value="MBA" <?= set_select('highest_qualification', 'MBA'); ?> >MBA</option>
													<option value="MCA" <?= set_select('highest_qualification', 'MCA'); ?> >MCA</option>
													<option value="M.A" <?= set_select('highest_qualification', 'M.A'); ?> >M.A</option>
													<option value="M.COM" <?= set_select('highest_qualification', 'M.COM'); ?> >M.COM</option>
													<option value="Any Graduation" <?= set_select('highest_qualification', 'Any Graduation'); ?> >Any Graduation</option>
													<option value="Diploma" <?= set_select('highest_qualification', 'Diploma'); ?> >Diploma</option>
												</select>
												<?= form_error('highest_qualification', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php if (isset($_GET['com_id'])) { ?>
												<select name="company_id" class="custom-select d-block w-100">
													<?php 
														foreach ($business_units as $key => $obj) { 
															if ($obj['id'] == $_GET['com_id']) {
																echo '<option value="'.$obj['id'].'" '. set_select("company_id", $obj['id']) . '>'.$obj['company_name'].'</option>';
															} 
														} 
													?>
												</select>
												<?php } else { ?>
												<select name="company_id" class="custom-select d-block w-100">
													<option value="" hidden>Select Business Unit</option>
													<?php foreach ($business_units as $key => $obj) { ?>
														<option value="<?= $obj['id']; ?>" <?= set_select("company_id", $obj['id'] ); ?>><?= $obj['company_name']; ?></option>
													<?php } ?>
												</select>
												<?= form_error('company_id', '<div class="text-danger">', '</div>'); ?>
												<?php } ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
											    <select name="gender" id="gender" class="custom-select d-block w-100">
													<option value="" <?= set_select("gender", '' ); ?> hidden>Select Gender</option>
											    	<option value="male" <?= set_select("gender", 'male' ); ?> >Male</option>
											    	<option value="female" <?= set_select("gender", 'female' ); ?>>Female</option>
											    	<option value="transgender" <?= set_select("gender", 'other' ); ?>>Transgender</option>
											    </select>
												<?= form_error('gender', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>
										<div class="col-md-8">
											<div class="custom-file mb-3">
											    <input type="file" name="profile_img" class="custom-file-input" id="profile">
											    <label class="custom-file-label" for="profile">Passport Size Photo</label>
											    <?= form_error('profile_img', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input name="dob" id="datepicker" class="form-control" type="text" placeholder="Date of Birth" autocomplete="off" value="<?= set_value('dob'); ?>">
												<?= form_error('dob', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input name="empid" id="empid" class="form-control" type="text" placeholder="Employee Id">
												<?= form_error('empid', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
					                            <div class="input-group mb-3">
					                                <input type="password" id="password"  class="form-control" name="password" value="" placeholder="Enter password" maxlength="12">
					                                <div class="input-group-append">
					                                  <span class="input-group-text toggle-password bg-white"><i class="fa fa-eye-slash"></i></span>
					                                </div>
					                                <?= form_error('password', '<div class="text-danger">', '</div>'); ?>
					                            </div>
					                        </div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<div class="input-group mb-3">
					                                <input type="password" id="passconf"  class="form-control" name="passconf" value="" placeholder="Confirm password" maxlength="12">
					                                <div class="input-group-append">
					                                  <span class="input-group-text toggle-confirm-password bg-white"><i class="fa fa-eye-slash"></i></span>
					                                </div>
					                                <?= form_error('passconf', '<div class="text-danger">', '</div>'); ?>
					                            </div>
											</div>
										</div>
										<div class="col-md-12 text-right">
											<button class="btn btn-sm btn-primary">Register Me</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
    $(document).ready(function() {
        var maxDate = new Date();
        maxDate.setFullYear(maxDate.getFullYear() - 17);

        $('#datepicker').datepicker({
            maxDate: maxDate,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });

        $(".btn-primary").on('click', function () {
        	$(this).empty().html(`
        		<button class="btn btn-primary btn-sm" type="button" disabled>
				  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
				  <span class="sr-only">Loading...</span>
				</button>
        	`);
        });

        $('.toggle-password').click(function () {
            var passwordInput = $('#password');
            var icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
              passwordInput.attr('type', 'text');
              icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
              passwordInput.attr('type', 'password');
              icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });

        $('.toggle-confirm-password').click(function () {
            var passwordInput = $('#passconf');
            var icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
              passwordInput.attr('type', 'text');
              icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
              passwordInput.attr('type', 'password');
              icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    });
</script>
</body>
</html>