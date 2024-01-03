<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Categories_model', 'category_model');
		$this->load->model('Questions_model', 'question_model');
	}

	public function isValidUser($value='')
	{
		if ($this->session->has_userdata('id')) {
			$userType = $this->session->userdata('type');
			if (!in_array($userType, ['admin', 'business unit'])) {
				redirect('logout');
			}
		} else {
			redirect('logout');
		}
	}

	public function isAdminOrManager($value='')
	{
		if (!$this->session->has_userdata('id') || $this->session->userdata('type') == "candidate" || $this->session->userdata('type') == "client") {
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
		// $data['total'] = $this->category_model->count();
		// $page = isset($_GET['page'])?$_GET['page']:1;
		// $offset = ($page - 1) * $limit;
		$order = $_GET['order']??'DESC';
		// $data['results'] = $this->category_model->get_data($limit, $offset, $order);
		$data['results'] = $this->category_model->get_data(NULL, NULL, $order);
		// $data['limit'] = $limit;
	    // $data['page'] = $page;
	    // $data['order'] = $order;

		$this->load->view('app/categories', $data);
	}

	public function create()
	{
		$this->isValidUser();
		$data['title'] = "Create Category";
		if ($this->input->post()) {
	        $post = $this->input->post();
			$this->form_validation->reset_validation();
			$this->form_validation->set_rules('category_name', 'Category name', 'required|is_unique[categories.category_name]');

			if ($this->form_validation->run() == TRUE) {
				$post['category_name'] = trim(strip_tags(addslashes($post['category_name'])));
				$post['category_desc'] = trim(strip_tags(addslashes($post['category_desc'])));
				$post['created_by'] = $this->session->userdata('id');
				$company_id = $this->category_model->create($post);
				if ($company_id) {
		        	$this->session->set_flashdata('success', 'Category created successfully!');
		        	redirect('question-bank/categories');
		        } else {
					$this->session->set_flashdata('error', 'Can\'t create business unit!');
		        }
			}
	    }

	    $this->load->view('app/manage-category', $data);
	}

	public function edit($value='')
	{
		$this->isValidUser();
		$data['title'] = "Edit Category";
		$data['record'] = $this->category_model->get($value);
		if (!$data['record']) { redirect('business-units'); }

		if ($this->input->post()) {
	        $post = $this->input->post();
	        $this->form_validation->set_rules('category_name', 'Category name', 'required');
			if ($this->form_validation->run() == TRUE) {
				$post['category_name'] = trim(strip_tags(addslashes($post['category_name'])));
				$post['category_desc'] = trim(strip_tags(addslashes($post['category_desc'])));
				$post['edited_by'] = $this->session->userdata('id');
				$post['edited_at'] = date('y-m-d h:i:s');

		        $aff_row = $this->category_model->updateCategory($post, $value);
	        	$this->session->set_flashdata('success', 'Category updated successfully!');
	        	redirect('question-bank/categories');
			}
		}
	    $this->load->view('app/manage-category', $data);
	}

	public function delete($value='')
	{
		$this->isValidUser();
		if (empty($value)){ redirect('business-units'); }
		$record = $this->category_model->get($value);
		if (!$record) { redirect('business-units'); }

		$other_cat = $this->category_model->search("Others");
		if (!$other_cat) {
			$other_cat_id = $this->category_model->createOtherCategory();
		}

		$oid = $other_cat_id??$other_cat['id']; 
		if ($oid == $value) {
			$this->session->set_flashdata('error', '\"Other\" category can\'t be deleted!');
			redirect('question-bank/categories');
		}
		$aff_rows = $this->category_model->removeCategory($value);

		if ($aff_rows) {
			$this->category_model->updateToOthersCategory([$value], $oid);
			$this->session->set_flashdata('success', 'Category removed successfully!');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong!');
		}

		redirect('question-bank/categories');
	}

	public function deleteMultiple()
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') != "admin") {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		$post = $this->input->post();
		$ids = json_decode($post['checkedValues']);

		$aff_rows = $this->category_model->deleteMultiple($ids);
		if ($aff_rows) {
			$other_cat = $this->category_model->search("Others");
			if (!$other_cat) {
				$other_cat_id = $this->category_model->createOtherCategory();
			}

			$this->category_model->updateToOthersCategory($ids, $other_cat_id??$other_cat['id']);
			$data['status'] = "SUCCESS";
			$data['message'] = "Categories removed!";
		} else {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}
		echo json_encode($data);
	}

	public function view($value='')
	{
		$this->isValidUser();
		$data['title'] = "View Category Questions";
		$data['record'] = $this->category_model->get($value);
		if (!$data['record']) { redirect('question-bank/categories'); }

		$data['questions'] = $this->question_model->getCategoryQuestions($value);
		$data['categories'] = $this->category_model->getExcept($value);

		// echo "<pre>"; print_r($data); exit();
	    $this->load->view('app/view-category-questions', $data);
	}

	public function moveQuestions()
	{
		$this->isAdminOrManager();
		if ($this->input->method() == "post") {
			$post = $this->input->post();
			$ids = json_decode($post['checkedValues']);
			$cat_id = $post['categoryId'];
			$aff_rows = $this->category_model->moveToCategory($ids,$cat_id);
			if ($aff_rows) {
				$data['status']='SUCCESS';
				$data['message']='Categories moved successfully!';
				$this->session->set_flashdata('success', 'Categories moved successfully!');
			} else {
				$data['status']='ERROR';
				$data['message']='Something technically wrong!';
				$this->session->set_flashdata('error', 'Something technically wrong!');
			}
		} else {
			$data['status']='ERROR';
			$data['message']='Something went wrong!';
		} 

		echo json_encode($data);
	}
}

/* End of file  */
/* Location: ./application/controllers/ */