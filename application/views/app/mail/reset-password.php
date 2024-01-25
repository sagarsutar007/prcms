<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset your account password through this link!</title>
</head>
<body>
    <table align="center" width="600" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="background-color: #f8f8f8; padding: 20px; text-align: center;">
                <h1>Did you forget your Password!</h1>
                <p>Read below steps to recover your password easily.</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p>Dear  <?= $firstname; ?>,</p>
                <p>We received a request to reset your password. If you did not initiate this request, please disregard this email.</p>
                <p>To reset your password, please click on the following link:</p>
                <a href="<?= $link; ?>"><?= $link; ?></a>
                <p>Please note that this link is valid for a limited time. </p>
                <p>If you have any questions or need assistance, please contact our support team.</p>
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
