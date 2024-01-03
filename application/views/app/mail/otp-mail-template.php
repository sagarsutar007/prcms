<div style="background-color:#d6f4ff; padding: 20px;">
	<div style="max-width: 500px; margin: 0 auto; overflow: none; background-color: #fff; border-radius: 5px; padding: 40px;">
		<h2 style="text-align: center;">Hi <?= $name; ?>,</h2>
		<p style="margin: 15px 0px;text-align: center;">This OTP is generated to update your sensitive data through your <?= $company_name; ?> panel. Use the following OTP to complete your Sign Up procedures. OTP is valid for one time use.</p>
		<div style="text-align:center;">
			<button style="border:none; display:inline-block; padding: 15px 20px; background-color: #1c96c5; color: #fff; border-radius: 5px;font-size: 20px;"><?= $otp; ?></button>
		</div>
		<p style="margin: 15px 0px; text-align: center;">Please do not share this to any one asking for these OTP as it is highly sensitive information. In case you did not initiate this operation you may need to change your password as soon as possible.</p>
		<hr>
		<p style="margin: 15px 0px; text-align: center;">&copy; All Rights Reserved <?= date('Y'); ?></p>
	</div>
</div>