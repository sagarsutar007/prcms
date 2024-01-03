<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Candidate Address | <?= (!empty($app_info['app_name']))?$app_info['app_name']:''; ?></title>
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
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="d-flex align-items-center justify-content-between" style="width: 300px; margin: 20px auto;">
                                    <div class="button-circle bg-primary text-white">1</div>
                                    <div class="button-circle bg-white">2</div>
                                    <div class="button-circle bg-white">3</div>
                               </div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-md-6 bg-white px-4 py-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-3">Present Address</h6>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="ca_address" value="<?= set_value('ca_address')??$candidate['ca_address']; ?>" placeholder="Enter Address">
                                    <?= form_error('ca_address', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control"  name="ca_address_landmark" value="<?= set_value('ca_address_landmark')??$candidate['ca_address_landmark']; ?>" placeholder="Enter Landmark">
                                    <?= form_error('ca_address_landmark', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="ca_city" value="<?= set_value('ca_city')??$candidate['ca_city']; ?>" placeholder="Enter City">
                                    <?= form_error('ca_city', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="ca_dist" value="<?= set_value('ca_dist')??$candidate['ca_dist']; ?>" placeholder="Enter District">
                                    <?= form_error('ca_dist', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="ca_state" class="custom-select d-block w-100">
                                                <?php 
                                                    if (isset($candidate['ca_state']) && !empty($candidate['ca_state'])) {
                                                        echo "<option value='".$candidate['ca_state']."' selected hidden>".$candidate['ca_state']."</option>";
                                                    }
                                                ?>
                                                  <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                  <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                  <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                  <option value="Assam">Assam</option>
                                                  <option value="Bihar">Bihar</option>
                                                  <option value="Chandigarh">Chandigarh</option>
                                                  <option value="Chhattisgarh">Chhattisgarh</option>
                                                  <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                                  <option value="Delhi">Delhi</option>
                                                  <option value="Goa">Goa</option>
                                                  <option value="Gujarat">Gujarat</option>
                                                  <option value="Haryana">Haryana</option>
                                                  <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                  <option value="Jharkhand">Jharkhand</option>
                                                  <option value="Karnataka">Karnataka</option>
                                                  <option value="Kerala">Kerala</option>
                                                  <option value="Lakshadweep">Lakshadweep</option>
                                                  <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                  <option value="Maharashtra">Maharashtra</option>
                                                  <option value="Manipur">Manipur</option>
                                                  <option value="Meghalaya">Meghalaya</option>
                                                  <option value="Mizoram">Mizoram</option>
                                                  <option value="Nagaland">Nagaland</option>
                                                  <option value="Odisha">Odisha</option>
                                                  <option value="Puducherry">Puducherry</option>
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
                                            <?= form_error('ca_state', '<div class="text-danger">', '</div>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" maxlength="6" name="ca_pin" value="<?= set_value('ca_pin')??$candidate['ca_pin']; ?>" placeholder="Enter Pin">
                                            <?= form_error('ca_pin', '<div class="text-danger">', '</div>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" id="same-addr">
                                            <label for="same-addr" class="text-sm">My Permanent address is same as present address</label>
                                        </div>
                                    </div>
                                </div>
							</div>
							<div class="col-md-6 bg-white px-4 py-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-3">Permanent Address</h6>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <input type="text" class="form-control" name="pa_address" value="<?= set_value('pa_address')??$candidate['pa_address']; ?>" placeholder="Enter Address">
                                    <?= form_error('pa_address', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control"  name="pa_address_landmark" value="<?= set_value('pa_address_landmark')??$candidate['pa_address_landmark']; ?>" placeholder="Enter Landmark">
                                    <?= form_error('pa_address_landmark', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="pa_city" value="<?= set_value('pa_city')??$candidate['pa_city']; ?>" placeholder="Enter City">
                                    <?= form_error('pa_city', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="pa_dist" value="<?= set_value('pa_dist')??$candidate['pa_dist']; ?>" placeholder="Enter District">
                                    <?= form_error('pa_dist', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="pa_state" class="custom-select d-block w-100">
                                                <?php 
                                                    if (isset($candidate['pa_state']) && !empty($candidate['pa_state'])) {
                                                        echo "<option value='".$candidate['pa_state']."' selected hidden>".$candidate['pa_state']."</option>";
                                                    }
                                                ?>
                                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                  <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                  <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                  <option value="Assam">Assam</option>
                                                  <option value="Bihar">Bihar</option>
                                                  <option value="Chandigarh">Chandigarh</option>
                                                  <option value="Chhattisgarh">Chhattisgarh</option>
                                                  <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                                  <option value="Delhi">Delhi</option>
                                                  <option value="Goa">Goa</option>
                                                  <option value="Gujarat">Gujarat</option>
                                                  <option value="Haryana">Haryana</option>
                                                  <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                  <option value="Jharkhand">Jharkhand</option>
                                                  <option value="Karnataka">Karnataka</option>
                                                  <option value="Kerala">Kerala</option>
                                                  <option value="Lakshadweep">Lakshadweep</option>
                                                  <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                  <option value="Maharashtra">Maharashtra</option>
                                                  <option value="Manipur">Manipur</option>
                                                  <option value="Meghalaya">Meghalaya</option>
                                                  <option value="Mizoram">Mizoram</option>
                                                  <option value="Nagaland">Nagaland</option>
                                                  <option value="Odisha">Odisha</option>
                                                  <option value="Puducherry">Puducherry</option>
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
                                            <?= form_error('pa_state', '<div class="text-danger">', '</div>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" maxlength="6" name="pa_pin" value="<?= set_value('pa_pin')??$candidate['pa_pin']; ?>" placeholder="Enter Pin">
                                            <?= form_error('pa_pin', '<div class="text-danger">', '</div>'); ?>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-sm btn-primary ">Next</button>
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
            $("#same-addr").on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="pa_address"]').val($('input[name="ca_address"]').val());
                    $('input[name="pa_address_landmark"]').val($('input[name="ca_address_landmark"]').val());
                    $('input[name="pa_city"]').val($('input[name="ca_city"]').val());
                    $('input[name="pa_dist"]').val($('input[name="ca_dist"]').val());
                    $('select[name="pa_state"]').val($('select[name="ca_state"]').val());
                    $('input[name="pa_pin"]').val($('input[name="ca_pin"]').val());
                } else {
                    $('input[name="pa_address"]').val('');
                    $('input[name="pa_address_landmark"]').val('');
                    $('input[name="pa_city"]').val('');
                    $('input[name="pa_dist"]').val('');
                    $('select[name="pa_state"]').val('');
                    $('input[name="pa_pin"]').val('');
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