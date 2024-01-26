<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';
use Dompdf\Options;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Candidates extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Business_units_model', 'business_model');
		$this->load->model('Candidates_model', 'candidate_model');
		$this->load->model('Exams_model', 'exam_model');
		$this->load->model('Answers_model', 'answer_model');
		$this->load->model('Questions_model', 'question_model');
		$this->load->model('Clients_model', 'client_model');
		$this->load->model('Login_model', 'login');
		$this->load->model('Settings_model', 'setting_model');
		$this->load->model('Notification_model', 'notif_model');
	}

	public function isValidUser($value='')
	{
		if (!$this->session->has_userdata('id') && ($this->session->userdata('type') != "admin" || $this->session->userdata('type') != "business unit")) {
			redirect('logout');
		}
	}

	public function isNotCandidate($value='')
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') != "candidate") {
			redirect('logout');
		}
	}

	public function index()
	{
		$this->isValidUser();
	    $data['title'] = "Candidates";
		$this->load->view('app/candidates', $data);
	}

	public function getData() {
		$filter = [];
		if(isset($_GET['company_id']) && !empty($_GET['company_id'])) {
			$filter['company_id'] = $this->input->get('company_id');
		}
		if(isset($_GET['status']) && !empty($_GET['status'])) {
			$filter['status'] = $this->input->get('status');
		}
		$company_id = [$filter['company_id']??''];
		if ($_SESSION['type'] == "business unit" && count($company_id) == 0) {
			foreach ($_SESSION['companies'] as $compns => $comp) {
				$company_id[] = $comp['id'];
			}
		}
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value'];
		

		$order = $this->input->post('order');
	    $columnIndex = $order[0]['column'];
	    $columnName = $this->input->post('columns')[$columnIndex]['name'];
	    $columnSortOrder = $order[0]['dir'];
		$recordsTotal = $this->candidate_model->count($company_id??NULL, $filter['status']??null, $search, $columnName, $columnSortOrder);
		$data = $this->candidate_model->getData($start, $length, $search, $filter, $columnName, $columnSortOrder);
		// echo $data;exit();
		$result = array();
		$i = 1 + $start;
		foreach ($data as $record) {
			$result[] = array(
				'checkbox' => '<input type="checkbox" name="recs[]" class="check" value="' . $record['user_id'] . '">',
				'SNo' => $i,
				'CandidateName' => ucwords($record['firstname'] . " " . $record['middlename'] . " " . $record['lastname']),
				// 'FathersName' => $record['father_name'],
				'DOB' => !empty($record['dob'])?date('d-m-Y', strtotime($record['dob'])):'',
				'AadhaarNumber' => $record['aadhaar_number'],
				'Phone' => $record['phone'],
				'Email' => $record['email'],
				'Gender' => $record['gender'] ? ucfirst($record['gender']) : 'Not Available',
				'Action' => '<a href="' . base_url('candidate/view/') . $record['user_id'] . '" class="btn btn-link btn-sm p-adjust" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / <a href="' . base_url('candidate/edit/') . $record['user_id'] . '" class="btn btn-link btn-sm  p-adjust" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a> / <a href="' . base_url('candidate/delete/') . $record['user_id'] . '" onClick="return confirm(\'This candidate will be deleted and can\\\'t be recovered. Are you sure to delete?\');" class="btn btn-link btn-sm p-adjust" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fas fa-trash"></i></a> / <a href="' . base_url('candidate/print/') . $record['user_id'] . '" class="btn btn-link btn-sm p-adjust" target="_blank"  data-toggle="tooltip" data-placement="top" title="Print"><i class="fas fa-print"></i></a>'
			);
			$i++;
		}
	
		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsTotal,
			"data" => $result,
		);
	
		echo json_encode($response);
	}

	public function create()
	{
		$this->isValidUser();
		$data['title'] = "Add Candidate";
		if ($this->input->post()) {
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 2048 * 5;
	        $config['encrypt_name']  = TRUE;

	        $this->upload->initialize($config);

	        $post = $this->input->post();
	        $post['email'] = strtolower($post['email']);
	        $this->form_validation->set_rules('firstname', 'First name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[12]');
			$this->form_validation->set_rules('phone', 'Phone number', 'required|integer|exact_length[10]|is_unique[candidates.phone]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[candidates.email]');
			$this->form_validation->set_rules('aadhaar_number', 'aadhaar_number', 'required');

			if ($this->form_validation->run() == TRUE) {

				$userInfo['firstname'] = $this->input->post('firstname');
				$userInfo['middlename'] = $this->input->post('middlename');
				$userInfo['lastname'] = $this->input->post('lastname');
				$userInfo['gender'] = $this->input->post('gender');
				$userInfo['phone'] = $this->input->post('phone');
				$userInfo['email'] = $this->input->post('email');
				$userInfo['company_id'] = $this->input->post('company_id');
				$userInfo['status'] = 'active';
				$userInfo['empid'] = $this->input->post('empid');
				$userInfo['source'] = 'manual';

				if (!empty($this->input->post('password'))) {
					$userInfo['password'] = md5($this->input->post('password'));
				}

		        if (!empty($_FILES['profile_img_file'])) {
					if ($this->upload->do_upload('profile_img_file')) {
			            $image = $this->upload->data('file_name');
						$thumb = createThumbnail($image);
						if ($thumb) {
							$userInfo['profile_img'] = $thumb;
						} else {
							$userInfo['profile_img'] = $image;
						}
			        }
		        }

		        $user_id = $this->candidate_model->insert($userInfo);

		        if ($user_id) {

		        	$userDetails = [];
		        	$userDetails['user_id'] = $user_id;
		        	$userDetails['aadhaar_number'] = $post['aadhaar_number'];
		        	$userDetails['whatsapp_number'] = $post['whatsapp_number'];
		        	$userDetails['company_id'] = $post['company_id'];
		        	$userDetails['ca_address'] = $post['ca_address'];
		        	$userDetails['ca_address_landmark'] = $post['ca_address_landmark'];
		        	$userDetails['ca_city'] = $post['ca_city'];
		        	$userDetails['ca_dist'] = $post['ca_dist'];
		        	$userDetails['ca_state'] = $post['ca_state'];
		        	$userDetails['ca_pin'] = $post['ca_pin'];

		        	$userDetails['pa_address'] = $post['pa_address'];
		        	$userDetails['pa_address_landmark'] = $post['pa_address_landmark'];
		        	$userDetails['pa_city'] = $post['pa_city'];
		        	$userDetails['pa_dist'] = $post['pa_dist'];
		        	$userDetails['pa_state'] = $post['pa_state'];
		        	$userDetails['pa_pin'] = $post['pa_pin'];

		        	$userDetails['highest_qualification'] = $post['highest_qualification'];
		        	// $userDetails['passout_year'] = $post['passout_year'];
		        	// $userDetails['percentage_secured'] = $post['percentage_secured'];
		        	$userDetails['dob'] = date('Y-m-d', strtotime($post['dob']));
		        	$userDetails['father_name'] = $post['father_name'];
		        	$userDetails['bank_name'] = $post['bank_name'];
		        	$userDetails['account_num'] = $post['account_num'];
		        	$userDetails['ifsc_code'] = $post['ifsc_code'];
		        	$userDetails['marital_status'] = $post['marital_status'];

		        	if (!empty($_FILES['voter_id'])) {
						if ($this->upload->do_upload('voter_id')) {
				            $userDetails['voter_id'] = $this->upload->data('file_name');
				        }
			        }

			        if (!empty($_FILES['pancard_pic'])) {
						if ($this->upload->do_upload('pancard_pic')) {
				            $userDetails['pancard_pic'] = $this->upload->data('file_name');
				        }
			        }

			        if (!empty($_FILES['aadhaar_card_front_pic'])) {
						if ($this->upload->do_upload('aadhaar_card_front_pic')) {
				            $userDetails['aadhaar_card_front_pic'] = $this->upload->data('file_name');
				        }
			        }

			        if (!empty($_FILES['aadhaar_card_back_pic'])) {
						if ($this->upload->do_upload('aadhaar_card_back_pic')) {
				            $userDetails['aadhaar_card_back_pic'] = $this->upload->data('file_name');
				        }
			        }

			        if (!empty($_FILES['passbook_pic'])) {
						if ($this->upload->do_upload('passbook_pic')) {
				            $userDetails['passbook_pic'] = $this->upload->data('file_name');
				        }
			        }

			        if (!empty($_FILES['chequebook_pic'])) {
						if ($this->upload->do_upload('chequebook_pic')) {
				            $userDetails['chequebook_pic'] = $this->upload->data('file_name');
				        }
			        }

					if (!empty($_FILES['education_proof'])) {
						if ($this->upload->do_upload('education_proof')) {
							$userDetails['education_proof'] = $this->upload->data('file_name');
						}
					}

					if (!empty($_FILES['signature'])) {
						if ($this->upload->do_upload('signature')) {
							$userDetails['signature'] = $this->upload->data('file_name');
						}
					}

		        	$user_id = $this->candidate_model->insertCandidateInfo($userDetails);

					if ($user_id) {
						//Send newly registered email
						$site_data = $this->setting_model->getSiteSetting();
						if ($site_data['new_user_mail_notif'] == 'on') {
							$business = $this->business_model->get($userDetails['company_id']);
							$site_data['firstname'] = $userInfo['firstname'];
							$templateKeys = [
								'name' => $userInfo['firstname'] ." " . $userInfo['middlename'] ." " . $userInfo['lastname'],
								'firstname' => $userInfo['firstname'],
								'middlename' => $userInfo['middlename'],
								'lastname' => $userInfo['lastname'],
								'company_name' => $site_data['app_name'],
								'login_url' => $site_data['cl_shortlink'],
								'login_qr' => base_url('assets/admin/img/qrcodes/candidate-login.png'),
								'exam_date' => '',
								'exam_time' => '',
								'exam_datetime' => '',
								'business_name' => $business['company_name']??$site_data['app_name'],
								'business_addr' => $business['company_address']??'',
								'exam_login_url' => '',
							];
					
							$inputString = $site_data['new_user_mail'];
							$replacementString = $inputString;

							foreach ($templateKeys as $key => $obj) {
								$placeholder = '${' . $key . '}';
								if (!empty($obj)){
									$replacementString = str_replace($placeholder, $obj, $replacementString);
								}
							}

							$email_html = [];
							$email_html['data'] = $replacementString;

							$htmlContent = $this->load->view('app/mail/common-mail-template', $email_html, true);

							if ($site_data['mail_type'] == 'api') {
								$config_arr=[
									'api_url' => $site_data['out_smtp'],
									'sender_address' => $site_data['smtp_email'],
									'to_address' => $userInfo['email'],
									'subject' => 'Account created successfully!',
									'body' => $htmlContent,
									'api_key' => $site_data['smtp_pass'],
									'to_name' => $userInfo['firstname']
								];

								$email_response = sendMailViaApi($config_arr);
							} else {
								$config_arr=[
									'out_smtp' => $site_data['out_smtp'],
									'smtp_port' => $site_data['smtp_port'],
									'smtp_email' => $site_data['smtp_email'],
									'smtp_pass' => $site_data['smtp_pass'],
									'app_name' => 'Simrangroups',
									'subject' => 'Account created successfully!',
									'body' => $htmlContent,
									'email' => $userInfo['email'],
								];

								$email_response = sendMailViaSMTP($config_arr);
							}
							

							$n_data['type'] = 'email';
							$n_data['text'] = htmlspecialchars($htmlContent);
							$n_data['to_recipient'] = $userInfo['email'];
							$n_data['created_on'] = date('Y-m-d H:i:s');

							if ($email_response) {
								$n_data['response'] = 'success';
								$this->notif_model->insertLog($n_data);
							} else {
								$n_data['response'] = 'failed';
								$n_data['req_response'] = htmlspecialchars($this->email->print_debugger());
								$this->notif_model->insertLog($n_data);
							}
						}

						//send SMS
						if ($site_data['new_user_sms_notif'] == 'on') {
							$databaseValues = [
								'name' => $userInfo['firstname']." ".$userInfo['middlename']." ".$userInfo['lastname'],
								'firstname' => $userInfo['firstname'],
								'middlename' => $userInfo['middlename'],
								'lastname' => $userInfo['lastname'],
								'company_name' => $site_data['app_name'],
								'login_url' => $site_data['cl_shortlink'],
								'login_qr' => '',
								'exam_date' => '',
								'exam_time' => '',
								'exam_datetime' => '',
								'business_name' => $business['company_name']??$site_data['app_name'],
								'business_addr' => $business['company_address']??'',
								'exam_login_url' => '',
							];
					
							$inputString = $site_data['new_registered'];
							$replacementString = $inputString;
					
							foreach ($databaseValues as $key => $value) {
								$placeholder = '${' . $key . '}';
								if (!empty($value)){
									$replacementString = str_replace($placeholder, $value, $replacementString);
								}
							}
							
							$url = 'http://www.text2india.store/vb/apikey.php';

							$params = [
								'apikey' => $site_data['sms_api_key'],
								'senderid' => $site_data['sms_sender_id'],
								'templateid' => $site_data['newusr_tempid'],
								'number' => $userInfo['phone'],
								'message' => $replacementString,
							];

							$url .= '?' . http_build_query($params);
							
							$curl = curl_init();
							curl_setopt_array($curl, array(
							  CURLOPT_URL => $url,
							  CURLOPT_RETURNTRANSFER => true,
							));
							$response = curl_exec($curl);
							$sms_resp = json_decode($response, true);
			
							$s_data['type'] = 'sms';
							$s_data['text'] = $replacementString;
							$s_data['to_recipient'] = $userInfo['phone'];
							$s_data['created_on'] = date('Y-m-d H:i:s');
							$s_data['user_id'] = $user_id;
							$s_data['notif_type'] = 'New Registration';
							
							if ($sms_resp['status'] == 'Success') {
								$s_data['response'] = 'success';
$s_data['req_response'] = $sms_resp['description'];
								$this->notif_model->insertLog($s_data);
							} else {
								$s_data['response'] = 'failed';
								$s_data['req_response'] = $sms_resp['description'];
								$this->notif_model->insertLog($s_data);
							}
						}
					}

					redirect('candidates');
		        }
			}
	    }

	    if ($this->session->userdata('type') == 'admin') {
	    	$data['companies'] = $this->business_model->getAdminCompanies();
	    } else if ($this->session->userdata('type') == 'business unit') {
	    	$data['companies'] = $this->business_model->getUserCompanies($this->session->userdata('id'), $this->session->userdata('type'));
	    }

	    $this->load->view('app/manage-candidate', $data);
	}

	public function edit($value='')
	{
		$this->isValidUser();
		$data['title'] = "Edit Candidate";
		$data['record'] = $this->candidate_model->getUser($value);
		if (!$data['record']) { redirect('candidates'); }

		if ($this->input->method() == "post") {
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 2048;
	        $config['encrypt_name']  = TRUE;

	        $this->upload->initialize($config);

	        $post = $this->input->post();
	        $this->form_validation->set_rules('firstname', 'First name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[12]');
			$this->form_validation->set_rules('phone', 'Phone number', 'required|integer|exact_length[10]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('aadhaar_number', 'Aadhaar Number', 'required');

			if ($this->form_validation->run() == TRUE) {

				$userInfo['firstname'] = $this->input->post('firstname');
				$userInfo['middlename'] = $this->input->post('middlename');
				$userInfo['lastname'] = $this->input->post('lastname');
				$userInfo['gender'] = $this->input->post('gender');
				$userInfo['phone'] = $this->input->post('phone');
				$userInfo['email'] = $this->input->post('email');
				$userInfo['company_id'] = $this->input->post('company_id');
				$userInfo['status'] = isset($_POST['status'])?$_POST['status']:'active';
				$userInfo['empid'] = $this->input->post('empid');
				$userInfo['password'] = $this->input->post('password');
		        if (!empty($_FILES['profile_img_file'])) {
					if ($this->upload->do_upload('profile_img_file')) {
			            $image = $this->upload->data('file_name');
						$thumb = createThumbnail($image);
						if ($thumb) {
							$userInfo['profile_img'] = $thumb;
						} else {
							$userInfo['profile_img'] = $image;
						}
			        }
		        }

		        $aff_user = $this->candidate_model->updateCandidate($userInfo, $value);

		        $userDetails = [];
	        	$userDetails['user_id'] = $value;
	        	$userDetails['company_id'] = $post['company_id'];
	        	$userDetails['aadhaar_number'] = $post['aadhaar_number'];
				$userDetails['whatsapp_number'] = $post['whatsapp_number'];
	        	$userDetails['ca_address'] = $post['ca_address'];
	        	$userDetails['ca_address_landmark'] = $post['ca_address_landmark'];
	        	$userDetails['ca_city'] = $post['ca_city'];
	        	$userDetails['ca_dist'] = $post['ca_dist'];
	        	$userDetails['ca_state'] = $post['ca_state'];
	        	$userDetails['ca_pin'] = $post['ca_pin'];

	        	$userDetails['pa_address'] = $post['pa_address'];
	        	$userDetails['pa_address_landmark'] = $post['pa_address_landmark'];
	        	$userDetails['pa_city'] = $post['pa_city'];
	        	$userDetails['pa_dist'] = $post['pa_dist'];
	        	$userDetails['pa_state'] = $post['pa_state'];
	        	$userDetails['pa_pin'] = $post['pa_pin'];

	        	$userDetails['highest_qualification'] = $post['highest_qualification'];
	        	// $userDetails['passout_year'] = $post['passout_year'];
	        	// $userDetails['percentage_secured'] = $post['percentage_secured'];
	        	$userDetails['dob'] = date('Y-m-d', strtotime($post['dob']));
	        	$userDetails['father_name'] = $post['father_name'];
	        	$userDetails['bank_name'] = $post['bank_name'];
	        	$userDetails['account_num'] = $post['account_num'];
	        	$userDetails['ifsc_code'] = $post['ifsc_code'];
	        	$userDetails['marital_status'] = $post['marital_status'];

	        	if (!empty($_FILES['voter_id'])) {
					if ($this->upload->do_upload('voter_id')) {
			            $userDetails['voter_id'] = $this->upload->data('file_name');
			        }
		        }

		        if (!empty($_FILES['pancard_pic'])) {
					if ($this->upload->do_upload('pancard_pic')) {
			            $userDetails['pancard_pic'] = $this->upload->data('file_name');
			        }
		        }

		        if (!empty($_FILES['aadhaar_card_front_pic'])) {
					if ($this->upload->do_upload('aadhaar_card_front_pic')) {
			            $userDetails['aadhaar_card_front_pic'] = $this->upload->data('file_name');
			        }
		        }

		        if (!empty($_FILES['aadhaar_card_back_pic'])) {
					if ($this->upload->do_upload('aadhaar_card_back_pic')) {
			            $userDetails['aadhaar_card_back_pic'] = $this->upload->data('file_name');
			        }
		        }

		        if (!empty($_FILES['passbook_pic'])) {
					if ($this->upload->do_upload('passbook_pic')) {
			            $userDetails['passbook_pic'] = $this->upload->data('file_name');
			        }
		        }

		        if (!empty($_FILES['chequebook_pic'])) {
					if ($this->upload->do_upload('chequebook_pic')) {
			            $userDetails['chequebook_pic'] = $this->upload->data('file_name');
			        }
		        }

				if (!empty($_FILES['education_proof'])) {
					if ($this->upload->do_upload('education_proof')) {
			            $userDetails['education_proof'] = $this->upload->data('file_name');
			        }
		        }

		        if (!empty($_FILES['signature'])) {
					if ($this->upload->do_upload('signature')) {
			            $userDetails['signature'] = $this->upload->data('file_name');
			        }
		        }

		        $row = $this->candidate_model->getUserDetails($value);

		        if ($row) {
					$user_id = $this->candidate_model->updateCandidateInfo($userDetails, $value);
		        } else {
		        	$user_id = $this->candidate_model->insertCandidateInfo($userDetails);
		        }
	        	
	        	if (isset($post['ajax'])) {
	        		$response = [
	        			'status' => 'SUCCESS',
	        			'message' => 'Candidate record updated successfully!'
	        		];
	        		echo json_encode($response); return 1;
	        	} else{
	        		$this->session->set_flashdata('success', 'Candidate updated successfully!');
		        	redirect('candidates');
	        	}
			}
		}

		if ($this->session->userdata('type') == 'admin') {
	    	$data['companies'] = $this->business_model->getAdminCompanies();
	    } else if ($this->session->userdata('type') == 'business unit') {
	    	$data['companies'] = $this->business_model->getUserCompanies($this->session->userdata('id'));
	    }

	    $data['user_id'] = $value;

	    $this->load->view('app/manage-candidate', $data);
	}

	public function delete($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('candidates'); }
		$this->candidate_model->remove($value);
		$this->session->set_flashdata('success', 'Candidate removed successfully!');

		redirect('candidates');
	}

	public function deleteMultiple()
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') != "admin") {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		$post = $this->input->post();
		$ids = json_decode($post['checkedValues']);

		foreach ($ids as $key => $obj) {
			$this->candidate_model->remove($obj);
		}
		$data['status'] = "SUCCESS";
		$data['message'] = "Candidates removed successfully!";
		echo json_encode($data);
	}

	public function view($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('candidates'); }

		$data['title'] = "View Candidate";
		$data['record'] = $this->candidate_model->getUser($value);
		$data['sms_records'] = $this->notif_model->getUserSMS($value);
		$data['email_records'] = $this->notif_model->getUserEmail($value);
		$this->load->view('app/view-candidate', $data);
	}

	public function print($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('candidates'); }

		$data['title'] = "View Candidate";
		$data['record'] = $this->candidate_model->getUser($value);
		$data['sms_records'] = $this->notif_model->getUserSMS($value);
		$data['email_records'] = $this->notif_model->getUserEmail($value);
		$data['company'] = $this->business_model->get($data['record']['company_id']);

		$this->load->view('app/print-candidate', $data);
	}

	public function viewExamResult($value='')
	{
		$this->isNotCandidate();

		if (!isset($_GET['userid']) || !isset($_GET['examid'])){
			redirect('logout');
		}

		$exam_id = $this->input->get('examid', true);
		$user_id = $this->input->get('userid', true);
		$result = [];
		$questions = $this->exam_model->getExamQuestions($exam_id);

		foreach ($questions as $question => $que) {
			$temp = $que;
			$correctAnswerEng = '';
			$correctAnswerHin = '';
			$correctUserAnswerEng = '';
			$correctUserAnswerHin = '';

			if ($que['question_type'] != "text") {
				$temp['answers'] = $this->answer_model->getAnswersOfQuestion($que['question_id']);
				foreach ($temp['answers'] as $answers => $answer) {
					if ($answer['isCorrect']){
						$correctAnswerEng .= $answer['answer_text_en'] . ", ";
						$correctAnswerHin .= $answer['answer_text_hi'] . ", ";
					}
				}

				$temp['correct_answer_en'] = substr($correctAnswerEng, 0, -2);
				$temp['correct_answer_hi'] = substr($correctAnswerHin, 0, -2);

				//Get user answers
				$con_arr = [
					'user_id' => $user_id,
					'question_id' => $que['question_id'],
					'exam_id' => $exam_id
				];
				$user_answers = $this->exam_model->getUserAnswers($con_arr);
				foreach ($user_answers as $usr_answers => $uans) {
					$correctUserAnswerEng .= $uans['answer_text_en'] . ", ";
					$correctUserAnswerHin .= $uans['answer_text_hi'] . ", ";
				}
				$temp['correct_user_answer_en'] = substr($correctUserAnswerEng, 0, -2);
				$temp['correct_user_answer_hi'] = substr($correctUserAnswerHin, 0, -2);

				if (!empty($user_answers)){
					if ($temp['correct_answer_en'] == $temp['correct_user_answer_en']) {
						$temp['answer_status'] = 1;
					} else {
						$temp['answer_status'] = 3;
					}
				} else {
					$temp['answer_status'] = 2;
				}

			} else {
				$con_arr = [
					'user_id' => $user_id,
					'question_id' => $que['question_id'],
					'exam_id' => $exam_id
				];
				$user_answers = $this->exam_model->getUserAnswer($con_arr);
				$temp['answers'] = [];
				$temp['correct_answer_en'] = $correctAnswerEng;
				$temp['correct_answer_hi'] = $correctAnswerHin;
				$temp['correct_user_answer_en'] = $user_answers['answer_id']??'';
				$temp['correct_user_answer_hi'] = $user_answers['answer_id']??'';
				$temp['answer_status'] = 4;
			}

			$result[] = $temp;
		}
		$data['result'] = $result;

		$data['title'] = "View Candidate Answers";
		$this->load->view('app/view-candidate-exam-details', $data);
	}

	private function generateName($user_id='', $exam_id=''){
		$candidate = $this->candidate_model->get($user_id);
		$filename = $candidate['firstname'];
		if(!empty($candidate['middlename'])) {
			$filename .= " " . $candidate['middlename'];
		}

		if(!empty($candidate['lastname'])) {
			$filename .= " " . $candidate['lastname'];
		}

		if(!empty($candidate['empid'])) {
			$filename .= "-" . $candidate['empid'];
		}
		return strtolower(str_replace(" ", "_", $filename)) . '-' . $exam_id . ".pdf";
	}

	public function generateDetailedResult($return_val=false)
	{
		$this->isNotCandidate();
		$jsonResponse = (isset($_GET['return']) && $_GET['return']=='json');
		if (!isset($_GET['userid']) || !isset($_GET['examid'])){ redirect('logout'); }
		$exam_id = $this->input->get('examid', true);
		$user_id = $this->input->get('userid', true);
		$filename = $this->generateName($user_id, $exam_id);
	    $filepath = FCPATH . 'assets/admin/exams/' . $filename;
		$arr = [
			'exam_id'=> $exam_id,
			'candidate_id'=> $user_id,
		];
		$val = $this->exam_model->isExamAndCandidateExists($arr);
		if (!$val) { 
			$this->session->set_flashdata('error', 'Not a valid exam candidate!');
			redirect('exams'); 
		}
		$this->load->helper('download');
	    if (file_exists($filepath)) {
	        
	        if ($return_val) {
	        	return $filepath;
	        } else if ($jsonResponse){
	        	$res = [ 'status' => 'SUCCESS' ];
	        	echo json_encode($res);
	        } else {
	        	force_download($filename, file_get_contents($filepath));
	        }  
	    } else {
			$result = [];
			$questions = $this->exam_model->getExamQuestions($exam_id);
			foreach ($questions as $question => $que) {
				$temp = $que;
				$correctAnswerEng = '';
				$correctAnswerHin = '';
				$correctUserAnswerEng = '';
				$correctUserAnswerHin = '';

				if ($que['question_type'] != "text") {
					$temp['answers'] = $this->answer_model->getAnswersOfQuestion($que['question_id']);
					foreach ($temp['answers'] as $answers => $answer) {
						if ($answer['isCorrect']){
							$correctAnswerEng .= $answer['answer_text_en'] . ", ";
							$correctAnswerHin .= $answer['answer_text_hi'] . ", ";
						}
					}
					$temp['answers'] = $this->answer_model->getAnswersOfQuestion($que['question_id']);
					$temp['correct_answer_en'] = substr($correctAnswerEng, 0, -2);
					$temp['correct_answer_hi'] = substr($correctAnswerHin, 0, -2);

					//Get user answers
					$con_arr = [
						'user_id' => $user_id,
						'question_id' => $que['question_id'],
						'exam_id' => $exam_id
					];
					$user_answers = $this->exam_model->getUserAnswers($con_arr);
					foreach ($user_answers as $usr_answers => $uans) {
						$correctUserAnswerEng .= $uans['answer_text_en'] . ", ";
						$correctUserAnswerHin .= $uans['answer_text_hi'] . ", ";
					}
					$temp['correct_user_answer_en'] = substr($correctUserAnswerEng, 0, -2);
					$temp['correct_user_answer_hi'] = substr($correctUserAnswerHin, 0, -2);
					if (!empty($user_answers)){
						if ($temp['correct_answer_en'] == $temp['correct_user_answer_en']) {
							$temp['answer_status'] = 1;
						} else {
							$temp['answer_status'] = 3;
						}
					} else {
						$temp['answer_status'] = 2;
					}

				} else {
					$con_arr = [
						'user_id' => $user_id,
						'question_id' => $que['question_id'],
						'exam_id' => $exam_id
					];
					$user_answers = $this->exam_model->getUserAnswer($con_arr);
					$temp['answers'] = [];
					$temp['correct_answer_en'] = $correctAnswerEng;
					$temp['correct_answer_hi'] = $correctAnswerHin;
					$temp['correct_user_answer_en'] = $user_answers['answer_id']??'';
					$temp['correct_user_answer_hi'] = $user_answers['answer_id']??'';
					$temp['answer_status'] = 4;
				}

				$result[] = $temp;
			}
			
			$data['result'] = $result;
			$data['user'] = $this->candidate_model->getUser($user_id);
			$data['exam'] = $this->exam_model->get($exam_id);
			$data['business'] = $this->business_model->get($data['exam']['company_id']);
			$data['title'] = "View Candidate Answers";
			$clients = $this->exam_model->getExamClients($exam_id);
			$cli = '';
			foreach ($clients as $key => $obj) {
				$cli .= $obj['company_name'] . ",";
			}
			$data['clients'] = rtrim($cli, ',');
			$data['exam_log'] = $this->exam_model->checkCandidateExamInfo(['exam_id'=>$exam_id, 'user_id'=>$user_id]);
			$html = $this->load->view('app/pdfviews/view-candidate-answers', $data, true);

			$mpdf = new \Mpdf\Mpdf(['utf-8', 'A4-C']);
			$mpdf->WriteHTML($html);
			$output = $mpdf->Output($filepath, 'F');

			if ($return_val) { 
				return $filepath; 
			} else if ($jsonResponse) {
	        	$res = [ 'status' => 'SUCCESS'];
	        	echo json_encode($res);
	        } else {
				force_download($filename, file_get_contents($filepath));
			}  
	    }
	    $this->clearOlderFiles();
	}

	public function bulkUpload()
	{
		$this->isValidUser();
		$data['title'] = "Bulk Upload";
		$app_info = $this->login->getApplicationInfo();
		$site_data = $this->setting_model->getSiteSetting();
		$error = [];
		if ($this->input->post()) {
			$config['upload_path']   = './assets/admin/formats/';
	        $config['allowed_types'] = 'csv|CSV|xlsx|XLSX|xls|XLS';
			$this->upload->initialize($config);
	        if (!$this->upload->do_upload('excel_file')) {
	        	$this->session->set_flashdata('error', $this->upload->display_errors());
	        } else {
	        	$upload_data = $this->upload->data();
	            $file_path = $upload_data['full_path'];

	            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
	            $worksheet = $spreadsheet->getActiveSheet();
	            $excel_data = $worksheet->toArray();
				$phone_nums = [];
	            for ($i = 1; $i < count($excel_data); $i++) {
	                $row = $excel_data[$i];
					if (!empty($row[0])) {
						if (!$this->candidate_model->candidateExists($row[6])) {
							$firstTwoLetters = substr($row[0], 0, 2);
							$password = strtolower($firstTwoLetters) . "@12345";
							if (!empty($row[4])){
								$company = $this->client_model->searchCompany($row[4]);
								if (empty($company)) { $company = ['id'=>'']; } 
							} else { $company = ['id'=>'']; }

							$xlx_data = array(
								'firstname' => $row[0],
								'middlename' => $row[1],
								'lastname' => $row[2],
								'email' => $row[3],
								'company_id' => $company['id'],
								'phone' => $row[6],
								'gender' => $row[20],
								'status' => 'active',
								'password' => md5($password),
								'source' => 'bulk'
							);
							
							$last_id = $this->candidate_model->insert($xlx_data);
							if ($last_id) {
								$phone_nums[] = $xlx_data['phone'];
								$exl_data = array(
									'user_id' => $last_id,
									'company_id' => (!empty($company))?$company['id']:'',
									'highest_qualification' => $row[25],
									'aadhaar_number' => $row[9],
									'pa_address' => $row[10],
									'pa_address_landmark' => $row[11],
									'pa_dist' => $row[13],
									'pa_state' => $row[14],
									'pa_pin' => $row[12],

									'ca_address' => $row[15],
									'ca_address_landmark' => $row[16],
									'ca_dist' => $row[18],
									'ca_state' => $row[19],
									'ca_pin' => $row[17],

									'dob' => (!empty($row[5]))?date('Y-m-d', strtotime($row[5])):'0000-00-00',
									'whatsapp_number' => $row[7],
									'father_name' => $row[8],
									'bank_name' => $row[21],
									'account_num' => $row[22],
									'ifsc_code' => $row[23],
									'marital_status' => (!empty($row[24]))?$row[24]:'un-married'
								);
								$this->candidate_model->insertCandidateInfo($exl_data);
								$business = $this->business_model->get($company['id']);
								if ($site_data['new_user_mail_notif'] == 'on') {
									$templateKeys = [
										'name' => $xlx_data['firstname'] ." " . $xlx_data['middlename'] ." " . $xlx_data['lastname'],
										'firstname' => $xlx_data['firstname'],
										'middlename' => $xlx_data['middlename'],
										'lastname' => $xlx_data['lastname'],
										'company_name' => $app_info['app_name'],
										'login_url' => $app_info['cl_shortlink'],
										'login_qr' => base_url('assets/admin/img/qrcodes/candidate-login.png'),
										'exam_date' => '',
										'exam_time' => '',
										'exam_datetime' => '',
										'business_name' => $business['company_name']??$site_data['app_name'],
										'business_addr' => $business['company_address']??'',
										'exam_login_url' => '',
									];
							
									$inputString = $app_info['new_user_mail'];
									$replacementString = $inputString;
					
									foreach ($templateKeys as $key => $obj) {
										$placeholder = '${' . $key . '}';
										if (!empty($obj)){
											$replacementString = str_replace($placeholder, $obj, $replacementString);
										} else {
											$replacementString = str_replace($placeholder, '', $replacementString);
										}
									}
					
									$email_html = [];
									$email_html['data'] = $replacementString;
									
									$htmlContent = $this->load->view('app/mail/common-mail-template', $email_html, true);
									if ($site_data['mail_type'] == 'api') {
										$config_arr=[
											'api_url' => $site_data['out_smtp'],
											'sender_address' => $site_data['smtp_email'],
											'to_address' => $xlx_data['email'],
											'subject' => 'Your account is now created!',
											'body' => $htmlContent,
											'api_key' => $site_data['smtp_pass'],
											'to_name' => $xlx_data['firstname']
										];

										$email_response = sendMailViaApi($config_arr);
									} else {
										$config_arr=[
											'out_smtp' => $site_data['out_smtp'],
											'smtp_port' => $site_data['smtp_port'],
											'smtp_email' => $site_data['smtp_email'],
											'smtp_pass' => $site_data['smtp_pass'],
											'app_name' => 'Simrangroups',
											'subject' => 'Your account is now created!',
											'body' => $emailContent,
											'email' => $xlx_data['email'],
										];

										sendMailViaSMTP($config_arr);
									}
									// $email_data = [
									// 	'name' => $xlx_data['firstname'],
									// 	'email' => $xlx_data['email'],
									// 	'password' => $password,
									// 	'company_name' => $business['company_name']??$app_info['app_name']
									// ];

									// $emailContent = $this->load->view('app/mail/bulk-account-template', $email_data, true);

									$n_data['type'] = 'email';
									$n_data['user_id'] = $last_id;
									$n_data['notif_type'] = 'New Registration';
									$n_data['text'] = htmlspecialchars($htmlContent);
									$n_data['to_recipient'] = $xlx_data['email'];
									$n_data['created_on'] = date('Y-m-d H:i:s');

									if ($email_response) {
										$n_data['response'] = 'success';
										$this->notif_model->insertLog($n_data);
									} else {
										$n_data['response'] = 'failed';
										$n_data['req_response'] = $email_response;
										$this->notif_model->insertLog($n_data);
									}
								}
								if ($site_data['new_user_sms_notif'] == 'on') {
									$inputString = $app_info['new_registered'];
									$replacementString = $inputString;
							
									foreach ($templateKeys as $keys => $keyval) {
										$placeholder = '${' . $keys . '}';
										if (!empty($keyval)) {
											$replacementString = str_replace($placeholder, $keyval, $replacementString);
										} else {
											$replacementString = str_replace($placeholder, '', $replacementString);
										}
									}

									$url = 'http://www.text2india.store/vb/apikey.php';

									$params = [
										'apikey' => $site_data['sms_api_key'],
										'senderid' => $site_data['sms_sender_id'],
										'templateid' => $site_data['newusr_tempid'],
										'number' => $xlx_data['phone'],
										'message' => $replacementString,
									];

									$url .= '?' . http_build_query($params);
									
									$curl = curl_init();
									curl_setopt_array($curl, array(
										CURLOPT_URL => $url,
										CURLOPT_RETURNTRANSFER => true,
									));
									$response = curl_exec($curl);
									$sms_resp = json_decode($response, true);

									$s_data['type'] = 'sms';
									$s_data['user_id'] = $last_id;
									$s_data['notif_type'] = 'New Registration';
									$s_data['text'] = $replacementString;
									$s_data['to_recipient'] = $xlx_data['phone'];
									$s_data['created_on'] = date('Y-m-d H:i:s');

									if ($sms_resp['status'] == 'Success') {
										$s_data['response'] = 'success';
$s_data['req_response'] = $sms_resp['description'];
										$this->notif_model->insertLog($s_data);
									} else {
										$s_data['response'] = 'failed';
										$s_data['req_response'] = $sms_resp['description'];
										$this->notif_model->insertLog($s_data);
									}
								}
							} else {
								$error[] = [
									'row' => $i + 1,
									'message' => 'Please check record for errors!'
								]; 
							}
						} else {
							$error[] = [
								'row' => $i + 1,
								'message' => 'Record already exists!'
							];
						}
					} else {
						$error[] = [
							'row' => $i + 1,
							'message' => 'End of file or firstname missing. Script terminated!'
						]; 
						break;
					}
	            }
	            $this->session->set_flashdata('success', 'Data processed successfully!');
	            @unlink($file_path);
	        }
		}
		$data['error'] = $error;
		$this->load->view('app/bulk-upload', $data, FALSE);
	}

	public function sendLoginMail()
	{
		if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}
		$site_data = $this->setting_model->getSiteSetting();
		$post = $this->input->post();
		$ids = json_decode($post['checkedValues']);
		$error=[];
		$success=[];

		foreach ($ids as $key => $obj) {
			$get_candidate = $this->candidate_model->get($obj);
			$business = $this->business_model->get($get_candidate['company_id']);

			if($get_candidate) {
				$templateKeys = [
					'name' => $get_candidate['firstname'] ." " . $get_candidate['middlename'] ." " . $get_candidate['lastname'],
					'firstname' => $get_candidate['firstname'],
					'middlename' => $get_candidate['middlename'],
					'lastname' => $get_candidate['lastname'],
					'company_name' => $site_data['app_name'],
					'login_url' => $site_data['cl_shortlink'],
					'login_qr' => base_url('assets/admin/img/qrcodes/candidate-login.png'),
					'exam_date' => '',
					'exam_time' => '',
					'exam_datetime' => '',
					'business_name' => $business['company_name']??$site_data['app_name'],
					'business_addr' => $business['company_address']??'',
					'exam_login_url' => '',
				];
		
				$inputString = $site_data['candidate_login_mail'];
				$replacementString = $inputString;

				foreach ($templateKeys as $key => $obj) {
					$placeholder = '${' . $key . '}';
					if($key == 'login_qr'){
						$obj = htmlspecialchars('<div style="margin:0px auto; text-align:center;"><img src="'.$obj.'" height="100px" ></div>');
					}
					if (!empty($obj)){
						$replacementString = str_replace($placeholder, $obj, $replacementString);
					} else {
						$replacementString = str_replace($placeholder, '', $replacementString);
					}
				}

				$email_html = [];
				$email_html['data'] = $replacementString;
				
				$htmlContent = $this->load->view('app/mail/common-mail-template', $email_html, true);

				if ($site_data['mail_type'] == 'api') {
					$config_arr=[
						'api_url' => $site_data['out_smtp'],
						'sender_address' => $site_data['smtp_email'],
						'to_address' => $get_candidate['email'],
						'subject' => 'QR code to login into your dashboard',
						'body' => $htmlContent,
						'api_key' => $site_data['smtp_pass'],
						'to_name' => $get_candidate['firstname']
					];

					$email_response = sendMailViaApi($config_arr);
				} else {
					$config_arr=[
						'out_smtp' => $site_data['out_smtp'],
						'smtp_port' => $site_data['smtp_port'],
						'smtp_email' => $site_data['smtp_email'],
						'smtp_pass' => $site_data['smtp_pass'],
						'app_name' => 'Simrangroups',
						'subject' => 'Link login into your dashboard!',
						'body' => $htmlContent,
						'email' => $get_candidate['email'],
					];

					$email_response = sendMailViaSMTP($config_arr);	
				}
				
				$n_data['type'] = 'email';
				$n_data['user_id'] = $get_candidate['id'];
				$n_data['notif_type'] = 'Login';
				$n_data['text'] = htmlspecialchars($htmlContent);
				$n_data['to_recipient'] = $get_candidate['email'];
				$n_data['created_on'] = date('Y-m-d H:i:s');

				if ($email_response) {
					$n_data['response'] = 'success';
					$this->notif_model->insertLog($n_data);
					$success[] = $get_candidate['id'];
				} else {
					$n_data['response'] = 'failed';
					$n_data['req_response'] = $email_response;
					$this->notif_model->insertLog($n_data);
					$error[] = $get_candidate['id'];
				}
			}
		}

		if (count($error)) {
			$data['status'] = "ERROR";
			$data['message'] = "Mail not sent to every user!";
			echo json_encode($data);
		} else {
			$data['status'] = "SUCCESS";
			$data['message'] = "Mail sent successfully to selected candidates!";
			echo json_encode($data);
		}
	}

	public function sendLoginSms()
	{
		if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}
		$site_data = $this->setting_model->getSiteSetting();
		$post = $this->input->post();
		$ids = json_decode($post['checkedValues']);
		$phone_nums=[];
		
		foreach ($ids as $key => $obj) {
			$get_candidate = $this->candidate_model->get($obj);
			$business = $this->business_model->get($get_candidate['company_id']);

			$databaseValues = [
				'name' => $get_candidate['firstname'] ." " . $get_candidate['middlename'] ." " . $get_candidate['lastname'],
				'firstname' => $get_candidate['firstname'],
				'middlename' => $get_candidate['middlename'],
				'lastname' => $get_candidate['lastname'],
				'company_name' => $site_data['app_name'],
				'login_url' => $site_data['cl_shortlink'],
				'login_qr' => '',
				'exam_date' => '',
				'exam_time' => '',
				'exam_datetime' => '',
				'business_name' => $business['company_name']??$site_data['app_name'],
				'business_addr' => $business['company_address']??'',
				'exam_login_url' => '',
			];
	
			$inputString = $site_data['candidate_login'];
			$replacementString = $inputString;
	
			foreach ($databaseValues as $key => $value) {
				$placeholder = '${' . $key . '}';
				if (!empty($value)){
					$replacementString = str_replace($placeholder, $value, $replacementString);
				} else {
					$replacementString = str_replace($placeholder, '', $replacementString);
				}
			}

			$url = 'http://www.text2india.store/vb/apikey.php';

			$params = [
				'apikey' => $site_data['sms_api_key'],
				'senderid' => $site_data['sms_sender_id'],
				'templateid' => $site_data['cdtlog_tempid'],
				'number' => $get_candidate['phone'],
				'message' => $replacementString,
			];

			$url .= '?' . http_build_query($params);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
			));
			$response = curl_exec($curl);
			$sms_resp = json_decode($response, true);

			$s_data['type'] = 'sms';
			$s_data['user_id'] = $get_candidate['id'];
			$s_data['notif_type'] = 'Login';
			$s_data['text'] = $replacementString;
			$s_data['to_recipient'] = $get_candidate['phone'];
			$s_data['created_on'] = date('Y-m-d H:i:s');

			if ($sms_resp['status'] == 'Success') {
				$s_data['response'] = 'success';
$s_data['req_response'] = $sms_resp['description'];
				$this->notif_model->insertLog($s_data);
			} else {
				$s_data['response'] = 'failed';
				$s_data['req_response'] = $sms_resp['description'];
				$this->notif_model->insertLog($s_data);
			}
		}
		
		$data['status'] = "SUCCESS";
		$data['message'] = "SMS sent successfully!";
		echo json_encode($data);
	}

	public function searchCandidate()
	{
		if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}
		$site_data = $this->setting_model->getSiteSetting();
		$post = $this->input->post();
		$search_term = $post['searchTerm']??'';
		$company_id = $post['companyId']??'';

		$candidates = (isset($post['searchTerm']))?$this->candidate_model->searchCandidate($search_term, $company_id):[];

		$data['status'] = "SUCCESS";
		$data['message'] = "Candidate fetched successfully!";
		$data['result'] = $candidates;
		echo json_encode($data);
	}

	public function filter()
	{
		$this->isValidUser();
		if ($this->input->get()) {
			$get = $this->input->get();
			if (
				isset($get['search_name']) || 
				isset($get['search_email']) || 
				isset($get['search_gender']) || 
				isset($get['daterange']) || 
				isset($get['search_status']) || 
				isset($get['search_state']) || 
				isset($get['search_phone']) ||
				isset($get['aadhaar_number']) || 
				isset($get['father_name']) || 
				isset($get['dob']) 
			) {
				$company_id = [];
				if ($_SESSION['type'] == "business unit") {
					foreach ($_SESSION['companies'] as $compns => $comp) {
						$company_id[] = $comp['id'];
					}
				}
				if (!empty($get['daterange'])) {
					$date = explode("-", $get['daterange']);
					$get['from_date'] = DateTime::createFromFormat('d/m/Y', trim($date[0]))->format('Y-m-d');
					$get['to_date'] = DateTime::createFromFormat('d/m/Y', trim($date[1]))->format('Y-m-d');
				}

				if (!empty($get['dob'])) {
					$get['dob'] = DateTime::createFromFormat('d-m-Y', trim($get['dob']))->format('Y-m-d');
				}

				$data['results'] = $this->candidate_model->filter_data($get, $company_id);
			}
		}else {
			$order = $_GET['order']??'DESC';
			$company_id = [];
			if ($_SESSION['type'] == "business unit") {
				foreach ($_SESSION['companies'] as $compns => $comp) {
					$company_id[] = $comp['id'];
				}
			}
			$data['results'] = $this->candidate_model->get_data(100, 0, $order, $company_id,'active');
		}

		
	    $data['title'] = "Filter Candidates";
		$this->load->view('app/filter-candidates', $data);
	}

	public function ajaxView($value='')
	{
		$this->isValidUser();
		if (empty($value)){ echo "<h1> Forbidden! </h1>"; exit(); }
		$data['record'] = $this->candidate_model->getUser($value);
		$data['sms_records'] = $this->notif_model->getUserSMS($value);
		$data['email_records'] = $this->notif_model->getUserEmail($value);
		echo $this->load->view('app/ajax/view-candidate', $data, TRUE);
	}

	public function ajaxEdit($value='')
	{
		$this->isValidUser();
		if (empty($value)){ echo "<h1> Forbidden! </h1>"; exit(); }
		$data['record'] = $this->candidate_model->getUser($value);
		if ($this->session->userdata('type') == 'admin') {
	    	$data['companies'] = $this->business_model->getAdminCompanies();
	    } else if ($this->session->userdata('type') == 'business unit') {
	    	$data['companies'] = $this->business_model->getUserCompanies($this->session->userdata('id'));
	    }
		echo $this->load->view('app/ajax/edit-candidate', $data, TRUE);
	}

	public function removeAsset($value='')
	{
		$this->isValidUser();
		$record = $this->candidate_model->getUser($value);
		$data['status'] = 'ERROR';
		if ( $this->input->post() && !empty($this->input->post('asset')) && $record) {
			$asset = $this->input->post('asset');

			if ($asset == 'profile_img') {
				$this->candidate_model->updateCandidate([$asset => ''], $record['id']);
			} else {
				$this->candidate_model->updateCandidateInfo([$asset => ''], $record['id']);
			}

			@unlink('./assets/img/' . $record[$asset]);

			$data['status'] = "SUCCESS";
		}
		
		echo json_encode($data);
	}

	public function clearOlderFiles($value='')
	{
		$directory = FCPATH . 'assets/admin/exams/';
		if (is_dir($directory)) {
		    $currentTimestamp = time();
		    foreach (scandir($directory) as $file) {
		        $filePath = $directory . $file;
		        if (is_file($filePath)) {
		            $fileTimestamp = filemtime($filePath);
		            $fileAgeInSeconds = $currentTimestamp - $fileTimestamp;
		            $thirtyDaysInSeconds = 30 * 24 * 60 * 60;
		            if ($fileAgeInSeconds > $thirtyDaysInSeconds) {
		                unlink($filePath);
		                echo 'Deleted: ' . $file . PHP_EOL;
		            }
		        }
		    }
		} else {
		    echo 'Directory does not exist.' . PHP_EOL;
		}
	}
}

/* End of file  */
/* Location: ./application/controllers/ */