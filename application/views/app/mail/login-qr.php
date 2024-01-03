<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table align="center" width="600" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="background-color: #f8f8f8; padding: 20px; text-align: center;">
                <img src="<?= base_url('assets/img/'. $app_icon); ?>" height="50px">
                <br>
                <h2><?= $app_name; ?></h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p>Dear  <?= $firstname; ?>,</p>
                <p>Here is your login link to get into the dashboard and accessing features that are private to you.</p>
                <div style="text-align:center"><img src="<?= base_url('assets/admin/img/qrcodes/candidate-login.png'); ?>" width="50%"></div>
                <p style="text-align:center">Scan this link to land into login page. Use correct credentials to login.</p>
                <p style="text-align:center">If you have any questions or need assistance, please feel free to contact our support team.</p>
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
