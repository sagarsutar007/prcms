<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 

function sendMailViaApi($config_arr = [])
{
    $curl = curl_init();

    $payload = [
        "from" => ["address" => "support@simrangroups.com"],
        "to" => [
            ["email_address" => ["address" => $config_arr['to_address'], "name" => $config_arr['to_name']]]
        ],
        "subject" => $config_arr['subject'],
        "htmlbody" => $config_arr['body'],
    ];

    $payload = json_encode($payload);

    $options = [
        CURLOPT_URL => $config_arr['api_url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Authorization: " . $config_arr['api_key'],
            "Cache-Control: no-cache",
            "Content-Type: application/json",
        ],
    ];

    curl_setopt_array($curl, $options);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}


function sendMailViaSMTP($config_arr = []) {
    $ci =& get_instance();
    $ci->load->library('email', $config_arr);

    $ci->email->set_mailtype("html");
    $ci->email->set_newline("\r\n");
    $ci->email->to($config_arr['email']);
    $ci->email->from($config_arr['smtp_email'], $config_arr['app_name'] .' Support');
    $ci->email->subject($config_arr['subject']);
    $ci->email->message($config_arr['body']);

    $email_response = $ci->email->send();

    if ($email_response) {
        return '{"status":"success"}';
    } else {
        return '{"status":"failed", "error_body": '.htmlspecialchars($ci->email->print_debugger()).'}';
    }
}

function sendMailViaMailer($config_arr = []) {
    $mail = new PHPMailer();
    $mail->Encoding = "base64";
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.zeptomail.in";
    $mail->Port = 465;
    $mail->Username = "emailappsmtp.757594b729ac1e50";
    $mail->Password = 'GypiHjERkQsh';
    // $mail->SMTPSecure = 'TLS';
    $mail->isSMTP();
    $mail->IsHTML(true);
    $mail->CharSet = "UTF-8";
    $mail->From = "support@simrangroups.com";
    $mail->addAddress('support@simrangroups.com');
    $mail->SMTPOptions = array(
       'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    $mail->Body=$config_arr['body'];
    $mail->Subject = $config_arr['subject'];
    $mail->SMTPDebug = 1;
    $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str"; echo "<br>";};


    if(!$mail->Send()) {
        return '{"status":"failed", "error_body": "Mail sending failed!"}';
    } else {
        return '{"status":"failed", "error_body": "Mail sent successfully!"}';
    }
}


