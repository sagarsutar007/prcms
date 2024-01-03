<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Business_units_model', 'business_model');
		$this->load->model('Candidates_model', 'candidate_model');
		$this->load->model('Login_model', 'login_model');
		$this->load->model('Notification_model', 'notif_model');
		$this->load->model('Clients_model', 'client_model');
	}

	public function index()
	{
		$data= [];
		if ($this->input->post()) {
			$user_detail = [];
			$post = $this->input->post();
			$post['status'] = 'active';

			$this->form_validation->set_rules('firstname', 'First name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[12]');
			$this->form_validation->set_rules('passconf', 'Confirm Password', 'required|min_length[8]|max_length[12]|matches[password]');
			$this->form_validation->set_rules('highest_qualification', 'Highest Qualification', 'trim|required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
			$this->form_validation->set_rules('company_id', 'Company', 'trim|required');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone number', 'required|integer|exact_length[10]|is_unique[candidates.phone]', array(
                'is_unique'     => 'This %s already exists.'
	        ));
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[candidates.email]', array(
                'is_unique'     => 'This %s already registered.'
	        ));
	        if (empty($_FILES['profile_img']['name'])) { $this->form_validation->set_rules('profile_img', 'Passport Size Photo', 'required'); }
			
			if ($this->form_validation->run() == TRUE) {

				if (!empty($_FILES['profile_img']['name'])) {
					$config['upload_path']   = './assets/img/';
			        $config['allowed_types'] = 'gif|jpg|jpeg|png';
			        $config['max_size']      = 20480;
			        $config['encrypt_name']  = TRUE;

			        $this->upload->initialize($config);
					if ($this->upload->do_upload('profile_img')) {
			            $post['profile_img'] = $this->upload->data('file_name');
			        }
		        }

				$candidate = [];
				$candidate['firstname'] = $post['firstname'];
				$candidate['lastname'] = $post['lastname'];
				$candidate['email'] = strtolower($post['email']);
				$candidate['phone'] = $post['phone'];
				$candidate['password'] = md5($post['password']);
				$candidate['gender'] = $post['gender'];
				$candidate['profile_img'] = $post['profile_img']??'';
				$candidate['status'] = 'active';
				$candidate['company_id'] = $post['company_id'];
				$candidate['created_at'] = date('Y-m-d H:i:s');
				$candidate['source'] = 'manual';

				//Insert candidate data in main candidate table
				$user_detail['user_id'] = $this->candidate_model->insert($candidate);

				$user_detail['highest_qualification'] = $post['highest_qualification'];
				$user_detail['dob'] = date('Y-m-d', strtotime($post['dob']));
		        $user_detail['company_id'] = $post['company_id'];
				if(isset($post['same_wa_num'])){ $user_detail['whatsapp_number'] = $post['phone']; }

				$this->candidate_model->insertCandidateInfo($user_detail);

				$this->session->set_userdata('user_id', $user_detail['user_id']);
		       	redirect('candidate-signup/update-address');
			}
		}

		$data['app_info'] = $this->login_model->getApplicationInfo();
		$data['business_units'] = $this->business_model->get();

		$this->load->view('candidate-registration', $data, FALSE);
	}

	public function updateCandidateAddress($value='')
	{
		if (!$this->session->has_userdata('user_id')) {
			redirect('logout');
		}

		$user_id = $this->session->userdata('user_id');

		$get_candidate = $this->candidate_model->get($user_id);

		if (!$get_candidate) { redirect('candidate-signup'); }

		if ($this->input->post()) {
			$post = $this->input->post();
			$this->form_validation->set_rules('pa_address', 'Address Lane 1', 'required');
			$this->form_validation->set_rules('pa_address_landmark', 'Address Lane 1', 'required');
			$this->form_validation->set_rules('pa_city', 'City', 'required');
			$this->form_validation->set_rules('pa_dist', 'District', 'required');
			$this->form_validation->set_rules('pa_pin', 'Pincode', 'required');
			$this->form_validation->set_rules('pa_state', 'State', 'required');

			$this->form_validation->set_rules('ca_address', 'Address Lane 1', 'required');
			$this->form_validation->set_rules('ca_address_landmark', 'Address Lane 1', 'required');
			$this->form_validation->set_rules('ca_city', 'City', 'required');
			$this->form_validation->set_rules('ca_dist', 'District', 'required');
			$this->form_validation->set_rules('ca_pin', 'Pincode', 'required');
			$this->form_validation->set_rules('ca_state', 'State', 'required');

			// if ($this->form_validation->run() == TRUE) {
				$aff_rows = $this->candidate_model->updateCandidateInfo($post, $user_id);
				redirect('candidate-signup/update-bank');
			// }
		}
		$data['app_info'] = $this->login_model->getApplicationInfo();
		$data['candidate'] = $get_candidate;
		$this->load->view('candidate-address', $data, FALSE);
	}

	public function updateCandidateBank($value='')
	{
		if (!$this->session->has_userdata('user_id')) { redirect('logout'); }
		$user_id = $this->session->userdata('user_id');
		$get_candidate = $this->candidate_model->get($user_id);
		if (!$get_candidate) { redirect('candidate-signup'); }
		if ($this->input->post()) {
			$post = $this->input->post();
			// $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			// $this->form_validation->set_rules('account_num', 'Account number', 'required');
			// $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required');
			// if (empty($_FILES['passbook_pic']['name'])) { $this->form_validation->set_rules('passbook_pic', 'Passbook image', 'required'); }
			// if (empty($_FILES['chequebook_pic']['name'])) { $this->form_validation->set_rules('chequebook_pic', 'Chequebook Image', 'required'); }

			// if ($this->form_validation->run() == TRUE) {
				$error = [];
				$config['upload_path']   = './assets/img/';
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size']      = 20480;
		        $config['encrypt_name']  = TRUE;

		        $this->upload->initialize($config);
				
				if (!empty($_FILES['passbook_pic']['name'])) {
					if ($this->upload->do_upload('passbook_pic')) {
			            $post['passbook_pic'] = $this->upload->data('file_name');
			        } else {
						$error[] = array('error' => $this->upload->display_errors());
					}
				}
				
				if (!empty($_FILES['chequebook_pic']['name'])) {
					if ($this->upload->do_upload('chequebook_pic')) {
			            $post['chequebook_pic'] = $this->upload->data('file_name');
			        } else {
						$error[] = array('error' => $this->upload->display_errors());
					}
				}

				$aff_rows = $this->candidate_model->updateCandidateInfo($post, $user_id);
				redirect('candidate-signup/update-house');
			// }
		}
		$data['app_info'] = $this->login_model->getApplicationInfo();
		$data['candidate'] = $get_candidate;
		$this->load->view('candidate-bank', $data, FALSE);
	}

	public function updateCandidateHouse($value='')
	{
		if (!$this->session->has_userdata('user_id')) { redirect('logout'); }
		$user_id = $this->session->userdata('user_id');
		$get_candidate = $this->candidate_model->getUser($user_id);
		if (!$get_candidate) { redirect('candidate-signup'); }
		if ($this->input->post()) {
			$config['upload_path']   = './assets/img/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = 20480;
			$config['encrypt_name']  = TRUE;

			$this->upload->initialize($config);

			$post = $this->input->post();
			// $this->form_validation->set_rules('whatsapp_number', 'WhatsApp Number', 'required');
			$this->form_validation->set_rules('father_name', 'Father Name', 'required');
			$this->form_validation->set_rules('aadhaar_number', 'Aadhaar Number', 'required|exact_length[12]|integer');

			// if (empty($_FILES['education_proof']['name'])) {
			// 	$this->form_validation->set_rules('education_proof', 'Education Proof', 'required');
			// }

			// if (empty($_FILES['signature']['name'])) {
			// 	$this->form_validation->set_rules('signature', 'Signature', 'required');
			// }

			if (empty($_FILES['aadhaar_card_back_pic']['name'])) {
				$this->form_validation->set_rules('aadhaar_card_back_pic', 'Aadhaar Back Photo', 'required');
			}

			if (empty($_FILES['aadhaar_card_front_pic']['name'])) {
				$this->form_validation->set_rules('aadhaar_card_front_pic', 'Aadhaar Front Photo', 'required');
			}

			// if (empty($_FILES['voter_id']['name'])) {
			// 	$this->form_validation->set_rules('voter_id', 'Voter ID Photo', 'required');
			// }

			// if (empty($_FILES['pancard_pic']['name'])) {
			// 	$this->form_validation->set_rules('pancard_pic', 'Pancard Photo', 'required');
			// }

			// if ($this->form_validation->run() == TRUE) {	
				if (!empty($_FILES['aadhaar_card_back_pic'])) {
					if ($this->upload->do_upload('aadhaar_card_back_pic')) {
						$post['aadhaar_card_back_pic'] = $this->upload->data('file_name');
					}
				}
	
				if (!empty($_FILES['aadhaar_card_front_pic'])) {
					if ($this->upload->do_upload('aadhaar_card_front_pic')) {
						$post['aadhaar_card_front_pic'] = $this->upload->data('file_name');
					}
				}
	
				if (!empty($_FILES['voter_id'])) {
					if ($this->upload->do_upload('voter_id')) {
						$post['voter_id'] = $this->upload->data('file_name');
					}
				}

				if (!empty($_FILES['pancard_pic'])) {
					if ($this->upload->do_upload('pancard_pic')) {
						$post['pancard_pic'] = $this->upload->data('file_name');
					}
				}
				
				if ($this->upload->do_upload('education_proof')) {
					$post['education_proof'] = $this->upload->data('file_name');
				}

				if ($this->upload->do_upload('signature')) {
					$post['signature'] = $this->upload->data('file_name');
				}

				$aff_rows = $this->candidate_model->updateCandidateInfo($post, $user_id);
				
				$app_info = $this->login_model->getApplicationInfo();

				if ($app_info['new_user_mail_notif'] == 'on') {
					$business = $this->business_model->get($get_candidate['company_id']);
					$templateKeys = [
						'name' => $get_candidate['firstname'] ." " . $get_candidate['middlename'] ." " . $get_candidate['lastname'],
						'firstname' => $get_candidate['firstname'],
						'middlename' => $get_candidate['middlename'],
						'lastname' => $get_candidate['lastname'],
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

					// $config_arr=[
					// 	'api_url' => $app_info['out_smtp'],
					// 	'sender_address' => $app_info['smtp_email'],
					// 	'to_address' => $get_candidate['email'],
					// 	'subject' => 'Account created successfully!',
					// 	'body' => $htmlContent,
					// 	'api_key' => $app_info['smtp_pass'],
					// 	'to_name' => $get_candidate['firstname']??'Simran Group'
					// ];

					// $email_response = sendMailViaApi($config_arr);

					$config_arr=[
						'out_smtp' => $app_info['out_smtp'],
						'smtp_port' => $app_info['smtp_port'],
						'smtp_email' => $app_info['smtp_email'],
						'smtp_pass' => $app_info['smtp_pass'],
						'app_name' => 'Simrangroups',
						'subject' => 'Account created successfully!',
						'body' => $htmlContent,
						'email' => $get_candidate['email'],
					];

					$email_response = sendMailViaSMTP($config_arr);

					$n_data['type'] = 'email';
					$n_data['user_id'] = $user_id;
					$n_data['notif_type'] = 'New Registration';
					$n_data['text'] = htmlspecialchars($htmlContent);
					$n_data['to_recipient'] = $get_candidate['email'];
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

				if ($app_info['new_user_sms_notif'] == 'on') {
					$databaseValues = [
						'name' => $get_candidate['firstname'] ." " . $get_candidate['middlename'] ." " . $get_candidate['lastname'],
						'firstname' => $get_candidate['firstname'],
						'middlename' => $get_candidate['middlename'],
						'lastname' => $get_candidate['lastname'],
						'company_name' => $app_info['app_name'],
						'login_url' => $app_info['cl_shortlink'],
						'login_qr' => '',
						'exam_date' => '',
						'exam_time' => '',
						'exam_datetime' => '',
						'business_name' => $business['company_name']??$site_data['app_name'],
						'business_addr' => $business['company_address']??'',
						'exam_login_url' => '',
					];
			
					$inputString = $app_info['new_registered'];
					$replacementString = $inputString;
			
					foreach ($databaseValues as $keys => $keyval) {
						$placeholder = '${' . $keys . '}';
						if (!empty($keyval)) {
							$replacementString = str_replace($placeholder, $keyval, $replacementString);
						} else {
							$replacementString = str_replace($placeholder, '', $replacementString);
						}
					}

					$url = 'http://www.text2india.store/vb/apikey.php';
		
					$params = [
						'apikey' => $app_info['sms_api_key'],
						'senderid' => $app_info['sms_sender_id'],
						'templateid' => $app_info['newusr_tempid'],
						'number' => $get_candidate['phone'],
						'message' => $replacementString
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
					$s_data['user_id'] = $user_id;
					$s_data['text'] = $replacementString;
					$s_data['notif_type'] = 'New Registration';
					$s_data['to_recipient'] = $get_candidate['phone'];
					$s_data['created_on'] = date('Y-m-d H:i:s');

					if ($sms_resp['Status'] == 'Success') {
						$s_data['response'] = 'success';
						$this->notif_model->insertLog($s_data);
					} else {
						$s_data['response'] = 'failed';
						$s_data['req_response'] = $sms_resp['description'];
						$this->notif_model->insertLog($s_data);
					}
				}
				redirect('registration-complete');
			// }
		}
		$data['app_info'] = $this->login_model->getApplicationInfo();
		$data['candidate'] = $get_candidate;
		$this->load->view('candidate-house', $data, FALSE);
	}

	public function file_required($value)
	{
	    if (empty($_FILES['aadhaar_card_back_pic']['name']) && empty($_FILES['aadhaar_card_front_pic']['name']) && empty($_FILES['voter_id']['name']) && empty($_FILES['pancard_pic']['name'])) {
	        $this->form_validation->set_message('file_required', 'At least one file is required.');
	        return FALSE;
	    } else {
	        return TRUE;
	    }
	}

	public function regComplete($value='')
	{
		if (!$this->session->has_userdata('user_id')) { redirect('logout'); }

		$user_id = $this->session->userdata('user_id');
		if ($this->session->userdata('type') == 'client') {
			$user = $this->client_model->getClientInfo($user_id);
			if (!$user) { redirect('client-signup'); }
		} else {
			$user= $this->candidate_model->get($user_id);
			$data['company'] = $this->business_model->get($user['company_id']);
			if (!$user) { redirect('candidate-signup'); }
		}

		$data['title'] = "Registration Complete";
		$data['app_info'] = $this->login_model->getApplicationInfo();
		$this->session->set_userdata('email', $user['email']);
		$this->session->sess_destroy();
		$this->load->view('registration-complete', $data);
	}

	public function client()
	{
		$data= [];

		if ($this->input->post()) {
			$post = $this->input->post();
			$post['type'] = 'client';
			$post['status'] = 'active';

			$this->form_validation->set_rules('firstname', 'First name', 'required');
			$this->form_validation->set_rules('lastname', 'Last name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[12]');
			$this->form_validation->set_rules('passconf', 'Confirm Password', 'required|min_length[8]|max_length[12]|matches[password]');
			$this->form_validation->set_rules('phone', 'Phone number', 'required|integer|exact_length[10]|is_unique[users.phone]', array(
                'is_unique'     => 'This %s already exists.'
	        ));
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]', array(
                'is_unique'     => 'This %s already registered.'
	        ));
			$this->form_validation->set_rules('company_name', 'Organisation name', 'required|is_unique[companies.company_name]', array(
                'is_unique'     => 'This %s is already in use.'
	        ));

			if ($this->form_validation->run() == TRUE) {
				$company = [];
				$company['company_name'] = trim(strip_tags(addslashes($post['company_name'])));
				$company_id = $this->business_model->create($company);
				$post['company_id'] = $company_id;
				$user_id = $this->client_model->create($post);
				$aff = $this->business_model->linkUsersToCompany($company_id, [$user_id]);
				$this->session->set_flashdata('success', 'Registration complete! Please login to continue');
		       	redirect('logout');
			}
		}

		$data['business_units'] = $this->business_model->get();

		$this->load->view('signup-client', $data, FALSE);
	}

	

}

/* End of file  */
/* Location: ./application/controllers/ */