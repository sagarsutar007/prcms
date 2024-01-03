<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Managers_model', 'manager_model');
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
		// if(isset($_GET['limit'])){
		// 	$limit = (int) $_GET['limit'];
		// } else {
		// 	$limit = 10;
		// }
		// $data['total'] = $this->manager_model->count();
		// $page = isset($_GET['page'])?$_GET['page']:1;
		// $offset = ($page - 1) * $limit;
		$order = $_GET['order']??'DESC';
		// $data['results'] = $this->manager_model->get_data($limit, $offset, $order);
		$data['results'] = $this->manager_model->get_data(NULL, NULL, $order);
		// $data['limit'] = $limit;
	    // $data['page'] = $page;
	    $data['order'] = $order;

		$this->load->view('app/managers', $data);
	}

	public function create()
	{
		$this->isValidUser();
		$data['title'] = "Create Manager";
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
			$this->form_validation->set_rules('phone', 'Phone number', 'integer|exact_length[10]|is_unique[business_units.phone]');
			$this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[business_units.email]');

			if ($this->form_validation->run() == TRUE) {
		        if (!empty($_FILES['profile_img_file'])) {
					if ($this->upload->do_upload('profile_img_file')) {
			            $post['profile_img'] = $this->upload->data('file_name');
			        }
		        }
		        $last_user_id = $this->manager_model->insert($post);
			}
			$this->session->set_flashdata('success', 'Manager added successfully!');
			redirect('business-units/managers');
	    }
	    $this->load->view('app/manage-manager', $data);
	}

	public function edit($value='')
	{
		$this->isValidUser();
		$data['title'] = "Edit Manager";
		$data['record'] = $this->manager_model->get($value);

		if ($this->input->post() && $data['record']) {
			$config['upload_path']   = './assets/img/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size']      = 2048;
	        $config['encrypt_name']  = TRUE;
	        $this->upload->initialize($config);
	        $post = $this->input->post();
	        $post['email'] = strtolower($post['email']);
	        $this->form_validation->set_rules('firstname', 'First name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[12]');
			$this->form_validation->set_rules('phone', 'Phone number', 'integer|exact_length[10]');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');

			if ($this->form_validation->run() == TRUE) {
		        if (!empty($_FILES['profile_img_file'])) {
					if ($this->upload->do_upload('profile_img_file')) {
			            $post['profile_img'] = $this->upload->data('file_name');
			        }
		        }
		        
		        $this->manager_model->update($post, $value);
			}
			$this->session->set_flashdata('success', 'Manager detail updated successfully!');
			redirect('business-units/managers');
		}

	    $this->load->view('app/manage-manager', $data);
	}

	public function delete($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('business-units'); }
		$record = $this->manager_model->get($value);
		if (!$record) { 
			$this->session->set_flashdata('error', 'Manager not found!');
			redirect('business-units/managers'); 
		}

		$aff_rows = $this->manager_model->delete($value);

		if ($aff_rows) {
			$this->session->set_flashdata('success', 'Manager removed successfully!');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong!');
		}

		redirect('business-units/managers');
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
			$this->manager_model->delete($obj);
		}
		$data['status'] = "SUCCESS";
		$data['message'] = "Business Manager removed!";
		echo json_encode($data);
	}

	public function view($value='')
	{
		// $this->isValidUser();
		// if (empty($value)){ redirect('business-units'); }
		// $record = $this->business_model->get($value);
		// if (!$record) { redirect('business-units'); }
		// $users = $this->business_model->getCompanyUsers($value);
		// $data['company'] = $record;
		// $data['users'] = $users;
		// $this->load->view('app/view-business-unit', $data);
	}

	public function removeManagerImage($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('business-units/managers'); }
		$record = $this->manager_model->get($value);
		if (!$record) { redirect('business-units/managers'); }
		@unlink('assets/img/'.$record['profile_img']);
		$up_data = [
			'profile_img' => ''
		];
		$aff = $this->manager_model->genericUpdate($up_data, $value);
		if ( $aff ) {
			$this->session->set_flashdata('success', 'Manager image removed successfully!');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong!');
		}
		redirect('business-units/manager/edit/'.$value);
	}
}

/* End of file  */
/* Location: ./application/controllers/ */