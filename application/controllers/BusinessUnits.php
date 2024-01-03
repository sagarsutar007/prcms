<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BusinessUnits extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Business_units_model', 'business_model');
	}

	public function isValidUser($value='')
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') != "admin") {
			redirect('logout');
		}
	}

	public function index()
	{
		$this->isValidUser();
		if(isset($_GET['limit'])){
			$limit = (int) $_GET['limit'];
		} else {
			$limit = 10;
		}
		// $data['total'] = $this->business_model->count();
		// $page = isset($_GET['page'])?$_GET['page']:1;
		// $offset = ($page - 1) * $limit;
		$order = $_GET['order']??'DESC';
		// $data['results'] = $this->business_model->get_data($limit, $offset, $order);
		$data['results'] = $this->business_model->get_data(NULL, NULL, $order);
		// $data['limit'] = $limit;
	    // $data['page'] = $page;
	    $data['order'] = $order;

		$this->load->view('app/business-units', $data);
	}

	public function create()
	{
		$this->isValidUser();
		$data['title'] = "Create Business Unit";
		if ($this->input->post()) {
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 20480;
	        $config['encrypt_name']  = TRUE;
	        $exec_script = TRUE;

	        $this->upload->initialize($config);

	        $post = $this->input->post();

	        if (isset($post['create_user'])) {

		        $this->form_validation->set_rules('firstname', 'First name', 'required');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[12]');
				$this->form_validation->set_rules('phone', 'Phone number', 'integer|exact_length[10]|is_unique[business_units.phone]');
				$this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[business_units.email]');

				if ($this->form_validation->run() == TRUE) {
			        if (!empty($_FILES['profile_img_file'])) {
						if ($this->upload->do_upload('profile_img_file')) {
				            $post['profile_img'] = $this->upload->data('file_name');
				        }
			        }
			        $last_user_id = $this->business_model->insertManager($post);
				} else {
			        $exec_script = FALSE;
				}
			}
			if ($exec_script) {
				if (isset($post['create_user']) ) {
					$user_id = [$last_user_id];
				} else {
					$user_id = (!empty($post['user_ids']))?$post['user_ids']:[];
				}

				$this->form_validation->reset_validation();
				$this->form_validation->set_rules('company_name', 'Company name', 'required|is_unique[companies.company_name]');
				if (empty($user_id)) { $this->form_validation->set_rules('user_ids', 'Manager', 'required');}
				if ($this->form_validation->run() == TRUE) {
					$company = [];
					$company['company_name'] = trim(strip_tags(addslashes($post['company_name'])));
					$company['company_address'] = trim(strip_tags(addslashes($post['company_address'])));
					$company['company_about'] = trim(strip_tags(addslashes($post['company_about'])));
			        if (!empty($_FILES['company_logo_file'])) {
			        	$config = [];
			        	$config['upload_path']   = './assets/img/companies/';
				        $config['allowed_types'] = 'gif|jpg|jpeg|png';
				        $config['max_size']      = 20480;
				        $config['encrypt_name']  = TRUE;

				        $this->upload->initialize($config);
			        	if ($this->upload->do_upload('company_logo_file')) {
				            $company['company_logo'] = $this->upload->data('file_name');
				        } 
			        }

			        $company_id = $this->business_model->create($company);
			        if ($company_id) {
			        	$this->business_model->linkUsersToCompany($company_id, $user_id);
			        	$this->session->set_flashdata('success', 'Business unit created successfully!');
			        	redirect('business-units');
			        } else {
						$this->session->set_flashdata('error', 'Can\'t create business unit!');
			        }
				}
			} else {
				$this->session->set_flashdata('error', 'Something went wrong!');
			}
	    }

	    $data['users'] = $this->user_model->getManagers();
	    
	    $this->load->view('app/manage-business-unit', $data);
	}

	public function edit($value='')
	{
		$this->isValidUser();
		$data['title'] = "Edit Business Unit";
		$data['company'] = $this->business_model->get($value);
		if (!$data['company']) { redirect('business-units'); }

		if ($this->input->post()) {

			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 20480;
	        $config['encrypt_name']  = TRUE;

	        $this->upload->initialize($config);

	        $post = $this->input->post();
			$user_id = $post['user_ids']??[];

			$this->form_validation->reset_validation();
	        $this->form_validation->set_rules('company_name', 'Company name', 'required');

			if ($this->form_validation->run() == TRUE) {
				$company = [];
				$company['company_name'] = trim(strip_tags(addslashes($post['company_name'])));
				$company['company_address'] = trim(strip_tags(addslashes($post['company_address'])));
					$company['company_about'] = trim(strip_tags(addslashes($post['company_about'])));
		        if (!empty($_FILES['company_logo_file'])) {
		        	$config = [];
		        	$config['upload_path']   = './assets/img/companies/';
			        $config['allowed_types'] = 'gif|jpg|jpeg|png';
			        $config['max_size']      = 20480;
			        $config['encrypt_name']  = TRUE;

			        $this->upload->initialize($config);
		        	if ($this->upload->do_upload('company_logo_file')) {
			            $company['company_logo'] = $this->upload->data('file_name');
			        } 
		        }

		        $aff_row = $this->business_model->updateCompany($company, ['id'=>$value]);

				if (count($user_id) === 0 ){
					$this->session->set_flashdata('error', 'Atleast One manager is needed for a business unit!');
				} else {
					$this->business_model->removeUsersFromCompany($value);
					foreach ($user_id as $key => $obj) {
						$this->business_model->linkUsersToCompany($value, [$obj], 'business unit');
					}
					$this->session->set_flashdata('success', 'Business unit updated successfully!');
				}
	        	
	        	redirect('business-units');
			}
		}

		$assoc_users = $this->business_model->getCompanyUsers($data['company']['id']);

		foreach ($assoc_users as $key => $obj) {
			$data['assoc_users'][] = $obj['id'];
		}

	    $data['users'] = $this->user_model->getManagers();
		
	    $this->load->view('app/manage-business-unit', $data);
	}

	public function delete($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('business-units'); }
		$record = $this->business_model->get($value);
		if (!$record) { redirect('business-units'); }

		$aff_rows = $this->business_model->removeBusiness($value);

		if ($aff_rows) {
			$this->session->set_flashdata('success', 'Business unit removed successfully!');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong!');
		}

		redirect('business-units');
	}

	public function deleteMultiple()
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') != "admin") {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		$post = $this->input->post();
		$ids = json_decode($post['checkedValues']);

		$aff_rows = $this->business_model->deleteMultiple($ids);
		if ($aff_rows) {
			$data['status'] = "SUCCESS";
			$data['message'] = "Business records removed!";
		} else {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}
		echo json_encode($data);
	}

	public function view($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('business-units'); }
		$record = $this->business_model->get($value);
		if (!$record) { redirect('business-units'); }
		$users = $this->business_model->getCompanyUsers($value);
		$data['company'] = $record;
		$data['users'] = $users;
		$this->load->view('app/view-business-unit', $data);
	}

	public function removeCompanyImage($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('business-units'); }
		$record = $this->business_model->get($value);
		if (!$record) { redirect('business-units'); }
		@unlink('assets/img/companies/'.$record['company_logo']);
		$up_data = [
			'company_logo' => ''
		];
		$aff = $this->business_model->updateCompany($up_data, ['id'=>$value]);
		if ( $aff ) {
			$this->session->set_flashdata('success', 'Company image removed successfully!');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong!');
		}
		redirect('business-units/edit/'.$value);
	}

}

/* End of file  */
/* Location: ./application/controllers/ */