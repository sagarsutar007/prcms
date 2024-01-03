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
                                    <div class="button-circle bg-primary text-white">2</div>
                                    <div class="button-circle bg-white">3</div>
                               </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-6 bg-white px-4 py-3 mx-auto">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="bank_name" placeholder="Enter Bank Name" value="<?= set_value('bank_name'); ?>">
                                    <?= form_error('bank_name', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="number" class="form-control" name="account_num" placeholder="Enter Account Number" value="<?= set_value('account_num'); ?>">
                                    <?= form_error('account_num', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="ifsc_code" placeholder="Enter IFSC Code" value="<?= set_value('ifsc_code'); ?>">
                                    <?= form_error('ifsc_code', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="passbook_pic" class="custom-file-input" id="pb-pic">
                                        <label class="custom-file-label" for="pb-pic">Upload Passbook Frontpage</label>
                                    </div>
                                </div>
                                <?= form_error('passbook_pic', '<div class="text-danger">', '</div>'); ?>
                                <div class="mb-3"></div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="chequebook_pic" class="custom-file-input" id="pb-pic">
                                        <label class="custom-file-label" for="pb-pic">Upload Cancelled Cheque</label>
                                    </div>
                                </div>
                                <?= form_error('chequebook_pic', '<div class="text-danger">', '</div>'); ?>
                            </div>
						</div>
                        <div class="row">
                            <div class="col-md-6 text-right mx-auto">
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
            $('input[type="file"]').on('change', function() {
              var fileName = $(this).val().split('\\').pop();
              $(this).siblings('.custom-file-label').text(fileName);
            });

            $(".btn-primary").on('click', function () {
                $(this).empty().html(`
                    <button class="btn btn-primary" type="button" disabled>
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      <span class="sr-only">Loading...</span>
                    </button>
                `);
            });
        });
    </script>
</body>
</html>