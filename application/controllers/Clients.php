<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Business_units_model', 'business_model');
		$this->load->model('Clients_model', 'client_model');
	}

	public function isValidUser($value='')
	{
		if (!$this->session->has_userdata('id') && ($this->session->userdata('type') != "admin" || $this->session->userdata('type') != "business unit")) {
			redirect('logout');
		}
	}

	public function index()
	{
		$this->isValidUser();
		// if(isset($_GET['limit'])){
		// 	$limit = (int) $_GET['limit'];
		// } else {
		// 	$limit = 10;
		// }
		// $data['total'] = $this->client_model->count();
		// $page = isset($_GET['page'])?$_GET['page']:1;
		$company_id = [];
		if ($_SESSION['type'] == "business unit") {
			if (isset($_GET['company_id']) && !empty($_GET['company_id'])) {
				$company_id[] = $_GET['company_id'];
			} else {
				foreach ($_SESSION['companies'] as $compns => $comp) {
					$company_id[] = $comp['id'];
				}
			}
		} else {
			$company_id[] = isset($_GET['company_id'])?$_GET['company_id']:'';
		}
		
		// $offset = ($page - 1) * $limit;
		$order = $_GET['order']??'DESC';
		// $data['results'] = $this->client_model->get($limit, $offset, $order, $company_id);
		$data['results'] = $this->client_model->get(NULL, NULL, $order, $company_id);
		// $data['limit'] = $limit;
	    // $data['page'] = $page;
	    // $data['order'] = $order;
	    $data['title'] = "Clients";
		$this->load->view('app/clients', $data);
	}

	public function create()
	{
		$this->isValidUser();
		$data['title'] = "Create Client";
		if ($this->input->post()) {
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 2048;
	        $config['encrypt_name']  = TRUE;

	        $this->upload->initialize($config);

	        $post = $this->input->post();
	        $post['email'] = strtolower($post['email']);
	        $this->form_validation->set_rules('firstname', 'First name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[12]');
			$this->form_validation->set_rules('phone', 'Phone number', 'integer|exact_length[10]|is_unique[clients.phone]');
			$this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[clients.email]');

			if ($this->form_validation->run() == TRUE) {
		        if (!empty($_FILES['profile_img_file'])) {
					if ($this->upload->do_upload('profile_img_file')) {
			            $post['profile_img'] = $this->upload->data('file_name');
			        }
		        }
		        $user_id = $this->client_model->create($post);
			}
			$this->form_validation->reset_validation();
			$this->form_validation->set_rules('company_name', 'Company name', 'required|is_unique[companies.company_name]');

			if ($this->form_validation->run() == TRUE) {
				$company = [];
				$company['company_name'] = trim(strip_tags(addslashes($post['company_name'])));
		        if (!empty($_FILES['company_logo_file'])) {
		        	$config = [];
	        		$config['upload_path']   = './assets/img/companies/';
			        $config['allowed_types'] = 'gif|jpg|jpeg|png';
			        $config['max_size']      = 2048;
			        $config['encrypt_name']  = TRUE;
			        $this->upload->initialize($config);
		        	if ($this->upload->do_upload('company_logo_file')) {
			            $company['company_logo'] = $this->upload->data('file_name');
			        } 
		        }
		        $company_id = $this->business_model->create($company);
		        if ($company_id) {
		        	$this->business_model->linkUsersToCompany($company_id, [$user_id], 'client');
		        	$this->session->set_flashdata('success', 'Client created successfully!');
		        	redirect('clients');
		        } else {
					$this->session->set_flashdata('error', 'Client can\'t be added!');
		        }
			}
	    }
	    if ($_SESSION['type'] == 'admin') {
			$data['business_units'] = $this->business_model->get();
		} else if ($_SESSION['type'] == 'business unit') {
			$data['business_units'] = $this->business_model->getBusinesses($_SESSION['id']);
		}
	    $this->load->view('app/manage-client', $data);
	}

	public function edit($value='')
	{
		$this->isValidUser();
		$data['title'] = "Edit Client";
		$data['company'] = $this->client_model->getClientInfo($value);
		if (!$data['company']) { redirect('clients'); }

		if ($this->input->post()) {
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 20480;
	        $config['encrypt_name']  = TRUE;

	        $this->upload->initialize($config);

	        $post = $this->input->post();

	        $this->form_validation->set_rules('firstname', 'First name', 'required');
			$this->form_validation->set_rules('phone', 'Phone number', 'integer|exact_length[10]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run() == TRUE) {
		        if (!empty($_FILES['profile_img_file'])) {
					if ($this->upload->do_upload('profile_img_file')) {
			            $post['profile_img'] = $this->upload->data('file_name');
			        }
		        }
		        $aff_user = $this->client_model->update($post, $post['user_id']);
			}

			$this->form_validation->reset_validation();
	        $this->form_validation->set_rules('company_name', 'Company name', 'required');

			if ($this->form_validation->run() == TRUE) {
				$company = [];
				$company['company_name'] = trim(strip_tags(addslashes($post['company_name'])));
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
		        $aff_com = $this->business_model->updateCompany($company, ['id'=>$data['company']['id']]);
	        	$this->session->set_flashdata('success', 'Client updated successfully!');
	        	redirect('clients');
			}
		}

		if ($_SESSION['type'] == 'admin') {
			$data['business_units'] = $this->business_model->get();
		} else if ($_SESSION['type'] == 'business unit') {
			$data['business_units'] = $this->business_model->getBusinesses($_SESSION['id']);
		}
	    $this->load->view('app/manage-client', $data);
	}

	public function delete($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('clients'); }
		$record = $this->client_model->getClientInfo($value);
		if (!$record) { redirect('clients'); }

		$this->client_model->removeManager($record['user_id']);
		$this->business_model->removeBusiness($record['id']);
		$this->session->set_flashdata('success', 'Manager removed successfully!');

		redirect('clients');
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
			$record = $this->client_model->getClientInfo($obj);
			$this->client_model->removeManager($record['user_id']);
			$this->business_model->removeBusiness($record['id']);
		}
		$data['status'] = "SUCCESS";
		$data['message'] = "Clients removed successfully!";
		echo json_encode($data);
	}

	public function view($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('clients'); }
		$data['client'] = $this->client_model->getClientInfo($value);
		if (!$data['client']) { redirect('clients'); }
		$data['exams'] = $this->client_model->getClientExams($value);
		$data['title'] = "View Client";
		$this->load->view('app/view-client', $data);
	}

	public function getClientsOfCompany()
	{
		if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}
		$post = $this->input->post();
		$data['clients'] = $this->client_model->getClients($post['id']);
		$data['status'] = "SUCCESS";
		
		echo json_encode($data);
	}

	public function removeClientCompanyImage($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('clients'); }
		$record = $this->business_model->get($value);
		if (!$record) { redirect('clients'); }
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
		redirect('client/edit/'.$value);
	}

	public function removeClientImage($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('clients'); }
		$record = $this->client_model->getClientInfoByUserId($value);
		if (!$record) { redirect('clients'); }
		@unlink('assets/img/'.$record['profile_img']);
		$up_data = [
			'profile_img' => ''
		];
		$aff = $this->client_model->genericUpdate($up_data, $value);
		if ( $aff ) {
			$this->session->set_flashdata('success', 'Client image removed successfully!');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong!');
		}
		redirect('client/edit/'.$value);
	}
}

/* End of file  */
/* Location: ./application/controllers/ */