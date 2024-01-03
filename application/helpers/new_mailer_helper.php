<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sendMailViaApi($config_arr=[]){
    $curl = curl_init();
    $arr = array(
        CURLOPT_URL => $config_arr['api_url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{
            "from": { "address": "' . $config_arr['sender_address'] . '" },
            "to": [{"email_address": {"address": "' . $config_arr['to_address'] . '", "name": "'. $config_arr['to_name'] .'"}}],
            "subject":"'.$config_arr['subject'].'",
            "htmlbody":"'.$config_arr['body'].'",
        }',
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: " . $config_arr['api_key'],
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    );
    curl_setopt_array($curl, $arr);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        if ($response) {
            return '{"status":"success"}';
        } else {
            return '{"status":"failed", "error_body": '.$response.'}';
        }
    }
    
}

function sendMailViaSMTP($config_arr=[]){
    $ci =& get_instance();
    $ci->load->library('email');
    $email_config = Array(    
        'protocol'  => 'sendmail',
        'smtp_host' => 'ssl://'.$config_arr['out_smtp'],
        'smtp_port' => $config_arr['smtp_port'],
        'smtp_user' => $config_arr['smtp_email'],
        'smtp_pass' => $config_arr['smtp_pass'],
        'mailtype'  => 'html',
        'charset'   => 'utf-8'
    );
    $ci->email->initialize($email_config);
    $ci->email->set_mailtype("html");
    $ci->email->set_newline("\r\n");
    $ci->email->to($config_arr['email']);
    $ci->email->from($email_config['smtp_user'], $config_arr['app_name'] .' Support');
    $ci->email->subject($config_arr['subject']);
    $ci->email->message($config_arr['body']);

    $email_response = $ci->email->send();
    
    if ($email_response) {
        return '{"status":"success"}';
    } else {
        return '{"status":"failed", "error_body": '.htmlspecialchars($this->email->print_debugger()).'}';
    }
    
    
}


function testApiMail($config_arr=[]) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.zeptomail.in/v1.1/email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{
            "from": { "address": "'. $config_arr['sender_address'] . '"},
            "to": [{"email_address": {"address": "' . $config_arr['to_address'] . '","name": "'. $config_arr['to_name'] .'"}}],
            "subject":"'.$config_arr['subject'].'",
            "htmlbody":"
            <div>
    <table align=\'center\' width=\'600\' cellspacing=\'0\' cellpadding=\'0\' border=\'0\'>
        <tr>
            <td>
                <div style=\'width: 100%;padding: 40px;\'>
                    <div style=\'text-align: center;\'><span style=\'font-size: 1rem;\'>Hello</span><span
                            style=\'color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;\'>Sagar</span><span
                            style=\'color: rgb(52, 58, 64); font-size: 1rem; font-weight: bolder;\'>,</span></div>
                    <p><span style=\'font-size: 1rem; color: rgb(52, 58, 64);\'><br></span></p>
                    <div style=\'text-align: center;\'>Here\'s your link to login page.</div>
                    <div style=\'text-align: center;\'>Just click on the link below<br><span
                            style=\'caret-color: rgb(52, 58, 64); color: rgb(52, 58, 64); text-align: left;\'>https://www.simrangroups.com/candidate-login</span><br>
                    </div>
                    <p></p>
                    <p><span style=\'font-size: 1rem; color: rgb(52, 58, 64);\'></span></p>
                    <p style=\'text-align: center;\'><span style=\'font-weight: bolder; color: rgb(52, 58, 64);\'>Simran
                            Group</span><span style=\'color: rgb(52, 58, 64);\'>All Rights Reserved</span></p>
                </div>
            </td>
        </tr>
    </table>
</div>",
        }',
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Zoho-enczapikey PHtE6r0FRuzr2TZ+pkVT5vHpF5H1Pdh9qO1iJVMVs4dHXKVWS00H+I9/xD62qhosUaFDHPaTyoM85bufur7WJG/oN2ZPDmqyqK3sx/VYSPOZsbq6x00ft1QccUzVVoDpdtJu1yfUu9/TNA==",
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    ));

    // return $config_arr['body'];

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }

}