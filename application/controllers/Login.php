<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';
use Detection\MobileDetect;

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Candidates_model', 'candidate_model');
		$this->load->model('Business_units_model', 'business_model');
		$this->load->model('Notification_model', 'notif_model');
	}

	public function admin() {
		$type = 'admin';
		if ($this->session->has_userdata('email')) {
			$email = $this->session->userdata('email');
			$record = $this->user_model->getByEmail($email, $type);
			if (!$record) { redirect('logout'); }
			$this->redirectToDashboard($type);
		} else if (get_cookie('email', TRUE)) {
			$email = $this->encryption->decrypt(get_cookie('email', TRUE));
			$record = $this->user_model->getByEmail($email, $type);
			if (!$record) { redirect('logout'); }
			$record['companies'] = $this->business_model->getAdminCompanies();
			$record['type'] = $type;
			$this->session->set_userdata($record);
			$this->redirectToDashboard($type);
		} else {
			$data['app_info'] = $this->Login_model->getApplicationInfo();
			$data['title'] = "Admin Login";

			if ($this->input->method() == 'post') {
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[12]');

				if ($this->form_validation->run() == FALSE){
					$this->load->view('app/new-login', $data);
				} else {
					$record = $this->Login_model->authenticate($this->input->post(), $type);

					if(empty($record)){
						$this->session->set_flashdata('error', 'Incorrect Email or Password!');
						redirect('admin-login');
					} else {

						if ($record['status'] == 'active') {
							if($this->input->post('remember')){
								$this->input->set_cookie('email', $this->encryption->encrypt(strtolower($this->input->post('email'))), 86400*30);
								$this->input->set_cookie('userid', $this->encryption->encrypt($record['id']), 86400*30);
							}
							$record['companies'] = $this->business_model->getAdminCompanies();
							$record['type'] = $type;
							$this->session->set_userdata($record);
							$this->redirectToDashboard($type);
						} else {
							$this->session->set_flashdata('error', 'You account has been blocked! Please contact Administrator for assistance.');
							redirect('admin-login');
						}
					}					
				}
			} else {
				if (get_cookie('email', TRUE)) {
					$data['email'] = $this->encryption->decrypt(get_cookie('email', TRUE));
				}
				$data['type'] = $type;
				$this->load->view('app/new-login', $data);
			}
		}
	}

	public function businessUnit() {
		$type = 'business unit';
		if ($this->session->has_userdata('email')) {
			$email = $this->session->userdata('email');
			$record = $this->user_model->getByEmail($email, $type);
			if (!$record) { redirect('logout'); }
			$this->redirectToDashboard($type);
		} else if (get_cookie('email', TRUE)) {
			$email = $this->encryption->decrypt(get_cookie('email', TRUE));
			$record = $this->user_model->getByEmail($email, $type);
			if (!$record) { redirect('logout'); }
			$record['companies'] = $this->business_model->getUserCompanies($record['id'], $type);
			$record['type'] = $type;
			$this->session->set_userdata($record);
			$this->redirectToDashboard($type);
		} else {
			$data['app_info'] = $this->Login_model->getApplicationInfo();
			$data['title'] = "Business Unit Login";

			if ($this->input->method() == 'post') {
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

				if ($this->form_validation->run() == FALSE){
					$this->load->view('app/new-login', $data);
				} else {
					$record = $this->Login_model->authenticate($this->input->post(), $type);

					if(empty($record)){
						$this->session->set_flashdata('error', 'Incorrect Email or Password!');
						redirect('business-login');
					} else {

						if ($record['status'] == 'active') {
							if($this->input->post('remember')){
								$this->input->set_cookie('email', $this->encryption->encrypt(strtolower($this->input->post('email'))), 86400*30);
								$this->input->set_cookie('userid', $this->encryption->encrypt($record['id']), 86400*30);
							}
							$record['companies'] = $this->business_model->getUserCompanies($record['id'], $type);
							$record['type'] = $type;
							$this->session->set_userdata($record);
							$this->redirectToDashboard($type);
						} else {
							$this->session->set_flashdata('error', 'You account has been blocked! Please contact Administrator for assistance.');
							redirect('business-login');
						}
					}					
				}
			} else {
				if (get_cookie('email', TRUE)) {
					$data['email'] = $this->encryption->decrypt(get_cookie('email', TRUE));
				}
				$data['type'] = 'business';
				$this->load->view('app/new-login', $data);
			}
		}
	}

	public function client() {
		$type = 'client';
		if ($this->session->has_userdata('email')) {
			$email = $this->session->userdata('email');
			$record = $this->user_model->getByEmail($email, $type);
			if (!$record) { redirect('logout'); }
			$this->redirectToDashboard($type);
		} else if (get_cookie('email', TRUE)) {
			$email = $this->encryption->decrypt(get_cookie('email', TRUE));
			$record = $this->user_model->getByEmail($email, $type);
			if (!$record) { redirect('logout'); }
			$record['companies'] = $this->business_model->getUserCompanies($record['id'], $type);
			$record['type'] = $type;
			$this->session->set_userdata($record);
			$this->redirectToDashboard($type);
		} else {
			$data['app_info'] = $this->Login_model->getApplicationInfo();
			$data['title'] = "Client Login";

			if ($this->input->method() == 'post') {
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

				if ($this->form_validation->run() == FALSE){
					$this->load->view('app/new-login', $data);
				} else {
					$record = $this->Login_model->authenticate($this->input->post(), $type);
					if(empty($record)){
						$this->session->set_flashdata('error', 'Incorrect Email or Password!');
						redirect('client-login');
					} else {

						if ($record['status'] == 'active') {
							if($this->input->post('remember')){
								$this->input->set_cookie('email', $this->encryption->encrypt(strtolower($this->input->post('email'))), 86400*30);
								$this->input->set_cookie('userid', $this->encryption->encrypt($record['id']), 86400*30);
							}
							$record['companies'] = $this->business_model->getUserCompanies($record['id'], $type);
							$record['type'] = $type;
							$this->session->set_userdata($record);
							$this->redirectToDashboard($type);
						} else {
							$this->session->set_flashdata('error', 'You account has been blocked! Please contact Administrator for assistance.');
							redirect('client-login');
						}
					}					
				}
			} else {
				if (get_cookie('email', TRUE)) {
					$data['email'] = $this->encryption->decrypt(get_cookie('email', TRUE));
				}
				$data['type'] = $type;
				$this->load->view('app/new-login', $data);
			}
		}
	}

	public function candidate($value='')
	{
		$type = 'candidate';
		if ($value) { redirect('https://candidate.simrangroups.com/exam/'.$value); }
		if ($this->session->has_userdata('email')) {
			$email = $this->session->userdata('email');
			$record = $this->user_model->getByEmail($email, $type);
			if (!$record) { redirect('logout'); }
			$record['companies'] = $this->business_model->getUserCompanies(null, 'admin');
			$record['type'] = $type;
			$this->session->set_userdata($record);
			if ($value) { redirect('exams/'.$value.'/begin'); }
			else { $this->redirectToDashboard($type); }
		} else if (get_cookie('email', TRUE)) {
			$email = $this->encryption->decrypt(get_cookie('email', TRUE));
			$record = $this->user_model->getByEmail($email, $type);
			if (!$record) { redirect('logout'); }
			$record['companies'] = $this->business_model->getUserCompanies(null, 'admin');
			$record['type'] = $type;
			$this->session->set_userdata($record);
			if ($value) { redirect('https://candidate.simrangroups.com/exam/'.$value); }
			else { $this->redirectToDashboard($type); }
		} else {
			$data['app_info'] = $this->Login_model->getApplicationInfo();
			$data['title'] = "Candidate Login";

			if (get_cookie('email', TRUE)) {
				$data['email'] = $this->encryption->decrypt(get_cookie('email', TRUE));
			}
			$data['type'] = $type;
			if ($this->input->method() == 'post') {
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

				if ($this->form_validation->run() == FALSE){
					$this->load->view('app/new-login', $data);
				} else {
					$record = $this->Login_model->authenticate($this->input->post(), $type);
					if(empty($record)){
						$this->session->set_flashdata('error', 'Incorrect Email or Password!');
						redirect('candidate-login');
					} else {

						// $extra_details = $this->candidate_model->getUserDetails($record['id']);
						// if (
						// 	empty($extra_details['pa_address']) || 
						// 	empty($extra_details['pa_city']) || 
						// 	empty($extra_details['pa_dist']) || 
						// 	empty($extra_details['pa_pin']) || 
						// 	empty($extra_details['pa_state']) || 
						// 	empty($extra_details['ca_address']) || 
						// 	empty($extra_details['ca_city']) || 
						// 	empty($extra_details['ca_dist']) || 
						// 	empty($extra_details['ca_pin']) || 
						// 	empty($extra_details['ca_state']) 
						// ) {
						// 	$this->session->set_userdata('user_id', $record['id']);
						// 	redirect('candidate-signup/update-address');
						// }

						// if (
						// 	empty($extra_details['bank_name']) || 
						// 	empty($extra_details['account_num']) || 
						// 	empty($extra_details['ifsc_code']) || 
						// 	empty($extra_details['passbook_pic']) || 
						// 	empty($extra_details['chequebook_pic'])
						// ) {
						// 	$this->session->set_userdata('user_id', $record['id']);
						// 	redirect('candidate-signup/update-bank');
						// }

						// if (
						// 	empty($extra_details['father_name']) || 
						// 	empty($extra_details['marital_status']) || 
						// 	(empty($extra_details['aadhaar_card_front_pic']) || empty($extra_details['aadhaar_card_back_pic'])) 
						// ) {
						// 	$this->session->set_userdata('user_id', $record['id']);
						// 	redirect('candidate-signup/update-house');
						// }

						if ($record['status'] == 'active') {
							if($this->input->post('remember')){
								$this->input->set_cookie('email', $this->encryption->encrypt(strtolower($this->input->post('email'))), 86400*30);
								$this->input->set_cookie('userid', $this->encryption->encrypt($record['id']), 86400*30);
							}

							$record['companies'] = $this->business_model->getUserCompanies(null, 'admin');
							$record['type'] = $type;
							$this->session->set_userdata($record);

							$logs_arr = [
								"type" => 'candidate',
								"user_id" => $record['id'],
								"datetime" => date('Y-m-d H:i:s'),
								"ip_address" => $this->getIpAddress(),
								"mac_address" => $this->getMacAddress(),
								"client" => $this->getBrowserInfo()
							];
							
							$this->Login_model->captureLog($logs_arr);

							if ($value) {
								$app_info = $this->Login_model->getApplicationInfo();

								$this->session->set_userdata('app_name', $app_info['app_name']);
								$this->session->set_userdata('app_icon', $app_info['app_icon']);
								redirect('exams/'.$value.'/begin');
							} else {
								if (empty($record['profile_img']) && $record['source'] == 'bulk') {
									redirect('update-profile-image');
								} else {
									$this->redirectToDashboard($type);
								}								
							}
						} else {
							$this->session->set_flashdata('error', 'You account has been blocked! Please contact Administrator for assistance.');
							redirect('candidate-login');
						}
					}					
				}
			} else {
				$this->load->view('app/new-login', $data);
			}
		}
	}

	public function logout() {
		$type = $this->session->userdata('type');
		$this->session->set_flashdata('success', 'You\'ve been logged out!');
        $this->session->sess_destroy();
        delete_cookie('userid');
        delete_cookie('email');
		if ($type == 'candidate') {
			redirect(base_url('candidate-login'));
		} else if ($type == 'client') {
			redirect(base_url('client-login'));
		} else if ($type == 'business unit') {
			redirect(base_url('business-login'));
		} else {
			redirect(base_url('admin-login'));
		}   
    }

    public function redirectToDashboard($type=''){
    	if ($type == "candidate" || $type == "client") {
    		redirect('dashboard');
		} else {
			if ($type == "admin") {
				redirect('dashboard');
			} else {
				redirect('dashboard?company='.$_SESSION['companies'][0]['id']);
			}			
		}
    }

	public function forgotPassword($type='') {
		$data['title'] = 'Forgot Password';
		$data['app_info'] = $this->Login_model->getApplicationInfo();
		$type = ($type=='business')?'business unit':$type;

		if ($this->input->post()) {
			$post = $this->input->post();
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			if ($this->form_validation->run()){
				$post['email'] = strtolower($post['email']);
				$data['email'] = $post['email'];

				$record = $this->user_model->getByEmail($post['email'], $type);

				if (!$record) {
					$this->session->set_flashdata('error', 'Email is not registered!');
					redirect($type . '/forgot-password');
				}

				$token = uniqid();
				$indata['authtoken'] = $token;
				$this->user_model->updateUserData($indata, $record['id'], $type);
				$post['link'] = base_url($type.'/reset-password?token='.$token);
				$short_url = shortenLink($post['link']);
				$surl_arr = json_decode($short_url, true);				
				$post['short_url'] = ($surl_arr['status']=='SUCCESS')?$surl_arr['link']:'';
				$post['firstname'] = trim($record['firstname']. " " .$record['lastname']);
				$htmlContent = $this->load->view('app/mail/reset-password', $post, true);

				if ($data['app_info']['mail_type'] == 'api') {
					$config_arr=[
						'api_url' => $data['app_info']['out_smtp'],
						'sender_address' => $data['app_info']['smtp_email'],
						'to_address' => $post['email'],
						'subject' => 'Reset Password Link!',
						'body' => $htmlContent,
						'api_key' => $data['app_info']['smtp_pass'],
						'to_name' => $post['firstname']
					];

					$email_response = sendMailViaApi($config_arr);
				} else {
					$config_arr=[
						'out_smtp' => $data['app_info']['out_smtp'],
						'smtp_port' => $data['app_info']['smtp_port'],
						'smtp_email' => $data['app_info']['smtp_email'],
						'smtp_pass' => $data['app_info']['smtp_pass'],
						'app_name' => $data['app_info']['app_name'],
						'subject' => 'Reset Password Link!',
						'body' => $htmlContent,
						'email' => $post['email'],
					];

					$email_response = sendMailViaSMTP($config_arr);	
				}

				$n_data['type'] = 'email';
				$n_data['user_id'] = $record['id'];
				$n_data['notif_type'] = 'Forgot Password';
				$n_data['text'] = htmlspecialchars($htmlContent);
				$n_data['to_recipient'] = $record['email'];
				$n_data['created_on'] = date('Y-m-d H:i:s');

				if ($email_response) {
					$n_data['response'] = 'success';
					$this->notif_model->insertLog($n_data);
					$success[] = $record['id'];
				} else {
					$n_data['response'] = 'failed';
					$n_data['req_response'] = $email_response;
					$this->notif_model->insertLog($n_data);
					$error[] = $record['id'];
				}
				
				$templateKeys = [
					'name' => $record['firstname'] ." " . $record['middlename'] ." " . $record['lastname'],
					'firstname' => $record['firstname'],
					'middlename' => $record['middlename'],
					'lastname' => $record['lastname'],
					'company_name' => $data['app_info']['app_name'],
					'login_url' => $data['app_info']['cl_shortlink'],
					'login_qr' => base_url('assets/admin/img/qrcodes/candidate-login.png'),
					'exam_date' => '',
					'exam_time' => '',
					'exam_datetime' => '',
					'business_name' => $business['company_name']??$data['app_info']['app_name'],
					'business_addr' => $business['company_address']??'',
					'exam_login_url' => '',
					'reset_password_url' => $post['short_url']
				];

				$inputString = $data['app_info']['fp_sms'];
				$replacementString = $inputString;

				foreach ($templateKeys as $key => $obj) {
					$placeholder = '${' . $key . '}';
					if (!empty($obj)){
						$replacementString = str_replace($placeholder, $obj, $replacementString);
					} else {
						$replacementString = str_replace($placeholder, '', $replacementString);
					}
				}

				$url = 'http://www.text2india.store/vb/apikey.php';

				$params = [
					'apikey' => $data['app_info']['sms_api_key'],
					'senderid' => $data['app_info']['sms_sender_id'],
					'templateid' => $data['app_info']['fp_sms_tempid'],
					'number' => $record['phone'],
					'message' => $replacementString,
				];

				$url .= '?' . http_build_query($params);
				
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
				));
				$response = curl_exec($curl);

				$s_data['type'] = 'sms';
				$s_data['user_id'] = $record['id'];
				$s_data['notif_type'] = 'Forgot Password';
				$s_data['text'] = $replacementString;
				$s_data['to_recipient'] = $record['phone'];
				$s_data['created_on'] = date('Y-m-d H:i:s');
				$sms_resp = json_decode($response, true);
				if ($sms_resp['status'] == 'Success') {
					$s_data['response'] = 'success';
					$s_data['req_response'] = $sms_resp['description'];
					$this->notif_model->insertLog($s_data);
				} else {
					$s_data['response'] = 'failed';
					$s_data['req_response'] = $sms_resp['description'];
					$this->notif_model->insertLog($s_data);
				}

				$this->session->set_flashdata('success', 'Reset link has been sent to you!');
				redirect('candidate-login');
			}
		}

		$this->load->view('forgot-password', $data);
	}

	public function resetPassword() {
		$data['title'] = 'Reset Password';
		$data['app_info'] = $this->Login_model->getApplicationInfo();
		$type="candidate";
		$token=$this->input->get('token', true);
		if (!$token) { redirect('candidate-login'); }
		$record = $this->user_model->getByToken($token, $type);
		if (!$record) { redirect('candidate-login'); }

		if ($this->input->post()) {
			$post = $this->input->post();
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[12]');
			$this->form_validation->set_rules('passconf', 'Confirm Password', 'required|min_length[8]|max_length[12]|matches[password]');
			if ($this->form_validation->run()){
				$indata['password'] = $post['password'];
				$indata['authtoken'] = "";
				$this->candidate_model->updateCandidate($indata, $record['id']);
				$this->session->set_flashdata('success', 'Password set successfully');
				redirect('candidate-login');
			}
		}
		$this->load->view('app/reset-password', $data);
	}

	public function getIpAddress() {
		$client_ip = "";
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$client_ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$client_ip = $_SERVER['REMOTE_ADDR'];
		}

		return $client_ip;
	}

	public function getBrowserInfo() {

		$detect = new MobileDetect();

		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		return $deviceType;
	}

	public function getMacAddress() {
		ob_start();
		system('getmac');
		$Content = ob_get_contents();
		ob_clean();
		return substr($Content, strpos($Content,'\\')-20, 17);
	}

	public function updateProfilePhoto($value='') {
		if (!$this->session->has_userdata('id')) { redirect('logout'); }
		$data['candidate'] = $this->candidate_model->get($this->session->userdata('id'));
		if (!$data['candidate']) { redirect('logout'); }
		if ($this->input->post()) {
			$post = $this->input->post();
			$this->form_validation->set_rules('userid', 'Userid', 'required');
			if (empty($_FILES['profile_img']['name'])) { 
				$this->form_validation->set_rules('profile_img', 'Passport Size Photo', 'required'); 
			}

			if ($this->form_validation->run() == TRUE) {
				$config['upload_path']   = './assets/img/';
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size']      = 20480;
		        $config['encrypt_name']  = TRUE;

		        $this->upload->initialize($config);
				if ($this->upload->do_upload('profile_img')) {
		            $updateData['profile_img'] = $this->upload->data('file_name');
		            // createThumbnail($updateData['profile_img'])
		            $row_aff = $this->candidate_model->updateCandidate($updateData, $post['userid']);
		            if ($row_aff) {
		            	redirect('dashboard');
		            } else {
		            	$this->session->set_flashdata('error', 'Something went wrong!');
		            	redirect('logout');
		            }
		        } else {
		        	$this->session->set_flashdata('error', $this->upload->display_errors());
		        }
			}
		}

		$this->load->view('candidate-profile-img', $data);
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */