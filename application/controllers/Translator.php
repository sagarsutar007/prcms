<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';
use Google\Cloud\Translate\V2\TranslateClient;

class Translator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Settings_model', 'setting_model');
	}

	public function index()
	{
		if ($this->input->post()) {
			$site_data = $this->setting_model->getSiteSetting();
			$translate = new TranslateClient([
			    'key' => $site_data['translate_api_key']
			]);
			$result = $translate->translate($_POST['text'], [
			    'target' => 'hi'
			]);
			
		    $returnText['status'] = "SUCCESS";
		    $returnText['translated_text'] = $result['text'];
			
			echo json_encode($returnText);
		} else {
			$data['status'] = 'ERROR';
			$data['message'] = 'No data sent through form!';
			$data['translated_text'] = '';
			echo json_encode($data);
		}
	}

	public function index2()
	{
		if ($this->input->post()) {

			$site_data = $this->setting_model->getSiteSetting();
			$data = [
			    'q' => $_POST['text'],
			    'source' => 'en',
			    'target' => 'hi',
			];

			$postFields = http_build_query($data);

			$curl = curl_init();

			curl_setopt_array($curl, [
			    CURLOPT_URL => "https://google-translate1.p.rapidapi.com/language/translate/v2",
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_ENCODING => "",
			    CURLOPT_MAXREDIRS => 10,
			    CURLOPT_TIMEOUT => 30,
			    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			    CURLOPT_CUSTOMREQUEST => "POST",
			    CURLOPT_POSTFIELDS => $postFields,
			    CURLOPT_HTTPHEADER => [
			        "Accept-Encoding: application/gzip",
			        "X-RapidAPI-Host: google-translate1.p.rapidapi.com",
			        "X-RapidAPI-Key: ". $site_data['translate_api_key'],
			        "Content-Type: application/x-www-form-urlencoded"
			    ],
			]);

			$response = curl_exec($curl);
			$error = curl_error($curl);
			curl_close($curl);

			if ($error) {
			    $returnText['status'] = "ERROR";
			    $returnText['translated_text'] = "";
			} else {
			    $data = json_decode($response, true);
			    $translatedText = $data['data']['translations'][0]['translatedText'];
			    $returnText['status'] = "SUCCESS";
			    $returnText['translated_text'] = $translatedText;
			}
			
			echo json_encode($returnText);
		} else {
			$data['status'] = 'ERROR';
			$data['message'] = 'No data sent through form!';
			$data['translated_text'] = '';
			echo json_encode($data);
		}
	}

}

/* End of file  */
/* Location: ./application/controllers/ */