<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Settings_model', 'setting_model');
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Clients_model', 'client_model');
		$this->load->model('Business_units_model', 'business_model');
		$this->load->model('Candidates_model', 'candidate_model');
	}

	public function isValidUser($value='')
	{
		if (!$this->session->has_userdata('id')) {
			redirect('logout');
		}
	}

	public function isAdmin($value='')
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') != 'admin') {
			redirect('logout');
		}
	}

	public function isBusinessUnitOrClient($value='')
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') == 'admin' || $this->session->userdata('type') == 'candidate') {
			redirect('logout');
		}
	}

	public function isBusinessUnit($value='')
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') == 'admin' || $this->session->userdata('type') == 'candidate' || $this->session->userdata('type') == 'client') {
			redirect('logout');
		}
	}

	public function index()
	{
		$this->isValidUser();
		$data['title'] = 'Settings';

		$this->load->view('app/settings', $data);
	}

	public function site()
	{
		$this->isAdmin();
		$data['title'] = 'Application Settings';
		$data['record'] = $this->setting_model->getSiteSetting();
		if ( $this->input->post() ) {
			$post = $this->input->post();
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 2048;
	        $config['encrypt_name']  = TRUE;

	        $this->upload->initialize($config);

			$this->form_validation->set_rules('app_name', 'Application name', 'required');

			if ($this->form_validation->run() == TRUE) {

				$post['app_name'] = trim(strip_tags(addslashes($post['app_name'])));

				if (!empty($_FILES['app_icon'])) {
					if ($this->upload->do_upload('app_icon')) {
			            $post['app_icon'] = $this->upload->data('file_name');
			            $this->session->set_userdata('app_icon', $post['app_icon']);
			        }
		        }
		        if (empty($data['record'])) {
			        $this->setting_model->insert($post);
		        } else {
			        $this->setting_model->update($post, $data['record']['id']);
		        }

		        $this->session->set_userdata('app_name', $post['app_name']);

		        $this->session->set_flashdata('success', 'Settings updated successfully!');
		        redirect('settings');
			}
		}

		$this->load->view('app/site-settings', $data);
	}

	public function profile()
	{
		$this->isValidUser();
		$user_id = $this->session->userdata('id');
		$data['title'] = 'Profile Settings';

		if ( $this->session->userdata('type') == 'candidate' ) {
			$data['record'] = $this->candidate_model->get($user_id);
			$data['udetails'] = $this->candidate_model->getUserDetails($user_id);
		} else if ( $this->session->userdata('type') == 'client' ) { 
			$data['record'] = $this->client_model->getClient($user_id);
		} else if ( $this->session->userdata('type') == 'business unit' ) { 
			$data['record'] = $this->business_model->getManager($user_id);
		} else {
			$data['record'] = $this->user_model->get($user_id);
		}

		if ( $this->input->post() ) {
			$post = $this->input->post();
			

	        $this->form_validation->set_rules('firstname', 'First name', 'required');
	        $this->form_validation->set_rules('lastname', 'Last name', 'required');
			$this->form_validation->set_rules('phone', 'Phone number', 'required|integer|exact_length[10]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run() == TRUE) {
		        if (!empty($_FILES['profile_img_file'])) {
		        	$config['upload_path']   = './assets/img/';
			        $config['allowed_types'] = 'gif|jpg|jpeg|png';
			        $config['max_size']      = 2048;
			        $config['encrypt_name']  = TRUE;

			        $this->upload->initialize($config);
					if ($this->upload->do_upload('profile_img_file')) {
			            $post['profile_img'] = $this->upload->data('file_name');
			            $this->session->set_userdata('profile_img', $post['profile_img']);
			        }
		        }
		        
		        if ($data['record']['email'] != $post['email'] || $data['record']['phone'] != $post['phone']) {
		        	$this->session->set_userdata( 'reserved', $post );
		        	$otp = rand(1000, 9999);
		        	$updata = [ 'authtoken' => $otp ];
		        	if ( $this->session->userdata('type') == 'candidate' ) {
						$this->candidate_model->updateCandidate($updata, $user_id);
					} else if ( $this->session->userdata('type') == 'client' ) { 
						$this->client_model->genericUpdate($updata, $user_id);
					} else if ( $this->session->userdata('type') == 'business unit' ) { 
						$this->business_model->updateManager($updata, $user_id);
					} else {
						$this->user_model->updateUser($updata, $user_id);
					}

					$this->sendOTPEmail($user_id, $otp);
					$this->sendOTPSms($user_id, $otp);
		        	redirect('settings/profile/verify-otp');
		        } else {
		        	if ( $this->session->userdata('type') == 'candidate' ) {
						$data['record'] = $this->candidate_model->updateCandidate($post, $user_id);
					} else if ( $this->session->userdata('type') == 'client' ) { 
						$data['record'] = $this->client_model->update($post, $user_id);
					} else if ( $this->session->userdata('type') == 'business unit' ) { 
						$data['record'] = $this->business_model->updateManager($post, $user_id);
					} else {
						$data['record'] = $this->user_model->updateUser($post, $user_id);
					}
					$this->session->set_userdata('firstname', $post['firstname']);
			        $this->session->set_userdata('middlename', $post['middlename']);
			        $this->session->set_userdata('lastname', $post['lastname']);
			        
			        $this->session->set_flashdata('success', 'Profile updated successfully!');
			        redirect('settings');
		        }
			}
		}
		$this->load->view('app/profile-settings', $data);
	}

	public function verifyOTP()
	{
		$this->isValidUser();
		$user_id = $this->session->userdata('id');
		$data['title'] = 'Verify OTP';
		if ( $this->session->userdata('type') == 'candidate' ) {
			$data['record'] = $this->candidate_model->get($user_id);
		} else if ( $this->session->userdata('type') == 'client' ) { 
			$data['record'] = $this->client_model->getClient($user_id);
		} else if ( $this->session->userdata('type') == 'business unit' ) { 
			$data['record'] = $this->business_model->getManager($user_id);
		} else {
			$data['record'] = $this->user_model->get($user_id);
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('authtoken', 'OTP', 'required|integer|exact_length[4]');
			if ($this->form_validation->run() == TRUE) {
				$authtoken = $this->input->post('authtoken')??'';
				if ($data['record']['authtoken'] != $authtoken) {
					$this->session->set_flashdata('error', 'OTP is not correct! Please retry.');
				}else {
					$post = $_SESSION['reserved'];
					if ( $this->session->userdata('type') == 'candidate' ) {
						$this->candidate_model->updateCandidate($post, $user_id);
					} else if ( $this->session->userdata('type') == 'client' ) { 
						$this->client_model->update($post, $user_id);
					} else if ( $this->session->userdata('type') == 'business unit' ) { 
						$this->business_model->updateManager($post, $user_id);
					} else {
						$this->user_model->update($post, $user_id);
					}
					$this->session->set_userdata('firstname', $post['firstname']);
			        $this->session->set_userdata('middlename', $post['middlename']);
			        $this->session->set_userdata('lastname', $post['lastname']);
			        
			        $this->session->set_flashdata('success', 'Profile updated successfully!');
			        redirect('settings');
				}
				
			}
		}

		$this->load->view('app/verify-otp', $data);
	}

	public function changePassword()
	{
		$this->isValidUser();
		$user_id = $this->session->userdata('id');
		$data['title'] = 'Change Password';
		// $record = $this->user_model->get($user_id);
		// if (!$record) { redirect('logout'); }

		if ( $this->input->post() ) {
			$post = $this->input->post();
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 2048;
	        $config['encrypt_name']  = TRUE;

	        $this->upload->initialize($config);

	        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[12]');
	        $this->form_validation->set_rules('passconf', 'Password', 'required|min_length[8]|max_length[12]|matches[password]');

			if ($this->form_validation->run() == TRUE) {
				unset($post['passconf']);
				if ( $this->session->userdata('type') == 'candidate' ) {
					$post['password'] = md5($post['password']);
					$data['record'] = $this->candidate_model->updateCandidate($post, $user_id);
				} else if ( $this->session->userdata('type') == 'client' ) { 
					$data['record'] = $this->client_model->updatePassword($post,$user_id);
				} else if ( $this->session->userdata('type') == 'business unit' ) { 
					$data['record'] = $this->business_model->updateManager($post, $user_id);
				} else {
					$data['record'] = $this->user_model->updatePassword($post, $user_id);
				}
		        $this->session->set_flashdata('success', 'Password updated successfully!');
		        redirect('settings');
			}
		}

		$this->load->view('app/change-password', $data);
	}

	public function company()
	{
		$this->isBusinessUnitOrClient();
		$user_id = $this->session->userdata('id');
		$data['title'] = 'Company Settings';
		$company_id = $this->input->get('company_id', true)??$_SESSION['companies'][0]['id'];
		$type = $this->session->userdata('type');
		$data['record'] = $this->client_model->getCompanyData($company_id, $type);
		if (!$data['record']) { 
			$this->session->set_flashdata('error', 'Company does not exists!');
			redirect('settings'); 
		}

		if ( $this->input->post() ) {
			$post = $this->input->post();
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 2048;
	        $config['encrypt_name']  = TRUE;

	        $this->upload->initialize($config);
	        $this->form_validation->set_rules('company_name', 'Company name', 'required');

	        if ($this->form_validation->run() == TRUE) {
	        	$company = [];
				$company['company_name'] = trim(strip_tags(addslashes($post['company_name'])));
				$company['company_about'] = trim(strip_tags(addslashes($post['company_about'])));

		        if (!empty($_FILES['company_logo'])) {
		        	if ($this->upload->do_upload('company_logo')) {
			            $company['company_logo'] = $this->upload->data('file_name');
			        } 
		        }

		        $this->business_model->updateCompany($company, ['id'=>$company_id]);

		        $this->session->set_flashdata('success', 'Company updated successfully!');
		        redirect('settings');
			}
		}

		$this->load->view('app/company-settings', $data);
	}

	public function companies()
	{
		$this->isBusinessUnit();
		$user_id = $this->session->userdata('id');
		$type = $this->session->userdata('type');
		$data['title'] = 'Companies Settings';
		
		$data['companies'] = $this->business_model->getUserCompanies($user_id, $type);
		$this->load->view('app/companies-settings', $data);
	}

	public function myAccount() 
	{
		$this->isValidUser();
		$user_id = $_SESSION['id'];
		$type = $_SESSION['type'];
		$data['title'] = "My Account";

		if ($type == 'admin') {
			$data['profile'] = $this->user_model->getProfile($user_id, $type);
		} else if ($type == 'business unit') {
			$data['profile'] = $this->business_model->getManager($user_id);
		} else if ($type == 'client') { 
			$data['profile'] = $this->client_model->get($user_id);
		} else {
			$data['profile'] = $this->candidate_model->get($user_id);
		}

		
		if ( $type == 'admin' ) {
			$data['companies'] = $this->business_model->getAdminCompanies();
		} else {
			$data['companies'] = $this->business_model->getUserCompanies($user_id, $type);
		}

		// echo "<pre>";
		// print_r($data);
		// exit();
		
		$this->load->view('app/my-profile', $data);
	}

	public function smsTemplates() {
		$this->isAdmin();
		$data['title'] = "SMS Template Setting";
		$data['site_data'] = $this->setting_model->getSiteSetting();
		if ( $this->input->post() ) {
			$post = $this->input->post();
			$this->setting_model->update($post, $data['site_data']['id']);
			$this->session->set_flashdata('success', 'Template Saved successfully!');
			redirect('settings');
		}
		$this->load->view('app/sms-templates', $data);
	}

	public function emailTemplates() {
		$this->isAdmin();
		$data['title'] = "Email Template Setting";
		$data['site_data'] = $this->setting_model->getSiteSetting();
		if ( $this->input->post() ) {
			$post = $this->input->post();
			$post['scheduled_exam_mail'] = (!empty($post['scheduled_exam_mail']))?htmlspecialchars($post['scheduled_exam_mail']):'';
			$post['new_user_mail'] = (!empty($post['scheduled_exam_mail']))?htmlspecialchars($post['new_user_mail']):'';
			$post['candidate_login_mail'] = (!empty($post['scheduled_exam_mail']))?htmlspecialchars($post['candidate_login_mail']):'';
			if(!isset($post['new_user_mail_notif'])) $post['new_user_mail_notif'] = 'off';

			$this->setting_model->update($post, $data['site_data']['id']);
			$this->session->set_flashdata('success', 'Template successfully!');
			redirect('settings');
		}
		$this->load->view('app/email-templates', $data);
	}

	public function sendOTPEmail($user_id='', $otp='')
	{
		if(!$user_id || !$otp) { redirect('settings/profile'); }

		if ( $this->session->userdata('type') == 'candidate' ) {
			$user = $this->candidate_model->get($user_id);
		} else if ( $this->session->userdata('type') == 'client' ) { 
			$user = $this->client_model->getClient($user_id);
		} else if ( $this->session->userdata('type') == 'business unit' ) { 
			$user = $this->business_model->getManager($user_id);
		} else {
			$user = $this->user_model->get($user_id);
		}

		if (!$user) { redirect('settings/profile'); }

		$site_data = $this->setting_model->getSiteSetting();
		$business = $this->business_model->get($user['company_id']);
		$email_html = [
			'name' => $user['firstname'] . " " . $user['lastname'],
			'otp' => $otp,
			'company_name' => $business['company_name'],
			'company_logo' => $business['company_logo'],
			'company_address' => $business['company_address']
		];
		$htmlContent = $this->load->view('app/mail/otp-mail-template', $email_html, true);
		if ($site_data['mail_type'] == 'api') {
			$config_arr=[
				'api_url' => $site_data['out_smtp'],
				'sender_address' => $site_data['smtp_email'],
				'to_address' => $user['email'],
				'subject' => 'Verify OTP to update your profile!',
				'body' => $htmlContent,
				'api_key' => $site_data['smtp_pass'],
				'to_name' => $user['firstname']??'Simran Group'
			];

			$email_response = sendMailViaApi($config_arr);
		} else {
			$config_arr=[
				'out_smtp' => $site_data['out_smtp'],
				'smtp_port' => $site_data['smtp_port'],
				'smtp_email' => $site_data['smtp_email'],
				'smtp_pass' => $site_data['smtp_pass'],
				'app_name' => 'Simrangroups',
				'subject' => 'Use this OTP to update your profile!',
				'body' => $htmlContent,
				'email' => $user['email'],
			];

			$email_response = sendMailViaSMTP($config_arr);
		}
		
	}

	public function sendOTPSms($user_id=[], $otp='')
	{
		if(!$user_id || !$otp) { redirect('settings/profile'); }

		if ( $this->session->userdata('type') == 'candidate' ) {
			$user = $this->candidate_model->get($user_id);
		} else if ( $this->session->userdata('type') == 'client' ) { 
			$user = $this->client_model->getClient($user_id);
		} else if ( $this->session->userdata('type') == 'business unit' ) { 
			$user = $this->business_model->getManager($user_id);
		} else {
			$user = $this->user_model->get($user_id);
		}

		if (!$user) { redirect('settings/profile'); }

		$site_data = $this->setting_model->getSiteSetting();
		$business = $this->business_model->get($user['company_id']);

		$url = 'http://www.text2india.store/vb/apikey.php';
		
		$params = [
			'apikey' => $site_data['sms_api_key'],
			'senderid' => $site_data['sms_sender_id'],
			'templateid' => $site_data['otp_tempid'],
			'number' => $user['phone'],
			'message' => 'Hello ' . $user['firstname'] . ', To update account you can use this one-time OTP: ' . $otp,
		];

		$url .= '?' . http_build_query($params);
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
		));
		$response = curl_exec($curl);
	}
}

/* End of file  */
/* Location: ./application/controllers/ */