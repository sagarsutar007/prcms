<div style="background-color:#d6f4ff; padding: 20px;">
	<div style="max-width: 500px; margin: 0 auto; overflow: none; background-color: #fff; border-radius: 5px; padding: 40px;">
		<h2 style="text-align: center;">Hi <?= $name; ?>,</h2>
		<p style="margin: 15px 0px;text-align: center;">Your account is now active on <?= $company_name; ?> panel. Use the following link to complete your Sign Up procedures. Please use the given credentials to get into dashboard.</p>
		<div>
			<p><span>Link: </span><a href="<?= base_url('candidate-login'); ?>" target="_blank">Login Link</a></p>
			<p><span>Email: </span><?= $email; ?></p>
			<p><span>Password: </span><?= $password; ?></p>
		</div>
		<p style="margin: 15px 0px; text-align: center;">Please do not share this email to any one asking for these credentials as it is highly sensitive information. In case you want to change the email or password you may need to change it from account/profile settings.</p>
		<hr>
		<p style="margin: 15px 0px; text-align: center;">&copy; All Rights Reserved <?= date('Y'); ?></p>
	</div>
</div>