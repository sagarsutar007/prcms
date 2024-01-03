<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';
use Dompdf\Dompdf;

class QuestionBank extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Questions_model', 'question_model');
		$this->load->model('Categories_model', 'category_model');
		$this->load->model('Answers_model', 'answer_model');
		$this->load->model('Exams_model', 'exam_model');
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

	public function index()
	{
		$this->isValidUser();
		// if(isset($_GET['limit'])){
		// 	$limit = (int) $_GET['limit'];
		// } else {
		// 	$limit = 10;
		// }
		// $data['total'] = $this->question_model->count();
		// $page = isset($_GET['page'])?$_GET['page']:1;
		// $offset = ($page - 1) * $limit;
		$order = $_GET['order']??'DESC';
		// $data['results'] = $this->question_model->get_data($limit, $offset, $order);
		$data['results'] = $this->question_model->get_data(NULL, NULL, $order);
		// $data['limit'] = $limit;
	    // $data['page'] = $page;
	    // $data['order'] = $order;
	    // $data['offset'] = $offset;

		$this->load->view('app/questions', $data);
	}

	public function create($value='')
	{
		$this->isValidUser();

		if($this->input->method() == 'post'){ 
			$post = $this->input->post();
			$post['created_by'] = $this->session->userdata('id');
			$post['created_at'] = date('Y-m-d h:i:s');
			if (isset($post['add_options'])) {
				if (isset($post['mcq_type']) && $post['mcq_type']=='multi-select') {
					$post['question_type'] = 'multi-select';
				} else{
					$post['question_type'] = 'mcq';
				}
			} else {
				$post['question_type'] = 'text';
			}
			$answers_list = [];
			if (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])){
				$config['upload_path'] = './assets/img/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = 20480;
				$config['encrypt_name'] = TRUE;

				$this->upload->initialize($config);

				if ($this->upload->do_upload('file'))
				{
					$uploaded = $this->upload->data();
					$post['question_img'] = $uploaded['file_name'];
				}
			}
			$inserted_question_id = $this->question_model->create($post);
			if (isset($post['add_options'])) {
				if ($post['question_type'] == 'mcq') {
					$count = count($post['answer_en']);
					for ($i=0; $i < $count; $i++) { 
						if(!empty($post['answer_en'][$i])){
							$temp['answer_text_en'] = $post['answer_en'][$i];
							$temp['answer_text_hi'] = $post['answer_hi'][$i];
							$temp['question_id'] = $inserted_question_id;
							($i==0)?$temp['isCorrect']=1:$temp['isCorrect']=0;
							$answers_list[] = $temp;
						} else {
							if ($i==0){ 
								$this->session->set_flashdata('error', 'Correct answer can not be blank');	
								redirect('question-bank/create');
							}
						}
					}
				} else {
					foreach ($post['answer_en'] as $answersKey => $ansObj) {
						$temp['answer_text_en'] = $ansObj;
						$temp['answer_text_hi'] = $post['answer_hi'][$answersKey];
						$temp['question_id'] = $inserted_question_id;
						if (isset($post['check'][$answersKey]) && !empty($post['check'][$answersKey])){ 
							$temp['isCorrect'] = 1; 
						} else {
							$temp['isCorrect'] = 0; 
						}
						
						$answers_list[] = $temp;
					}
				}
				$affected_rows = $this->answer_model->addAnswers($answers_list);
			}
			
			$this->session->set_flashdata('success', 'Question created successfully!');
			redirect('question-bank');
		}

		$data['title'] = 'Add Question';
		$data['categories'] = $this->category_model->get();
		$this->load->view('app/manage-question', $data);
			
	}

	public function edit($question_id='')
	{
		$this->isValidUser();
		if(empty($question_id)) { redirect('question-bank'); }
		$data['title'] = 'Edit Question';
		if($this->input->method() == 'post'){ 
			$post = $this->input->post();
			$post['edited_by'] = $this->session->userdata('id');
			$post['edited_at'] = date('Y-m-d h:i:s');
			if (isset($post['add_options'])) {
				if (isset($post['mcq_type']) && $post['mcq_type']=='multi-select') {
					$post['question_type'] = 'multi-select';
				} else{
					$post['question_type'] = 'mcq';
				}
			} else {
				$post['question_type'] = 'text';
			}

			$qst = $this->question_model->getQuestion($question_id);
			if ( $qst ) {
				if (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])){
					$config['upload_path'] = './assets/img/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = 20480;
					$config['encrypt_name'] = TRUE;

					$this->upload->initialize($config);

					if ($this->upload->do_upload('file'))
					{
						$uploaded = $this->upload->data();
						$post['question_img'] = $uploaded['file_name'];
					} else {
						$post['question_img'] = $qst['question_img'];
					}
				}
				$aff_que = $this->question_model->updateQuestion($post);

				if (isset($post['add_options'])) {
					if ($post['question_type'] == 'mcq') {
						$count = count($post['answer_en']);
						for ($i=0; $i < $count; $i++) { 
							if(!empty($post['answer_en'][$i])){
								$temp['answer_text_en'] = $post['answer_en'][$i];
								$temp['answer_text_hi'] = $post['answer_hi'][$i];
								$temp['question_id'] = $question_id;
								($i==0)?$temp['isCorrect']=1:$temp['isCorrect']=0;
								$answers_list[] = $temp;
							} else {
								if ($i==0){ 
									$this->session->set_flashdata('error', 'Correct answer can not be blank');	
									redirect('question-bank/create');
								}
							}
						}
					} else {
						foreach ($post['answer_en'] as $answersKey => $ansObj) {
							$temp['answer_text_en'] = $ansObj;
							$temp['answer_text_hi'] = $post['answer_hi'][$answersKey];
							$temp['question_id'] = $question_id;
							if (isset($post['check'][$answersKey]) && !empty($post['check'][$answersKey])){ 
								$temp['isCorrect'] = 1; 
							} else {
								$temp['isCorrect'] = 0; 
							}
							
							$answers_list[] = $temp;
						}
					}

					$del_ans = $this->answer_model->deleteAnswersOfQuestion($post['question_id']);
					$aff_ans = $this->answer_model->addAnswers($answers_list);
				}
				
				$this->session->set_flashdata('success', 'Question updated successfully!');
				redirect('question-bank');
			} else {
				$this->session->set_flashdata('error', 'This question doesn\'t exists!');
				redirect('question-bank');
			}
		} 

		$data['question'] = $this->question_model->getQuestion($question_id);
		$data['categories'] = $this->category_model->get();
		if($data['question']) {
			$data['answers'] = $this->answer_model->getAnswersOfQuestion($question_id);
		}
		$this->load->view('app/manage-question', $data);
	}

	public function removeQuestionImage($value='') {
		if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR"; 
			$data['message'] = "Session timeout. Please login again!";
		}

		if($this->input->method() == 'post'){ 
			$post = $this->input->post();
			if (!empty($post['question_id'])) {
				$aff_que = $this->question_model->removeQuestionImage($post);
				$data['status'] = "SUCCESS";
				$data['message'] = "Image removed successfully!";
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "Required fields are missing!";
			}
		}
		echo json_encode($data);
	}

	public function delete($question_id='')
	{
		$this->isValidUser();
			$record = $this->question_model->getQuestion($question_id);
			$del_row = $this->question_model->deleteQuestion($question_id);
			if ($del_row) {
				if (!empty($record['question_img'])) { unlink('./assets/img/'.$record['question_img']); }
				$this->session->set_flashdata('success', 'Question removed successfully!');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong! Please try again.');
			}
			redirect('question-bank');
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
			$record = $this->question_model->getQuestion($obj);
			$del_row = $this->question_model->deleteQuestion($obj);
			if (!empty($record['question_img'])) { unlink('./assets/img/'.$record['question_img']); }
		}
		$data['status'] = "SUCCESS";
		$data['message'] = "Multiple questions have been removed!";
		echo json_encode($data);
	}

	public function generatePdf() {
        $dompdf = new Dompdf();
        $html = '<html><body><h1>Hello, PDF!</h1></body></html>';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("output.pdf", array("Attachment" => false));
    }


    public function fetchMultiCategoryQuestions($value='')
    {
    	if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		$post = $this->input->post();
		$ids = json_decode($post['checkedValues']);
		$result = $this->question_model->getQuestionsOfCategories($ids);

		if (isset($post['exam_id'])) {
			$records = [];
			foreach ($result as $key => $obj) {
				$check_arr = [
					'exam_id' => $post['exam_id'],
					'question_id' => $obj['question_id']
				];
				$exists = $this->exam_model->checkExamAndQuestionExists($check_arr);

				if ($exists) {
					$obj['checked'] = 'checked';
				} 
				$records[] = $obj;
			}
		}
		$data['status'] = "SUCCESS";
		$data['result'] = isset($records)?$records:$result;
		echo json_encode($data);
    }

    public function removeExamQuestion($value='')
    {
    	if (!$this->session->has_userdata('id') && $this->session->userdata('type') != "candidate") {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		$post = $this->input->post();
		$id = json_decode($post['record_id']);
		$this->exam_model->removeExamQuestion($id);
		$data['status'] = "SUCCESS";
		echo json_encode($data);
    }

    public function view($value='')
    {
    	$this->isValidUser();
    	if(!$value){ redirect('question-bank'); }
    	$data['title'] = 'View Question';
    	$data['question'] = $this->question_model->getQuestion($value);
    	$data['answers'] = $this->answer_model->getAnswersOfQuestion($value);
    	$this->load->view('app/view-question', $data, FALSE);
    }

     public function ajaxView($value='')
    {
    	$this->isValidUser();
    	if(!$value){ redirect('question-bank'); }
    	$data['title'] = 'View Question';
    	$data['question'] = $this->question_model->getQuestion($value);
    	$data['answers'] = $this->answer_model->getAnswersOfQuestion($value);
    	$this->load->view('app/ajax/view-question', $data, FALSE);
    }

}

/* End of file  */
/* Location: ./application/controllers/ */