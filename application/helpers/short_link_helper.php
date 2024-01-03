<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function shortenLink($url = '') {
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://smxm.in/api/shorten-link',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
      "url": "' . $url . '"
    }',
    CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}

