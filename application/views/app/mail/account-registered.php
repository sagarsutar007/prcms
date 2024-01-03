<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome <?= $firstname; ?></title>
</head>
<body>
    <table align="center" width="600" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="background-color: #f8f8f8; padding: 20px; text-align: center;">
                <h1>Welcome <?= $firstname; ?>!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p>Dear  <?= $firstname; ?>,</p>
                <p>Your account has been registered successfully. You can now log in and start using our services. Please note that if you have not created this account by yourself then it might be possible that we did it for you. <br> In that case your password will be first two letters of your firstname all in small case following @12345 at the end.</p>
                <p>E.g. if your name is Sagar Kumar Sutar then your password is: <br> <b>sa@12345</b></p>
                <p>Thank you for choosing us. We look forward to serving you.</p>
                <p>If you have any questions or need assistance, please feel free to contact our support team.</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f8f8f8; padding: 20px; text-align: center;">
                <p>Visit our website: <a href="<?= base_url(); ?>">Click Here!</a></p>
            </td>
        </tr>
    </table>
</body>
</html>
