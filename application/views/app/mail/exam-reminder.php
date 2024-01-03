<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table align="center" width="600" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="background-color: #f8f8f8; padding: 20px; text-align: center;">
                <h1>Exam Reminder!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p>Dear  <?= $firstname; ?>,</p>
                <p>You have an exam named <b>"<?= $exam_name; ?>"</b> scheduled on <?= $exam_date; ?> at <?= $exam_time ?>. Please be available 5 mins earlier to the exam time.</p>
                <p>Use this link to login to your dashboard and start the exam on scheduled time.</p>
                <div style="text-align: center;">
                    <a href="<?= base_url('candidate-login'); ?>">Login to your Dashboard</a>
                    <br>
                    <p>Or scan this QR to see login page</p>
                    <br>
                    <img src="<?= base_url('assets/admin/img/qrcodes/candidate-login.png'); ?>" width="50%">
                </div>
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
