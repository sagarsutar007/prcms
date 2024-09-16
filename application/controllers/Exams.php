<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require 'vendor/autoload.php';
use Dompdf\Options;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Exams extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Exams_model', 'exam_model');
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Categories_model', 'category_model');
		$this->load->model('Candidates_model', 'candidate_model');
		$this->load->model('Questions_model', 'question_model');
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Answers_model', 'answer_model');
		$this->load->model('Clients_model', 'client_model');
		$this->load->model('Settings_model', 'setting_model');
		$this->load->model('Notification_model', 'notif_model');
		$this->load->model('Business_units_model', 'business_model');
		$this->load->model('Managers_model', 'manager_model');
		date_default_timezone_set('Asia/Kolkata');
	}

	public function updateAnonymous()
	{
		$candidates = $this->candidate_model->get();
		foreach ($candidates as $key => $obj) {
			if (!empty($obj['profile_img'])) {
				$originalFilename = $obj['profile_img'];
				$newFilename = str_replace('_thumb', '', $originalFilename);

				createThumbnail($newFilename);
			}
		}
	}

	public function isValidUser($value = '')
	{
		if (!$this->session->has_userdata('id')) {
			redirect('logout');
		}
	}

	public function isNotACandidate($value = '')
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') != "candidate") {
			redirect('logout');
		}
	}

	public function isAdminOrManager($value = '')
	{
		if ($value && (!$this->session->has_userdata('id') || $this->session->userdata('type') == "candidate" || $this->session->userdata('type') == "client")) {
			$data['status'] = "ERROR";
			$data['message'] = "Invalid Request!";
			echo json_encode($data);
			return 0;
		}
		if (!$this->session->has_userdata('id') || $this->session->userdata('type') == "candidate" || $this->session->userdata('type') == "client") {
			redirect('logout');
		}
	}

	public function isValidCandidate($value = '')
	{
		if (!$this->session->has_userdata('id') || $this->session->userdata('type') != "candidate") {
			if ($value) {
				$data['status'] = 'ERROR';
				$data['message'] = 'Not a candidate';
				echo json_encode($data);
				return 0;
			} else {
				redirect('logout');
			}

		}
	}

	public function generateUniqueToken($prefix = '', $suffix = '')
	{
		$token = uniqid($prefix, true);
		// $token .= bin2hex(random_bytes(16));
		$token .= uniqid($suffix, true);
		return $token;
	}

	public function index()
	{
		$this->isValidUser();
		if ($this->session->userdata('type') == "candidate") {
			redirect('exams/completed');
		}
		$data['title'] = "Exams";
		// if(isset($_GET['limit'])){
		// 	$limit = (int) $_GET['limit'];
		// } else {
		// 	$limit = 10;
		// }

		// $page = isset($_GET['page'])?$_GET['page']:1;
		// $offset = ($page - 1) * $limit;
		$order = $_GET['order'] ?? 'DESC';
		// $data['limit'] = $limit;
		// $data['page'] = $page;
		$data['order'] = $order;
		// $data['offset'] = $offset;

		if ($this->session->userdata('type') == "client") {
			$user_id = $this->session->userdata('id');
			$company = $this->client_model->getCompanyByUserId($user_id);
			// $data['total'] = $this->exam_model->count($company['id']);
			$data['results'] = $this->client_model->get_data(NULL, NULL, $order, $company['id']);
		} else {
			$company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
			// $data['total'] = $this->exam_model->count($company_id);
			$data['results'] = $this->exam_model->get_data(NULL, NULL, $order, $company_id);
		}

		$this->load->view('app/exams', $data);
	}

	public function create()
	{
		$this->isAdminOrManager();
		if ($this->input->method() == "post") {
			$this->form_validation->set_rules('name', 'Exam name', 'required|is_unique[exams.name]');
			$this->form_validation->set_rules('duration', 'Duration', 'required|integer');
			$this->form_validation->set_rules('time', 'Time', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');

			if ($this->form_validation->run() == TRUE) {
				$post = $this->input->post();
				$post['url'] = uniqid();

				$time = date('H:i:s', strtotime($post['time']));
				$date = date('Y-m-d', strtotime($post['date']));

				$post['exam_datetime'] = $date . " " . $time;
				$post['exam_endtime'] = date('Y-m-d H:i:s', strtotime($post['exam_datetime'] . "+" . $post['duration'] . " mins"));
				$post['created_at'] = date('Y-m-d H:i:s');
				$post['created_by'] = $this->session->userdata('id');
				$post['creator_type'] = $this->session->userdata('type');
				$post['status'] = "draft";

				if (!isset($post['show_marks']))
					$post['show_marks'] = 'off';

				if (!isset($post['sms_notif']))
					$post['sms_notif'] = 'off';

				if (!isset($post['email_notif']))
					$post['email_notif'] = 'off';

				$short_url = shortenLink(base_url('e/' . $post['url']));
				$s_url = json_decode($short_url, true);

				if ($s_url['status'] == 'SUCCESS') {
					$post['short_url'] = $s_url['link'];
				} else {
					$post['short_url'] = "";
				}

				$last_id = $this->exam_model->create($post);

				if ($last_id) {
					if (isset($post['client_ids']) && count($post['client_ids']) > 0) {
						$this->exam_model->insertExamClients($post['client_ids'], $last_id);
					}
					redirect('exam/' . $last_id . '/add-questions/');
				} else {
					$this->session->set_flashdata('error', 'Exam is not created!');
					redirect('exams');
				}
			}

		}

		$data['title'] = 'Create Exam';
		$data['company_id'] = $_SESSION['companies'][0]['id'];
		$data['clients'] = $this->client_model->getClients($data['company_id']);

		$this->load->view('app/manage-exam', $data);
	}

	public function edit($value = '')
	{
		$this->isAdminOrManager();
		$record = $this->exam_model->get($value);
		if (!$record) {
			redirect('/exams');
		}
		if ($this->input->method() == "post") {
			$this->form_validation->set_rules('name', 'Exam name', 'required');
			$this->form_validation->set_rules('duration', 'Duration', 'required|integer');
			$this->form_validation->set_rules('time', 'Time', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');

			if ($this->form_validation->run() == TRUE) {
				$post = $this->input->post();
				$time = date('H:i:s', strtotime($post['time']));
				$date = date('Y-m-d', strtotime($post['date']));

				$post['exam_datetime'] = $date . " " . $time;
				$post['exam_endtime'] = date('Y-m-d H:i:s', strtotime($post['exam_datetime'] . "+" . $post['duration'] . " mins"));
				$post['created_at'] = date('Y-m-d H:i:s');

				if (!isset($post['show_marks']))
					$post['show_marks'] = 'off';

				if (!isset($post['sms_notif']))
					$post['sms_notif'] = 'off';

				if (!isset($post['email_notif']))
					$post['email_notif'] = 'off';

				$aff_row = $this->exam_model->update($post, $value);

				$this->exam_model->removeExamClients($value);

				if ($record['company_id'] != $post['company_id']) {
					$this->exam_model->removeExamCandidates($value);
				}

				if (isset($post['client_ids']) && count($post['client_ids']) > 0) {
					$this->exam_model->insertExamClients($post['client_ids'], $value);
				}

				if (isset($post['status']) && $post['status'] == 'scheduled') {
					$this->scheduleExam($value);
				}

				$this->session->set_flashdata('success', 'Exam was updated!');
				redirect('exams');
			}

		}

		$data['title'] = 'Edit Exam';
		$data['clients'] = $this->client_model->getClients();
		$exam_clients = $this->exam_model->getExamClients($value);
		$data['exam_clients'] = [];
		foreach ($exam_clients as $key => $obj) {
			$data['exam_clients'][] = $obj['id'];
		}
		$data['company_id'] = $this->input->get('company', true) ?? $_SESSION['companies'][0]['id'];
		$data['record'] = $record;

		$this->load->view('app/manage-exam', $data);
	}

	public function editSettings($value = '')
	{
		$this->isAdminOrManager();
		$data['exam'] = $this->exam_model->get($value);
		if (!$data['exam']) {
			$this->session->set_flashdata('error', 'Exam does not exists in our portal!');
			redirect('/exams');
		}
		$data['title'] = 'Edit Exam Settings';

		$this->load->view('app/manage-exam-settings', $data);
	}

	public function changeCandidatesPassword($value = '')
	{
		$this->isAdminOrManager();
		$exam = $this->exam_model->get($value);
		if (!$exam) {
			$this->session->set_flashdata('warning', 'Exam does not exists in our portal!');
			redirect('/exams');
		}

		if ($this->input->method() != 'post') {
			$this->session->set_flashdata('warning', 'Invalid request!');
			redirect('/exams');
		}

		$post = $this->input->post();
		$examTimestamp = strtotime($exam['exam_datetime']);
		$currentTimestamp = time();

		if ($currentTimestamp > $examTimestamp && $exam['status'] == 'scheduled') {
			$this->session->set_flashdata('warning', 'Passwords did not change because exam has been conducted!');
			redirect('/exam/' . $value . '/exam-settings');
		}

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('conf_pass', 'Confirm Password', 'required|matches[password]');

		if ($this->form_validation->run() == TRUE) {
			$res = $this->exam_model->updateExamCandidatesPassword($value, $post['password']);
			if ($res) {
				$this->session->set_flashdata('success', 'Passwords changed of exam candidates!');
			} else {
				$this->session->set_flashdata('error', 'Passwords changing failed of exam candidates! Same password is already there.');
			}
			redirect('/exam/' . $value . '/exam-settings');
		} else {
			$this->session->set_flashdata('warning', 'Passwords did not match!');
			redirect('/exam/' . $value . '/exam-settings');
		}
	}

	public function changeCandidateStatus($value = '')
	{
		$this->isAdminOrManager();
		$exam = $this->exam_model->get($value);
		if (!$exam) {
			$this->session->set_flashdata('warning', 'Exam does not exists in our portal!');
			redirect('/exams');
		}

		if ($this->input->method() != 'post') {
			$this->session->set_flashdata('warning', 'Invalid request!');
			redirect('/exams');
		}

		$post = $this->input->post();

		$this->form_validation->set_rules('candidates_status', 'Candidate status', 'required');

		if ($this->form_validation->run() == TRUE) {
			$res = $this->exam_model->updateExamCandidatesStatus($value, $post['candidates_status']);
			// if ($res) {
				$this->session->set_flashdata('success', 'Authentication status changed of exam candidates!');
			// } else {
			// 	$this->session->set_flashdata('error', 'Authentication status changing failed of exam candidates! Same status is already present.');
			// }
			redirect('/exam/' . $value . '/exam-settings');
		} else {
			$this->session->set_flashdata('warning', 'Authentication status is required!');
			redirect('/exam/' . $value . '/exam-settings');
		}
	}

	public function stopExam($value = '')
	{
		$this->isAdminOrManager();
		$exam = $this->exam_model->get($value);
		if (!$exam) {
			$this->session->set_flashdata('warning', 'Exam does not exists in our portal!');
			redirect('/exams');
		}

		if ($this->input->method() != 'post') {
			$this->session->set_flashdata('warning', 'Invalid request!');
			redirect('/exams');
		}

		$post = $this->input->post();
		$examStartTimestamp = strtotime($exam['exam_datetime']);
		$examEndTimestamp = strtotime($exam['exam_endtime']);
		$currentTimestamp = time();

		if (
			$currentTimestamp > $examStartTimestamp &&
			$currentTimestamp < $examEndTimestamp && $exam['status'] == 'scheduled'
		) {
			// Exam is currently running. Stop it.
			$this->form_validation->set_rules('confirm_stop', 'STOP textbox', 'required');

			if ($this->form_validation->run() == TRUE) {
				if ($post['confirm_stop'] == 'STOP') {
					$arr = [
						'left_at' => date('Y-m-d h:i:s')
					];
					$res = $this->exam_model->updateCandidatesExamInfo($arr, $value);
					$this->session->set_flashdata('success', 'Exam is stopped, all candidates will leave exam automatically!');
					redirect('/exam/' . $value . '/exam-settings');
				} else {
					$this->session->set_flashdata('warning', 'Please write STOP in the textbox!');
					redirect('/exam/' . $value . '/exam-settings');
				}
			} else {
				$this->session->set_flashdata('warning', 'Please enter STOP in the textbox!');
				redirect('/exam/' . $value . '/exam-settings');
			}
		} else {
			$this->session->set_flashdata('warning', 'Can not stop exam!');
			redirect('/exam/' . $value . '/exam-settings');
		}

	}

	public function startExamRepair($value = '')
	{
		$this->isAdminOrManager();
		$data = [];
		$exam = $this->exam_model->get($value);
		if (!$exam) {
			$data = ['status' => 'ERROR', 'message' => 'Exam does not exists in our portal!'];
			echo json_encode($data);
			return;
		}

		$examStartTimestamp = strtotime($exam['exam_datetime']);
		$examEndTimestamp = strtotime($exam['exam_endtime']);
		$currentTimestamp = time();

		if ($currentTimestamp > $examEndTimestamp && $exam['status'] == 'scheduled') {
			$data = ['status' => 'SUCCESS', 'message' => 'Exam is over!'];
		} else {
			$data = ['status' => 'ERROR', 'message' => 'Exam is either not stopped or over!'];
		}

		echo json_encode($data);
	}

	public function RepairExamCandidates($value = '')
	{
		$this->isAdminOrManager();
		$data = [];
		$exam = $this->exam_model->get($value);
		if (!$exam) {
			$data = ['status' => 'ERROR', 'message' => 'Exam does not exists in our portal!'];
			echo json_encode($data);
			return;
		}
		$arr = [
			'left_at' => $exam['exam_endtime']
		];

		$res = $this->exam_model->updateCandidatesExamLeftInfo($arr, $value, $exam['exam_endtime']);

		if ($res) {
			$data = ['status' => 'SUCCESS', 'message' => 'Successfully updated exam information!'];
		} else {
			$data = ['status' => 'ERROR', 'message' => 'Nothing to update!'];
		}

		echo json_encode($data);
	}

	public function addQuestions($value = '')
	{
		$this->isAdminOrManager();
		$data['title'] = 'Add Exam Questions';
		$data['exam_id'] = $value;
		$data['questions'] = $this->question_model->getAllQuestions();
		$data['categories'] = $this->category_model->get();
		$this->load->view('app/manage-exam-questions', $data);
	}

	public function editQuestions($value = '')
	{
		$this->isAdminOrManager();
		if ($this->input->method() == "post") {
			$post = $this->input->post();
			$outputArray = array();
			if (isset($post['qid']) && is_array($post['qid'])) {
				foreach ($post['qid'] as $question_id) {
					$ins_arr = array(
						'exam_id' => $post['exam_id'],
						'question_id' => $question_id
					);
					$outputArray[] = $ins_arr;
				}

				if (count($outputArray) > 0) {
					$this->exam_model->removeExamQuestions($value);
					$aff = $this->exam_model->insertExamQuestions($outputArray);
				}

			}
			redirect('exams/');
		}

		$data['title'] = 'Edit Exam Questions';
		$data['exam_id'] = $value;
		$data['exam_questions'] = $this->exam_model->getExamQuestions($value);
		$question_ids = [];
		foreach ($data['exam_questions'] as $key => $obj) {
			$question_ids[] = $obj['question_id'];
		}
		$data['left_questions'] = $this->exam_model->getLeftQuestions($question_ids);
		$data['questions'] = array_merge($data['exam_questions'], $data['left_questions']);
		$data['categories'] = $this->category_model->get();
		$this->load->view('app/manage-exam-questions', $data);
	}

	public function editCandidates($value = '')
	{
		$this->isAdminOrManager();
		$exams = $this->exam_model->get($value);
		if (!$exams) {
			redirect('exams');
		}
		$data['title'] = 'Manage Exam Candidates';
		$data['exam_id'] = $value;
		$this->load->view('app/manage-exam-candidates', $data);
	}

	public function getExamCandidateData($exam_id = '')
	{
		$company_id = [];
		if ($_SESSION['type'] == "business unit") {
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
		$columnName = $this->input->post('columns')[$columnIndex]['data'];
		$columnSortOrder = $order[0]['dir'];
		$exams = $this->exam_model->get($exam_id);
		$data = $this->exam_model->getExamCandidates($exam_id, $length, $start, $exams['company_id'], 'active', $search, $columnName, $columnSortOrder);
		$recordsTotal = $this->exam_model->countExamCandidatesData($exam_id, $exams['company_id'], 'active', $search, $columnName, $columnSortOrder);
		$result = array();
		$i = 1 + $start;
		foreach ($data as $record) {
			$result[] = array(
				'checkbox' => '<input type="checkbox" name="recs[]" class="check" value="' . $record['user_id'] . '">',
				'SNo' => $i,
				'Name' => ucwords($record['firstname'] . " " . $record['middlename'] . " " . $record['lastname']),
				'Phone' => $record['phone'],
				'Email' => $record['email'],
				'Employee Id' => $record['empid'],
				'Registered' => date('d-m-Y h:i', strtotime($record['created_at'])),
				'SMS Sent' => $record['sms_sent'],
				'Email Sent' => $record['email_sent'],
				'Action' => '<td class="text-center">' .
					($record['id'] ?
						'<button type="button" class="btn btn-default btn-sm btn-remove-candidate" data-user="' . $record['id'] . '">
							<i class="fas fa-times"></i>
						</button>' :
						'<button type="button" class="btn btn-default btn-sm btn-add-candidate" data-user="' . $record['user_id'] . '">
							<i class="fas fa-plus"></i>
						</button>'
					) . '</td>'
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

	public function insertExamCandidate()
	{
		$this->isAdminOrManager();
		if ($this->input->method() == "post") {
			$post = $this->input->post();
			$record_exists = $this->exam_model->isExamAndCandidateExists($post);
			if ($record_exists) {
				$data['status'] = 'ERROR';
				$data['message'] = 'Record exists!';
			} else {
				$last_id = $this->exam_model->insertExamCandidate($post);
				if ($last_id) {
					$data['status'] = 'SUCCESS';
					$data['user'] = $this->candidate_model->get($post['candidate_id']);
					$data['last_id'] = $last_id;
				} else {
					$data['status'] = 'ERROR';
					$data['message'] = 'Candidate can\'t be added!';
				}
			}
		} else {
			$data['status'] = 'ERROR';
			$data['message'] = 'Something went wrong!';
		}

		echo json_encode($data);
	}

	public function removeExamCandidate()
	{
		$this->isAdminOrManager();
		if ($this->input->method() == "post") {
			$post = $this->input->post();
			$record_exists = $this->exam_model->getExamCandidate($post['id']);
			$data['post'] = $post;
			if ($record_exists) {
				$this->exam_model->removeExamCandidate($post['id']);
				$data['status'] = 'SUCCESS';
				$data['message'] = 'Candidate removed from exam successfully!';
				$data['user_id'] = $record_exists['candidate_id'];

			} else {
				$data['status'] = 'ERROR';
				$data['message'] = 'No such record exists!';
			}
		} else {
			$data['status'] = 'ERROR';
			$data['message'] = 'Something went wrong!';
		}

		echo json_encode($data);
	}

	public function upcomingExam($value = '')
	{
		$this->isValidCandidate();
		$data['title'] = "Upcoming Exams";
		if (isset($_GET['limit'])) {
			$limit = (int) $_GET['limit'];
		} else {
			$limit = 20;
		}
		$user_id = $this->session->userdata('id');
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$offset = ($page - 1) * $limit;
		$order = $_GET['order'] ?? 'DESC';
		$data['limit'] = $limit;
		$data['page'] = $page;
		$data['order'] = $order;
		$data['total'] = $this->exam_model->countCandidatesUpcomingExam($user_id);
		$data['extype'] = "upcoming";
		$data['results'] = $this->exam_model->getCandidatesUpcomingExam($limit, $offset, $order, $user_id);
		$this->load->view('app/exams', $data);
	}

	public function completedExam($value = '')
	{
		$this->isValidCandidate();
		$data['title'] = "Completed Exams";
		$user_id = $this->session->userdata('id');
		$data['results'] = $this->exam_model->getCandidatesCompletedExam(NULL, NULL, 'DESC', $user_id);
		$data['extype'] = "completed";
		$this->load->view('app/exams', $data);
	}

	public function ongoingExam($value = '')
	{
		$this->isValidCandidate();
		$data['title'] = "Ongoing Exams";
		$user_id = $this->session->userdata('id');
		$data['results'] = $this->exam_model->getCandidatesExam($user_id);
		$data['extype'] = "ongoing";
		$this->load->view('app/exams', $data);
	}

	public function showExamStartScreen($value = '')
	{
		$this->isValidCandidate();
		$data['exam_info'] = $this->exam_model->getFromUrl($value);
		if (!$data['exam_info']) {
			redirect('logout');
		}
		if ($data['exam_info']['status'] != 'scheduled') {
			$this->session->set_flashdata('error', 'Exam is not scheduled!');
			redirect('dashboard');
		}

		$data['exam_info']['total_question'] = $this->exam_model->countExamQuestion($data['exam_info']['id']);

		$this->load->view('app/exam-splash-screen', $data, FALSE);
	}

	public function showQuestionScreen($value = '')
	{
		
		$this->isValidCandidate();

		//Check if exam exists
		$data['exam_info'] = $this->exam_model->getFromUrl($value);
		if (!$data['exam_info']) {
			redirect('logout');
		}

		$can['exam_id'] = $data['exam_info']['id'];
		$can['user_id'] = $this->session->userdata('id');
		$can['entered_at'] = date('Y-m-d H:i:s');

		$logArr = [
			'action' => 'Start Exam Button Clicked',
			'candidate_id' => $can['user_id'],
			'exam_id' => $can['exam_id'],
			'headers' => json_encode($this->input->request_headers())
		];
		$this->exam_model->addExamLog($logArr);

		//Check if exam is scheduled or not
		if ($data['exam_info']['status'] != 'scheduled') {
			$this->session->set_flashdata('error', 'This exam is now ' . $data['exam_info']['status']);
			$logArr = [
				'action' => 'This exam is now ' . $data['exam_info']['status'],
				'candidate_id' => $can['user_id'],
				'exam_id' => $can['exam_id'],
				'headers' => json_encode($this->input->request_headers())
			];
			$this->exam_model->addExamLog($logArr);
			redirect('dashboard');
		}
		//Check if exam is over or not
		if (time() > strtotime($data['exam_info']['exam_endtime'])) {
			$this->session->set_flashdata('error', 'Exam time is over!');
			$logArr = [
				'action' => 'Exam time is over!',
				'candidate_id' => $can['user_id'],
				'exam_id' => $can['exam_id'],
				'headers' => json_encode($this->input->request_headers())
			];
			$this->exam_model->addExamLog($logArr);
			redirect('dashboard');
		}

		//Check if exam time has been started or not
		if (strtotime($data['exam_info']['exam_datetime']) > time()) {
			$this->session->set_flashdata('error', 'Exam is yet to start!');
			$logArr = [
				'action' => 'Exam is yet to start!',
				'candidate_id' => $can['user_id'],
				'exam_id' => $can['exam_id'],
				'headers' => json_encode($this->input->request_headers())
			];
			$this->exam_model->addExamLog($logArr);
			redirect('dashboard');
		}

		$token = uniqid();

		//Check if exam candidate is assigned to that exam
		$arr = [
			'candidate_id' => $can['user_id'],
			'exam_id' => $can['exam_id']
		];

		$valid_cand = $this->exam_model->isExamAndCandidateExists($arr);
		if (!$valid_cand) {
			$this->session->set_flashdata('error', 'You are not allowed to appear in this exam!');

			$logArr = [
				'action' => 'You are not allowed to appear in this exam!',
				'candidate_id' => $can['user_id'],
				'exam_id' => $can['exam_id'],
				'headers' => json_encode($this->input->request_headers())
			];
			$this->exam_model->addExamLog($logArr);

			redirect('dashboard');
		}

		//Set first time entry
		$exam_appeared = $this->exam_model->checkCandidateExamInfo($can);
		if (!$exam_appeared) {
			$cookie_data = array(
				'name' => 'exam_entry',
				'value' => $token,
				'expire' => $data['exam_info']['duration'] * 60,
				'path' => '/',
				'secure' => TRUE,
				'httponly' => TRUE
			);

			set_cookie($cookie_data);
			$can['exam_token'] = $token;
			$this->exam_model->setCandidateExamInfo($can);
			$logArr = [
				'action' => 'Unique Id generated for the user',
				'candidate_id' => $can['user_id'],
				'exam_id' => $can['exam_id'],
				'dbtoken' => $token,
				'headers' => json_encode($this->input->request_headers())
			];
			$this->exam_model->addExamLog($logArr);
		} else {
			if (!empty($exam_appeared['left_at'])) {
				$logArr = [
					'action' => 'You are trying to appear again after submitting the exam!',
					'candidate_id' => $can['user_id'],
					'exam_id' => $can['exam_id'],
					'headers' => json_encode($this->input->request_headers())
				];
				$this->exam_model->addExamLog($logArr);

				redirect('exams/' . $data['exam_info']['id'] . '/view-result');
			}

			$exam_token = $this->input->cookie('exam_entry', TRUE);
			if (!empty($exam_appeared['exam_token']) && $exam_appeared['exam_token'] != $exam_token) {
				$this->session->set_flashdata('error', 'Exam is going on in another device!');
				$logArr = [
					'action' => 'Exam is going on in another device',
					'candidate_id' => $can['user_id'],
					'exam_id' => $can['exam_id'],
					'cookie' => $exam_token??'',
					'dbtoken' => $exam_appeared['exam_token'],
					'headers' => json_encode($this->input->request_headers())
				];
				$this->exam_model->addExamLog($logArr);
				redirect('exams/ongoing');
			}

			if ($exam_appeared['re_entry'] == 'true' && empty($exam_appeared['re_entry_timestamp'])) {
				$cookie_data = array(
					'name' => 'exam_entry',
					'value' => $token,
					'expire' => $data['exam_info']['duration'] * 60,
					'path' => '/',
					'secure' => TRUE,
					'httponly' => TRUE
				);

				set_cookie($cookie_data);

				$userarr['exam_token'] = $token;
				$userarr['re_entry_timestamp'] = date('Y-m-d h:i:s');
				$this->exam_model->updateCandidateExamInfo($userarr, $exam_appeared['id']);

				$logArr = [
					'action' => 'Re-entry done - cookie and token regenerated',
					'candidate_id' => $can['user_id'],
					'exam_id' => $can['exam_id'],
					'dbtoken' => $token,
					'headers' => json_encode($this->input->request_headers())
				];
				$this->exam_model->addExamLog($logArr);
			}
		}

		$questions = [];
		$ques = $this->exam_model->getExamQuestions($data['exam_info']['id'], 'active');

		shuffle($ques);
		$i = 1;
		foreach ($ques as $question => $que) {
			$que_temp['qno'] = $i;
			$que_temp['eqid'] = $que['eqid'];
			$que_temp['question_id'] = $que['question_id'];
			$que_temp['question_en'] = $que['question_en'];
			$que_temp['question_hi'] = $que['question_hi'];
			if (!empty($que['question_img']) && file_exists('assets/img/' . $que['question_img'])) {
				$que_temp['question_img'] = base_url('assets/img/' . $que['question_img']);
			} else {
				$que_temp['question_img'] = NULL;
			}

			$que_temp['question_type'] = $que['question_type'];

			$arr = [
				'user_id' => $can['user_id'],
				'question_id' => $que_temp['question_id'],
				'exam_id' => $can['exam_id']
			];

			$user_ans = $this->exam_model->getUserAnswer($arr);
			$que_temp['attempted'] = false;
			if ($user_ans) {
				$que_temp['attempted'] = true;
			}

			if ($que['question_type'] == 'text') {
				$answers_res = (!empty($user_ans)) ? $user_ans['answer_id'] : '';
			} else {
				$answers_res = [];
				$answers_rec = $this->answer_model->getAnswersOfQuestion($que['question_id']);

				if ($user_ans) {
					foreach ($answers_rec as $key => $obj) {
						$te_ans = $obj;
						if ($obj['id'] == $user_ans['answer_id']) {
							$te_ans['checked'] = true;
						}
						$answers_res[] = $te_ans;
					}
					shuffle($answers_res);
				} else {
					$answers_res = $answers_rec;
					shuffle($answers_res);
				}
			}

			$que_temp['answers'] = $answers_res;
			$questions[] = $que_temp;
			$qids[] = $que['question_id'];
			$i++;
		}

		$data['questions'] = $questions;
		$data['queIds'] = $qids;
		$data['company'] = $this->business_model->get($data['exam_info']['company_id']);

		$logArr = [
			'action' => 'Loading response as question screen',
			'candidate_id' => $can['user_id'],
			'exam_id' => $can['exam_id'],
			'headers' => json_encode($this->input->request_headers())
		];
		$this->exam_model->addExamLog($logArr);

		$this->load->view('app/exam-question-screen', $data, FALSE);
	}

	public function enableRentry()
	{
		$this->isAdminOrManager();
		$arr = [
			'exam_id' => $this->input->get('examid'),
			'user_id' => $this->input->get('userid'),
		];
		$exam_info = $this->exam_model->get($arr['exam_id']);
		if (!$exam_info) {
			redirect('logout');
		}
		$result = $this->exam_model->enableRetry($arr);
		$this->session->set_flashdata('success', 'Enabled the candidate to rewrite exam successfully');
		redirect('exams/' . $arr['exam_id'] . '/view-exam-dashboard');
	}

	public function getExamQuestion()
	{
		$this->isValidCandidate(true);
		if ($this->input->post()) {
			$post = $this->input->post();
			$temp['user_id'] = $this->session->userdata('id');
			$temp['exam_id'] = $post['examId'];
			$temp['question_id'] = $post['question_id'];

			$data['question'] = $this->question_model->getQuestion($post['question_id']);

			if (!empty($data['question']['question_img']) && file_exists('./assets/img/' . $data['question']['question_img'])) {
				$data['question']['question_img'] = base_url('assets/img/' . $data['question']['question_img']);
			}

			$user_ans = $this->exam_model->getUserAnswer($temp);

			if ($data['question']['question_type'] == 'mcq') {
				$answers = $this->answer_model->getAnswersOfQuestion($post['question_id']);
				foreach ($answers as $answer => $ans) {
					$demo = $ans;

					if (!empty($user_ans) && $ans['id'] == $user_ans['answer_id']) {
						$demo['checked'] = 'checked';
					} else {
						$demo['checked'] = '';
					}

					$ans_arr[] = $demo;
				}
			} else {
				$ans_arr = $user_ans['answer_id'];
			}

			$data['question']['answers'] = $ans_arr;
			$data['status'] = 'SUCCESS';
		} else {
			$data['status'] = 'ERROR';
		}

		echo json_encode($data);
	}

	public function submitAnswer()
	{
		$this->isValidCandidate(true);

		if ($this->input->post()) {
			$post = $this->input->post();
			$temp['user_id'] = $this->session->userdata('id');
			$temp['question_id'] = $post['currentQuestionId'];
			$temp['exam_id'] = $post['examId'];
			$temp['status'] = 'unknown';
			$data['ans_type'] = 'not answered';

			$exam = $this->exam_model->getExamInfo($temp['exam_id']);

			$current_time = new DateTime();
			$exam_endtime = new DateTime($exam['exam_endtime']);
			
			if ($exam_endtime < $current_time) {
				$data['status'] = "ERROR";
				$data['message'] = "The exam has ended.";
				echo json_encode($data);
				return;
			}

			$exam_appeared = $this->exam_model->checkCandidateExamInfo($temp);
			if (!empty($exam_appeared['left_at']) && $exam_appeared['re_entry'] == "false") {
				$data['status'] = "ERROR";
				$data['message'] = "Show result page!";
			} else {
				if (isset($post['answerId'])) {
					$temp['answer_id'] = $post['answerId'];
					$data['ans_type'] = 'answered';

					$question = $this->question_model->getQuestion($temp['question_id']);

					if ($question['question_type'] == 'mcq') {
						$ans = $this->answer_model->theCorrectAnswer($temp['question_id']);
						$temp['status'] = ($ans['id'] == $post['answerId']) ? 'correct' : 'incorrect';
						$this->exam_model->deleteAnswer($temp);
						$last_id = $this->exam_model->submitAnswer($temp);
					} else if ($question['question_type'] == 'multi-select') {
						$ansExists = $this->exam_model->checkAnswerExists($temp);
						if ($ansExists) {
							$this->exam_model->deleteAnswerById($ansExists['id']);
							$last_id = $ansExists['id'];
						} else {
							$answers = $this->answer_model->theCorrectAnswers($temp['question_id']);
							$ansIdArr = [];
							foreach ($answers as $answersKey => $answerObj) {
								$ansIdArr[] = $answerObj['id'];
							}
							if (in_array($post['answerId'], $ansIdArr)) {
								$temp['status'] = 'correct';
							} else {
								$temp['status'] = 'incorrect';
							}

							$last_id = $this->exam_model->submitAnswer($temp);
						}
					} else {
						$temp['answer_id'] = addslashes(strip_tags(trim($post['answerId'])));
						$last_id = $this->exam_model->submitAnswer($temp);
					}
				}

				if ($last_id) {
					$data['status'] = "SUCCESS";
					$data['message'] = "Answer stored successfully!";
				} else {
					$data['status'] = "ERROR";
					$data['message'] = "Something went wrong!";
				}
			}
		} else {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		echo json_encode($data);
	}

	public function viewResult($exam_id = '')
	{
		$this->isValidCandidate();
		$user_id = $this->session->userdata('id');
		$can['exam_id'] = $exam_id;
		$can['user_id'] = $user_id;
		$exam_info = $this->exam_model->get($exam_id);
		$exam_entry = $this->exam_model->checkCandidateExamInfo($can);
		if (!empty($exam_entry) && ($exam_entry['left_at'] == '0000-00-00 00:00:00' || empty($exam_entry['left_at']))) {
			$can['left_at'] = date('Y-m-d H:i:s');
			$this->exam_model->updateCandidateExamInfo($can, $exam_entry['id']);
		}
		if ($exam_info['show_marks'] == "on") {
			$questions = $this->exam_model->getExamQuestions($exam_id);
			$total_question = count($questions);
			$correct_answers = 0;
			$result = $this->exam_model->getExamResult($exam_id, $user_id);
			$ansArr = [];
			foreach ($result as $item) {
				$questionId = $item['question_id'];
				$status = $item['status'];
				if (array_key_exists($questionId, $ansArr)) {
					if ($status === 'incorrect') {
						$ansArr[$questionId] = $status;
					}
				} else {
					$ansArr[$questionId] = $status;
				}
			}

			foreach ($ansArr as $key => $obj) {
				if ($obj == 'correct') {
					$correct_answers++;
				}
			}
		}

		$data['title'] = "Exam Results";
		$data['total'] = $total_question ?? 0;
		$data['correct'] = $correct_answers ?? 0;
		$data['exam'] = $exam_info;
		$this->load->view('app/exam-result-screen', $data);
	}

	public function viewDetailedResult($exam_id = '')
	{
		$this->isNotACandidate();
		$results = $this->exam_model->getExamResults($exam_id);
		$data['exam_id'] = $exam_id;
		$total_ques = $this->question_model->countExamQuestion($exam_id);
		$data['title'] = "View Exam Candidates";
		foreach ($results as $key => $obj) {
			$temp = $obj;
			$temp['attended'] = $this->exam_model->isExamAttended($obj['id'], $exam_id);
			$correct_ans = $this->exam_model->getCorrectExamAns($exam_id, $obj['id']);
			if ($correct_ans) {
				$temp['ans_stats'] = $correct_ans['count_ans'] . "/" . $total_ques;
			} else {
				if ($temp['attended']) {
					$temp['ans_stats'] = "0/" . $total_ques;
				} else {
					$temp['ans_stats'] = "Absent";
				}

			}

			$data['results'][] = $temp;
		}

		$this->load->view('app/exam-candidates-result-screen', $data);
	}

	public function generateExamCandidatePdf($exam_id = '')
	{
		$this->isNotACandidate();
		$data['exam'] = $this->exam_model->get($exam_id);
		$data['exam']['total_candidates'] = $this->exam_model->countExamCandidates($exam_id);
		$results = $this->exam_model->getExamResults($exam_id);
		$total_ques = $this->question_model->countExamQuestion($exam_id);

		foreach ($results as $key => $obj) {
			$temp = $obj;
			$correct_ans = $this->exam_model->getCorrectExamAns($exam_id, $obj['id']);
			if ($correct_ans) {
				$temp['ans_stats'] = $correct_ans['count_ans'] . "/" . $total_ques;
			} else {
				$temp['ans_stats'] = "";
			}

			$data['results'][] = $temp;
		}

		$dompdf = new Dompdf();
		$html = $this->load->view('app/pdfviews/completed-exam-candidates', $data, true);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream("Exam-candidates.pdf", array("Attachment" => false));
	}

	public function delete($value = '')
	{
		$this->isAdminOrManager();
		$this->exam_model->deleteExam($value);
		redirect('exams');
	}

	public function bulkUpload()
	{
		$this->isAdminOrManager();
		if (!$this->input->post()) {
			redirect('exams');
		}
		$new_reg = [];
		$exam_reg = [];

		$post = $this->input->post();

		$exam = $this->exam_model->get($post['exam_id']);
		if (!$exam) {
			redirect('exams');
		}

		$config['upload_path'] = './assets/admin/formats/';
		$config['allowed_types'] = 'csv|CSV|xlsx|XLSX|xls|XLS';

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('excel_file')) {
			$this->session->set_flashdata('error', 'Error uploading file!');
		} else {
			$upload_data = $this->upload->data();
			$file_path = $upload_data['full_path'];

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
			$worksheet = $spreadsheet->getActiveSheet();
			$excel_data = $worksheet->toArray();
			$phone_nums = [];
			for ($i = 1; $i < count($excel_data); $i++) {
				$row = $excel_data[$i];
				if (!empty($row[0]) && !empty($row[6])) {
					//check if user exists
					$candidate = $this->candidate_model->candidateExists($row[6]);

					if ($candidate) {
						if ($candidate['company_id'] == $exam['company_id']) {
							$arr = [
								'candidate_id' => $candidate['id'],
								'exam_id' => $post['exam_id']
							];
							$record_exists = $this->exam_model->isExamAndCandidateExists($arr);
							if (!$record_exists) {
								$this->exam_model->insertExamCandidate($arr);
							}
							$exam_reg[] = $candidate['id'];
						}
					} else {
						$firstTwoLetters = substr($row[0], 0, 2);
						$password = strtolower($firstTwoLetters) . "@12345";
						if (!empty($row[4])) {
							$company = $this->client_model->searchCompany($row[4]);
						} else {
							$company = ['id' => ''];
						}

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
							'company_id' => (!empty($company)) ? $company['id'] : '',
							'source' => 'bulk',
						);

						$last_id = $this->candidate_model->insert($xlx_data);

						if ($last_id) {
							$new_reg[] = $last_id;

							$phone_nums[] = $xlx_data['phone'];

							$exl_data = array(
								'user_id' => $last_id,
								'company_id' => (!empty($company)) ? $company['id'] : '',
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

								'dob' => (!empty($row[5])) ? date('Y-m-d', strtotime($row[5])) : '0000-00-00',
								'whatsapp_number' => $row[7],
								'father_name' => $row[8],
								'bank_name' => $row[21],
								'account_num' => $row[22],
								'ifsc_code' => $row[23],
								'marital_status' => (!empty($row[24])) ? $row[24] : 'un-married'
							);

							try {
								$this->candidate_model->insertCandidateInfo($exl_data);

								$arr = [
									'candidate_id' => $last_id,
									'exam_id' => $post['exam_id']
								];

								if ($this->exam_model->insertExamCandidate($arr)) {
									$exam_reg[] = $last_id;
								}
							} catch (Exception $e) {

							}
						}

					}
				}
			}

			$this->sendNewRegEmail($new_reg);

			// $command1 = "php ".FCPATH."index.php exams sendNewRegEmail " . implode(' ', $new_reg) . " > /dev/null &";
			// exec($command1);

			if ($exam['status'] == 'scheduled') {
				$this->sendExamEmail($exam_reg, $post['exam_id']);
				$this->sendExamSMS($phone_nums, $post['exam_id']);

				// $command = "php ".FCPATH."index.php exams sendExamEmail " . implode(' ', $exam_reg) . " ". $post['exam_id'] . " > /dev/null &";
				// exec($command);

				// $command2 = "php ".FCPATH."index.php exams sendExamSMS " . implode(' ', $phone_nums) . " ". $post['exam_id'] . " > /dev/null &";
				// exec($command2);
			}

			$this->session->set_flashdata('success', 'Data uploaded successfully!');
		}

		redirect('exam/' . $post['exam_id'] . '/edit-candidates');
	}

	public function sendNewRegEmail($value = [])
	{
		$site_data = $this->setting_model->getSiteSetting();
		if ($site_data['new_user_mail_notif'] == 'on') {
			if (count($value)) {
				foreach ($value as $key => $user_id) {
					$user_info = $this->candidate_model->get($user_id);
					if (!empty($user_info)) {
						$htmlContent = $this->load->view('app/mail/account-registered', $user_info, true);
						// $config_arr=[
						// 	'api_url' => $site_data['out_smtp'],
						// 	'sender_address' => $site_data['smtp_email'],
						// 	'to_address' => $user_info['email'],
						// 	'subject' => 'Account created successfully!',
						// 	'body' => $htmlContent,
						// 	'api_key' => $site_data['smtp_pass'],
						// 	'to_name' => $user_info['firstname']
						// ];

						// $email_response = ($config_arr);

						$config_arr = [
							'out_smtp' => $site_data['out_smtp'],
							'smtp_port' => $site_data['smtp_port'],
							'smtp_email' => $site_data['smtp_email'],
							'smtp_pass' => $site_data['smtp_pass'],
							'app_name' => 'Simrangroups',
							'subject' => 'Account created successfully!',
							'body' => $htmlContent,
							'email' => $user_info['email'],
						];

						$email_response = sendMailViaSMTP($config_arr);
					}
				}
			}
		}
	}

	public function sendExamEmail($value = [], $exam_id = '')
	{
		if (!$exam_id) {
			redirect('exams');
		}
		$exam_details = $this->exam_model->get($exam_id);
		if (!$exam_details) {
			redirect('exams');
		}
		$site_data = $this->setting_model->getSiteSetting();
		$business = $this->business_model->get($exam_details['company_id']);
		if (count($value) && $exam_details['email_notif'] == 'on') {
			foreach ($value as $users => $user_id) {
				$user_info = $this->candidate_model->get($user_id);
				if (!empty($user_info)) {

					$templateKeys = [
						'name' => $user_info['firstname'] . " " . $user_info['middlename'] . " " . $user_info['lastname'],
						'firstname' => $user_info['firstname'],
						'middlename' => $user_info['middlename'],
						'lastname' => $user_info['lastname'],
						'company_name' => $site_data['app_name'],
						'exam_name' => $exam_details['name'],
						'exam_time' => date('H:i: a', strtotime($exam_details['exam_datetime'])),
						'exam_date' => date('d-m-Y', strtotime($exam_details['exam_datetime'])),
						'login_url' => base_url('candidate-login'),
						'login_qr' => base_url('assets/admin/img/qrcodes/candidate-login.png'),
						'business_name' => $business['company_name'] ?? $site_data['app_name'],
						'business_addr' => $business['company_address'] ?? '',
						'exam_login_url' => base_url('e/' . $exam_details['url']),
					];
					$inputString = $site_data['scheduled_exam_mail'];
					$replacementString = $inputString;

					foreach ($templateKeys as $key => $obj) {
						$placeholder = '${' . $key . '}';
						if ($key == 'login_qr') {
							$obj = htmlspecialchars('<div style="text-align:center;"><img src="' . $obj . '" height="300px"></div>');
						}
						if (!empty($obj)) {
							$replacementString = str_replace($placeholder, $obj, $replacementString);
						} else {
							$replacementString = str_replace($placeholder, '', $replacementString);
						}
					}

					$email_html = [];
					$email_html['data'] = $replacementString;

					$htmlContent = $this->load->view('app/mail/common-mail-template', $email_html, true);

					if ($site_data['mail_type'] == 'api') {
						$config_arr = [
							'api_url' => $site_data['out_smtp'],
							'sender_address' => $site_data['smtp_email'],
							'to_address' => $user_info['email'],
							'subject' => 'Scheduled Exam Remainder!',
							'body' => $htmlContent,
							'api_key' => $site_data['smtp_pass'],
							'to_name' => $user_info['firstname']
						];

						$email_response = sendMailViaApi($config_arr);
					} else {
						$config_arr = [
							'out_smtp' => $site_data['out_smtp'],
							'smtp_port' => $site_data['smtp_port'],
							'smtp_email' => $site_data['smtp_email'],
							'smtp_pass' => $site_data['smtp_pass'],
							'app_name' => 'Simrangroups',
							'subject' => 'Scheduled Exam Remainder!',
							'body' => $htmlContent,
							'email' => $user_info['email'],
						];

						$email_response = sendMailViaSMTP($config_arr);
					}

					$n_data['type'] = 'email';
					$n_data['user_id'] = $user_info['id'];
					$n_data['notif_type'] = 'Exam Schedule';
					$n_data['text'] = htmlspecialchars($htmlContent);
					$n_data['to_recipient'] = $user_info['email'];
					$n_data['created_on'] = date('Y-m-d H:i:s');

					if ($email_response) {
						$n_data['response'] = 'success';
						$this->notif_model->insertLog($n_data);
					} else {
						$n_data['response'] = 'failed';
						$n_data['req_response'] = $email_response;
						$this->notif_model->insertLog($n_data);
					}

					$up_data = ['email_sent' => $n_data['response']];
					$con_data = [
						'candidate_id' => $user_info['id'],
						'exam_id' => $exam_id,
					];
					$this->exam_model->updateExamCandidate($up_data, $con_data);
				}
			}
		}
	}

	public function sendExamSMS($phone_nums = [], $exam_id = '')
	{
		$site_data = $this->setting_model->getSiteSetting();
		if (!$exam_id) {
			redirect('exams');
		}

		$exam_details = $this->exam_model->get($exam_id);
		$business = $this->business_model->get($exam_details['company_id']);
		if (!$exam_details) {
			redirect('exams');
		}
		// $phone_nums = explode(' ', $phone_nums);
		if (count($phone_nums) > 0 && $exam_details['sms_notif'] == 'on') {
			foreach ($phone_nums as $numbers => $phone) {
				$get_candidate = $this->candidate_model->getByPhone($phone);

				if ($get_candidate) {
					$databaseValues = [
						'name' => $get_candidate['firstname'] . " " . $get_candidate['middlename'] . " " . $get_candidate['lastname'],
						'firstname' => $get_candidate['firstname'],
						'middlename' => $get_candidate['middlename'],
						'lastname' => $get_candidate['lastname'],
						'company_name' => $site_data['app_name'],
						'exam_date' => date('d-m-Y', strtotime($exam_details['exam_datetime'])),
						'exam_time' => date('H:i a', strtotime($exam_details['exam_datetime'])),
						'exam_datetime' => date('d-m-Y h:ia', strtotime($exam_details['exam_datetime'])),
						'login_url' => base_url('candidate-login'),
						'login_qr' => '',
						'business_name' => $business['company_name'] ?? $site_data['app_name'],
						'business_addr' => $business['company_address'] ?? '',
						'exam_login_url' => $exam_details['short_url'] ?? '',
					];

					$inputString = $site_data['scheduled_exam'];
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
						'apikey' => $site_data['sms_api_key'],
						'senderid' => $site_data['sms_sender_id'],
						'templateid' => $site_data['schexm_tempid'],
						'number' => $get_candidate['phone'],
						'message' => $replacementString,
					];

					$url .= '?' . http_build_query($params);

					$curl = curl_init();
					curl_setopt_array(
						$curl,
						array(
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
						)
					);
					$response = curl_exec($curl);
					$sms_resp = json_decode($response, true);

					$s_data['type'] = 'sms';
					$s_data['user_id'] = $get_candidate['id'];
					$s_data['notif_type'] = 'Exam Schedule';
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

					$up_data = ['sms_sent' => $s_data['response']];
					$con_data = [
						'candidate_id' => $get_candidate['id'],
						'exam_id' => $exam_id,
					];
					$this->exam_model->updateExamCandidate($up_data, $con_data);
				}
			}
		}
	}

	public function scheduleExam($value = '')
	{
		$this->isAdminOrManager();
		$exam = $this->exam_model->get($value);
		if (!$exam) {
			$this->session->set_flashdata('error', 'Please check exam details before scheduling exam!');
			redirect('exams');
		}

		$exam_datetime = strtotime($exam['exam_datetime']);
		if ($exam['exam_datetime'] != '0000-00-00 00:00:00' && !empty($exam['exam_datetime']) && $exam_datetime > time()) {

			$arr = ['status' => 'scheduled'];
			$this->exam_model->updateOnly($arr, $value);

			$this->session->set_flashdata('success', 'Exam scheduled successfully!');

			redirect('exams/' . $value . '/send-notifications');
		} else {
			$this->session->set_flashdata('error', 'You can not schedule exam on past datetime!');
		}

		redirect('exams');
	}

	public function sendNotifications($exam_id)
	{
		$this->isAdminOrManager();
		$exam = $this->exam_model->get($exam_id);
		if (!$exam || $exam['status'] != 'scheduled') {
			$this->session->set_flashdata('error', 'Please check exam details before sending exam notification!');
			redirect('exams');
		}

		if ($exam['sms_notif'] == 'off' && $exam['email_notif'] == 'off') {
			redirect('exams');
		}

		$candidates = $this->exam_model->fetchExamCandidates($exam_id);
		$arr_candidates = [];
		foreach ($candidates as $candidate => $cnd) {
			$temp['id'] = $cnd['candidate_id'];
			$cdt = $this->candidate_model->get($cnd['candidate_id']);
			if ($cdt) {
				$temp['name'] = trim($cdt['firstname'] . " " . $cdt['lastname']);
				$arr_candidates[] = $temp;
			}
		}

		$data = [
			'title' => 'Send Exam SMS & Email Notification',
			'exam' => $exam,
			'candidates' => $arr_candidates
		];

		$this->load->view('app/send-notifications', $data);
	}

	public function notifyCandidate()
	{
		$this->isAdminOrManager();
		$exam_id = $this->input->get('examid');
		$candidate_id = $this->input->get('userid');
		if (empty($exam_id) || empty($candidate_id) || $this->input->method != 'post') {
			$data['status'] = 'ERROR';
			$data['message'] = "Invalid request or missing required fields.";
		}

		$exam = $this->exam_model->get($exam_id);
		if (empty($exam)) {
			$data['status'] = 'ERROR';
			$data['message'] = "Exam does not exists!";
		}

		if (strtotime($exam['exam_endtime']) < time()) {
			$data['status'] = 'ERROR';
			$data['message'] = "Exam time has been over!";
		}

		$candidate = $this->candidate_model->get($candidate_id);
		if (empty($candidate)) {
			$data['status'] = 'ERROR';
			$data['message'] = "Candidate does not exists!";
		}

		$cond = [
			'exam_id' => $exam_id,
			'candidate_id' => $candidate_id,
		];
		$exists = $this->exam_model->isExamAndCandidateExists($cond);
		if (empty($exists)) {
			$data['status'] = 'ERROR';
			$data['message'] = "Candidate is not assisgned to this exam!";
		}

		$data['status'] = 'SUCCESS';
		$data['email_status'] = $this->sendExamEmailNotification($candidate_id, $exam_id);
		$data['sms_status'] = $this->sendExamSMSNotification($candidate_id, $exam_id);

		echo json_encode($data);
	}

	protected function sendExamEmailNotification($user_id = '', $exam_id = '')
	{
		$exam_details = $this->exam_model->get($exam_id);
		if ($exam_details['email_notif'] == 'off') { return 'success'; }
		$site_data = $this->setting_model->getSiteSetting();
		$business = $this->business_model->get($exam_details['company_id']);
		$user_info = $this->candidate_model->get($user_id);

		$templateKeys = [
			'name' => $user_info['firstname'] . " " . $user_info['middlename'] . " " . $user_info['lastname'],
			'firstname' => $user_info['firstname'],
			'middlename' => $user_info['middlename'],
			'lastname' => $user_info['lastname'],
			'company_name' => $site_data['app_name'],
			'exam_name' => $exam_details['name'],
			'exam_time' => date('H:i: a', strtotime($exam_details['exam_datetime'])),
			'exam_date' => date('d-m-Y', strtotime($exam_details['exam_datetime'])),
			'login_url' => base_url('candidate-login'),
			'login_qr' => base_url('assets/admin/img/qrcodes/candidate-login.png'),
			'business_name' => $business['company_name'] ?? $site_data['app_name'],
			'business_addr' => $business['company_address'] ?? '',
			'exam_login_url' => base_url('e/' . $exam_details['url']),
		];
		$inputString = $site_data['scheduled_exam_mail'];
		$replacementString = $inputString;

		foreach ($templateKeys as $key => $obj) {
			$placeholder = '${' . $key . '}';
			if ($key == 'login_qr') {
				$obj = htmlspecialchars('<div style="text-align:center;"><img src="' . $obj . '" height="300px"></div>');
			}
			if (!empty($obj)) {
				$replacementString = str_replace($placeholder, $obj, $replacementString);
			} else {
				$replacementString = str_replace($placeholder, '', $replacementString);
			}
		}

		$email_html = [];
		$email_html['data'] = $replacementString;

		$htmlContent = $this->load->view('app/mail/common-mail-template', $email_html, true);

		if ($site_data['mail_type'] == 'api') {
			$config_arr = [
				'api_url' => $site_data['out_smtp'],
				'sender_address' => $site_data['smtp_email'],
				'to_address' => $user_info['email'],
				'subject' => 'Scheduled Exam Remainder!',
				'body' => $htmlContent,
				'api_key' => $site_data['smtp_pass'],
				'to_name' => $user_info['firstname']
			];

			$email_response = sendMailViaApi($config_arr);
		} else {
			$config_arr = [
				'out_smtp' => $site_data['out_smtp'],
				'smtp_port' => $site_data['smtp_port'],
				'smtp_email' => $site_data['smtp_email'],
				'smtp_pass' => $site_data['smtp_pass'],
				'app_name' => 'Simrangroups',
				'subject' => 'Scheduled Exam Remainder!',
				'body' => $htmlContent,
				'email' => $user_info['email'],
			];

			$email_response = sendMailViaSMTP($config_arr);
		}

		$n_data['type'] = 'email';
		$n_data['user_id'] = $user_info['id'];
		$n_data['notif_type'] = 'Exam Schedule';
		$n_data['text'] = htmlspecialchars($htmlContent);
		$n_data['to_recipient'] = $user_info['email'];
		$n_data['created_on'] = date('Y-m-d H:i:s');

		if ($email_response) {
			$n_data['response'] = 'success';
			$this->notif_model->insertLog($n_data);
		} else {
			$n_data['response'] = 'failed';
			$n_data['req_response'] = $email_response;
			$this->notif_model->insertLog($n_data);
		}

		$up_data = ['email_sent' => $n_data['response']];
		$con_data = [
			'candidate_id' => $user_info['id'],
			'exam_id' => $exam_id,
		];
		$this->exam_model->updateExamCandidate($up_data, $con_data);

		return $n_data['response'];
	}

	protected function sendExamSMSNotification($user_id = '', $exam_id = '')
	{
		$site_data = $this->setting_model->getSiteSetting();
		$exam_details = $this->exam_model->get($exam_id);
		if ($exam_details['sms_notif'] == 'off') { return 'success'; }
		$business = $this->business_model->get($exam_details['company_id']);
		$get_candidate = $this->candidate_model->get($user_id);
		$databaseValues = [
			'name' => $get_candidate['firstname'] . " " . $get_candidate['middlename'] . " " . $get_candidate['lastname'],
			'firstname' => $get_candidate['firstname'],
			'middlename' => $get_candidate['middlename'],
			'lastname' => $get_candidate['lastname'],
			'company_name' => $site_data['app_name'],
			'exam_date' => date('d-m-Y', strtotime($exam_details['exam_datetime'])),
			'exam_time' => date('H:i a', strtotime($exam_details['exam_datetime'])),
			'exam_datetime' => date('d-m-Y h:ia', strtotime($exam_details['exam_datetime'])),
			'login_url' => base_url('candidate-login'),
			'login_qr' => '',
			'business_name' => $business['company_name'] ?? $site_data['app_name'],
			'business_addr' => $business['company_address'] ?? '',
			'exam_login_url' => $exam_details['short_url'] ?? '',
		];

		$inputString = $site_data['scheduled_exam'];
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
			'apikey' => $site_data['sms_api_key'],
			'senderid' => $site_data['sms_sender_id'],
			'templateid' => $site_data['schexm_tempid'],
			'number' => $get_candidate['phone'],
			'message' => $replacementString,
		];

		$url .= '?' . http_build_query($params);

		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
			)
		);
		$response = curl_exec($curl);
		$sms_resp = json_decode($response, true);

		$s_data['type'] = 'sms';
		$s_data['user_id'] = $get_candidate['id'];
		$s_data['notif_type'] = 'Exam Schedule';
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

		$up_data = ['sms_sent' => $s_data['response']];
		$con_data = [
			'candidate_id' => $get_candidate['id'],
			'exam_id' => $exam_id,
		];
		$this->exam_model->updateExamCandidate($up_data, $con_data);

		return $s_data['response'];
	}

	public function clone ($value = '')
	{
		$this->isAdminOrManager();
		if (empty($value)) {
			$this->session->set_flashdata('error', 'Exam not found!');
			redirect('exams');
		}
		$exam = $this->exam_model->get($value);
		if (empty($value)) {
			$this->session->set_flashdata('error', 'Exam not found!');
			redirect('exams');
		}
		$new_exam = [];
		$new_exam['name'] = $exam['name'] . "-cloned";
		$new_exam['duration'] = $exam['duration'];
		$new_exam['lang'] = $exam['lang'];
		$new_exam['pass_percentage'] = $exam['pass_percentage'];
		$new_exam['status'] = 'draft';
		$new_exam['url'] = uniqid();
		$new_exam['created_by'] = $this->session->userdata('id');
		$new_exam['created_at'] = date('Y-m-d H:i:s');
		$new_exam['creator_type'] = $this->session->userdata('type');
		$new_exam['exam_datetime'] = date('Y-m-d H:i:s');
		$new_exam['show_marks'] = $exam['show_marks'];
		$new_exam['sms_notif'] = $exam['sms_notif'];
		$new_exam['email_notif'] = $exam['email_notif'];

		$short_url = shortenLink(base_url('e/' . $new_exam['url']));
		$s_url = json_decode($short_url, true);

		if ($s_url['status'] == 'SUCCESS') {
			$new_exam['short_url'] = $s_url['link'];
		} else {
			$new_exam['short_url'] = "";
		}

		$last_id = $this->exam_model->create($new_exam);

		if ($last_id) {
			$questions = $this->exam_model->getExamQuestions($value);
			$ins_ex_ques = [];
			if (count($questions)) {
				foreach ($questions as $key => $que) {
					$temp['question_id'] = $que['question_id'];
					$temp['exam_id'] = $last_id;
					$ins_ex_ques[] = $temp;
				}
			}
			$this->exam_model->insertExamQuestions($ins_ex_ques);
		}
		$this->session->set_flashdata('success', 'Exam cloned successfully!');
		redirect('exams');
	}

	public function deleteMultiple()
	{
		if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		$post = $this->input->post();
		$ids = json_decode($post['checkedValues']);

		foreach ($ids as $key => $obj) {
			$this->exam_model->deleteExam($obj);
		}
		$data['status'] = "SUCCESS";
		$data['message'] = "Exam removed successfully!";
		$this->session->set_flashdata('success', "Exam removed successfully!");
		echo json_encode($data);
	}

	public function addSelectedCandidates()
	{
		if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		$post = $this->input->post();

		$ids = json_decode($post['checkedValues']);
		$exam_id = $post['examId'];
		foreach ($ids as $key => $obj) {
			$row = $this->exam_model->isExamAndCandidateExists(['exam_id' => $exam_id, 'candidate_id' => $obj]);
			if (!$row) {
				$this->exam_model->insertExamCandidate(['exam_id' => $exam_id, 'candidate_id' => $obj]);
			}
		}
		$data['status'] = "SUCCESS";
		$data['message'] = "Candidates added to exam successfully!";
		$this->session->set_flashdata('success', "Candidates added to exam successfully!");
		echo json_encode($data);
	}

	public function removeSelectedCandidates()
	{
		if (!$this->session->has_userdata('id')) {
			$data['status'] = "ERROR";
			$data['message'] = "Something went wrong!";
		}

		$post = $this->input->post();

		$ids = json_decode($post['checkedValues']);
		$exam_id = $post['examId'];
		foreach ($ids as $key => $obj) {
			$this->exam_model->deleteExamCandidates(['exam_id' => $exam_id, 'candidate_id' => $obj]);
		}
		$data['status'] = "SUCCESS";
		$data['message'] = "Candidates removed from exam successfully!";
		$this->session->set_flashdata('success', "Candidates removed from exam successfully!");
		echo json_encode($data);
	}

	public function addExamQuestion()
	{
		$this->isAdminOrManager();
		$data = [];
		if ($this->input->post()) {
			$post = $this->input->post();
			$db_data = [
				'exam_id' => $post['examid'],
				'question_id' => $post['questionid'],
			];

			$last_id = $this->exam_model->insertExamQuestion($db_data);
			if ($last_id) {
				$data['status'] = "SUCCESS";
				$data['message'] = "Question added to exam successfully!";
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "Question not added to exam!";
			}
		}

		echo json_encode($data);
	}

	public function removeExamQuestion()
	{
		$this->isAdminOrManager();
		if ($this->input->post()) {
			$db_data = [
				'exam_id' => $this->input->post('examid'),
				'question_id' => $this->input->post('questionid'),
			];

			$aff = $this->exam_model->deleteQuestionFromExam($db_data);

			if ($aff) {
				$data['status'] = "SUCCESS";
				$data['message'] = "Question removed from exam successfully!";
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "Question not removed from exam!";
			}
		}

		echo json_encode($data);
	}

	public function viewExamDashboard($exam_id = '')
	{
		$this->isAdminOrManager();
		$absent = 0;
		$submitted = 0;
		$appearing = 0;
		$exam = $this->exam_model->get($exam_id);
		if (!$exam) {
			$this->session->set_flashdata('error', 'Exam record not found!');
			redirect('exams');
		}

		if ($exam['creator_type'] == 'admin') {
			$exam['created_by'] = $_SESSION['firstname'] . " " . $_SESSION['middlename'] . " " . $_SESSION['lastname'];
		} else {
			$user_info = $this->manager_model->get($exam['created_by']);
			$exam['created_by'] = $user_info['firstname'] . " " . $user_info['middlename'] . " " . $user_info['lastname'];
		}

		$exam['appeared_candidates'] = $this->exam_model->countExamAppearedCandidates($exam_id);

		$candidates = $this->exam_model->getCandidateWithStats($exam_id);
		$candArr = [];
		foreach ($candidates as $key => $obj) {
			$temp = $obj;
			if (!empty($obj['profile_img']) && file_exists('./assets/img/thumbnails/' . $obj['profile_img'])) {
				$temp['profile_img'] = base_url('assets/img/thumbnails/' . $obj['profile_img']);
			} else {
				$temp['profile_img'] = base_url('assets/img/letter-p.png');
			}

			//Check if candidate is appearing or not
			$checkArr = ['user_id' => $obj['id'], 'exam_id' => $exam['id']];
			$candidateInfo = $this->exam_model->checkCandidateExamInfo($checkArr);
			if (!empty($candidateInfo)) {

				$from_time = strtotime($candidateInfo['entered_at']);
				$exam_time = strtotime($exam['exam_datetime']);
				if ($from_time <= $exam_time) {
					$from_time = $exam_time;
				}

				if ($candidateInfo['left_at'] == '0000-00-00 00:00:00' || empty($candidateInfo['left_at']) || strtotime($candidateInfo['left_at']) >= strtotime($exam['exam_endtime'])) {
					$currentTimestamp = time();
					$exam_endtime = strtotime($exam['exam_endtime']);
					$to_time = $exam_endtime;
					if ($currentTimestamp <= $exam_endtime) {
						$to_time = $currentTimestamp;
					}
					
					$diff_minutes = round(abs($from_time - $to_time) / 60) . " Mins";
					$temp['time'] = $diff_minutes;
					$temp['status'] = "Appearing";
					$appearing++;
				} else {
					$to_time = strtotime($candidateInfo['left_at']);

					$diff_minutes = round(abs($from_time - $to_time) / 60) . " Mins";
					$temp['time'] = $diff_minutes;
					$temp['status'] = "Submitted";
					$submitted++;
				}

				// Calculate Scores
				$calc = $this->calcScore($exam_id, $obj['id'], $exam['pass_percentage']);
				$temp['score'] = $calc['result'];
				$temp['percentage'] = $calc['score'];
				$temp['result'] = $calc['status'];
			} else {
				$temp['time'] = "";
				$temp['status'] = "Absent";
				$temp['score'] = "";
				$temp['percentage'] = "0";
				$temp['result'] = "Fail";
				$absent++;
			}

			$candArr[] = $temp;
		}

		function customSort($a, $b)
		{
			$scoreComparison = (floatval($b['score']) - floatval($a['score']));
			if ($scoreComparison === 0) {
				$timeA = intval($a['time']);
				$timeB = intval($b['time']);
				if (strpos($a['time'], 'Mins') !== false) {
					$timeA *= 1;
				}
				if (strpos($b['time'], 'Mins') !== false) {
					$timeB *= 1;
				}
				// Sort by time in ascending order
				return $timeA - $timeB;
			}
			// Sort by score in descending order
			return $scoreComparison;
		}

		usort($candArr, 'customSort');

		$data['candidates'] = $candArr;
		$data['business'] = $this->business_model->get($exam['company_id']);
		$data['exam'] = $exam;
		$data['title'] = "Exam Dashboard";
		$data['exam_id'] = $exam_id;
		$data['absent'] = $absent;

		$time = time();
		$exam_time = strtotime($exam['exam_datetime']);
		if ($time > $exam_time) {
			$data['appearing'] = 0;
		} else {
			$data['appearing'] = $appearing;
		}
		$data['submitted'] = $submitted;

		$this->load->view('app/exam-dashboard', $data);
	}

	public function calcScore($exam_id = '', $user_id = '', $passPercentage = '')
	{
		$questions = $this->exam_model->getExamQuestions($exam_id);
		$total_question = count($questions);
		$correct_answers = 0;
		$result = $this->exam_model->getExamResult($exam_id, $user_id);
		$ansArr = [];
		foreach ($result as $item) {
			$questionId = $item['question_id'];
			$status = $item['status'];
			if (array_key_exists($questionId, $ansArr)) {
				if ($status === 'incorrect') {
					$ansArr[$questionId] = $status;
				}
			} else {
				$ansArr[$questionId] = $status;
			}
		}

		foreach ($ansArr as $key => $obj) {
			if ($obj == 'correct') {
				$correct_answers++;
			}
		}

		$score = $correct_answers / $total_question * 100;

		$resultString = $correct_answers . "/" . $total_question;

		if ($score >= $passPercentage) {
			$resultStatus = "Pass";
		} else {
			$resultStatus = "Fail";
		}

		$arr = [
			'score' => $score,
			'result' => $resultString,
			'status' => $resultStatus
		];
		return $arr;
	}

	public function downloadExcel($exam_id = '')
	{
		$this->isAdminOrManager();
		$exam = $this->exam_model->get($exam_id);
		if (!$exam) {
			redirect('/exams');
		}
		$business = $this->business_model->get($exam['company_id']);
		$filePath = 'assets/admin/formats/joining-form.xlsx';
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
		$spreadsheet->getActiveSheet()->setCellValue('E2', $business['company_name'] ?? '');
		$writer = new Xlsx($spreadsheet);
		$writer->save($filePath);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="joining-form.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	private function generateName($user_id = '', $exam_id = '')
	{
		$candidate = $this->candidate_model->get($user_id);
		$filename = $candidate['firstname'];
		if (!empty($candidate['middlename'])) {
			$filename .= " " . $candidate['middlename'];
		}

		if (!empty($candidate['lastname'])) {
			$filename .= " " . $candidate['lastname'];
		}

		if (!empty($candidate['empid'])) {
			$filename .= "-" . $candidate['empid'];
		}
		return strtolower(str_replace(" ", "_", $filename)) . '-' . $exam_id . ".pdf";
	}

	public function generateDetailedResult($exam_id = '', $user_id = '')
	{
		$this->isNotACandidate();
		if (!isset($exam_id) || !isset($user_id)) {
			redirect('logout');
		}
		$filename = $this->generateName($user_id, $exam_id);
		$filepath = FCPATH . 'assets/admin/exams/' . $filename;
		$arr = [
			'exam_id' => $exam_id,
			'candidate_id' => $user_id,
		];
		$val = $this->exam_model->isExamAndCandidateExists($arr);
		if (!$val) {
			return false;
		}
		if (file_exists($filepath)) {
			return $filepath;
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
						if ($answer['isCorrect']) {
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
					if (!empty($user_answers)) {
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
					$temp['correct_user_answer_en'] = $user_answers['answer_id'] ?? '';
					$temp['correct_user_answer_hi'] = $user_answers['answer_id'] ?? '';
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

			$data['exam_log'] = $this->exam_model->checkCandidateExamInfo(['exam_id' => $exam_id, 'user_id' => $user_id]);

			$html = $this->load->view('app/pdfviews/view-candidate-answers', $data, true);
			$mpdf = new \Mpdf\Mpdf(['utf-8', 'A4-C']);
			$mpdf->WriteHTML($html);
			$output = $mpdf->Output('', 'S');
			file_put_contents($filepath, $output);

			$this->clearOlderFiles();
			return $filepath;
		}
	}

	public function downloadResult($exam_id = '')
	{
		$this->isAdminOrManager(true);
		$data = [];
		$outputPdf = 'assets/admin/exams/' . $exam_id . '.pdf';
		try {
			$files = [];
			if (!file_exists($outputPdf)) {
				$pdf = new \Clegginabox\PDFMerger\PDFMerger;
				$candidates = $this->exam_model->fetchExamCandidates($exam_id);
				$batchSize = 10;

				foreach (array_chunk($candidates, $batchSize) as $batch) {
					foreach ($batch as $candidate => $cnd) {
						$pdf_file = $this->generateDetailedResult($exam_id, $cnd['candidate_id']);
						$pdf->addPDF($pdf_file, 'all');
						$files[] = $pdf_file;
					}
				}

				$pdf->merge('file', $outputPdf);
				// $pdf->newPDF();

				$this->clearOlderFiles();
			}

			$data['status'] = 'SUCCESS';
			$data['message'] = 'Download Successful!';
			$data['file'] = base_url($outputPdf);
			// $data['files'] = $files;
		} catch (Exception $e) {
			$data['error'] = $e->getMessage();
		}
		echo json_encode($data);
	}

	public function checkResult($exam_id = '')
	{
		$this->isAdminOrManager(true);
		$data = [];
		$outputPdf = 'assets/admin/exams/' . $exam_id . '.pdf';
		if (file_exists($outputPdf)) {
			$data['status'] = 'SUCCESS';
			$data['message'] = 'File found!';
			$data['file'] = base_url($outputPdf);
		} else {
			$data['status'] = 'ERROR';
			$data['message'] = 'File not found!';
		}
		$this->clearOlderFiles();
		echo json_encode($data);
	}

	public function clearOlderFiles($value = '')
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
						// echo 'Deleted: ' . $file . PHP_EOL;
						return true;
					}
				}
			}
		} else {
			// echo 'Directory does not exist.' . PHP_EOL;
			return false;
		}
	}

	public function downloadPaper($exam_id = '')
	{
		$this->isNotACandidate();
		if (!isset($exam_id)) {
			redirect('logout');
		}
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
					if ($answer['isCorrect']) {
						$correctAnswerEng .= $answer['answer_text_en'] . ", ";
						$correctAnswerHin .= $answer['answer_text_hi'] . ", ";
					}
				}
				$temp['answers'] = $this->answer_model->getAnswersOfQuestion($que['question_id']);
				$temp['correct_answer_en'] = substr($correctAnswerEng, 0, -2);
				$temp['correct_answer_hi'] = substr($correctAnswerHin, 0, -2);


			}

			$result[] = $temp;
		}

		$data['result'] = $result;
		$data['exam'] = $this->exam_model->get($exam_id);
		$data['business'] = $this->business_model->get($data['exam']['company_id']);
		$data['title'] = "View Exam Paper";
		// $clients = $this->exam_model->getExamClients($exam_id);
		// $cli = '';
		// foreach ($clients as $key => $obj) {
		// 	$cli .= $obj['company_name'] . ",";
		// }
		// $data['clients'] = rtrim($cli, ',');

		// $data['exam_log'] = $this->exam_model->checkCandidateExamInfo(['exam_id'=>$exam_id, 'user_id'=>$user_id]);


		$html = $this->load->view('app/pdfviews/view-question-paper', $data, true);
		$mpdf = new \Mpdf\Mpdf(['utf-8', 'A4-C']);
		$mpdf->WriteHTML($html);
		$output = $mpdf->Output();

		$this->clearOlderFiles();
	}

	public function downloadResults($exam_id = '')
	{
		$this->isAdminOrManager();
		$exam = $this->exam_model->get($exam_id);
		if (!$exam) {
			redirect('/exams');
		}
		$candidates = $this->exam_model->fetchExamCandidates($exam_id);
		$arr_candidates = [];
		foreach ($candidates as $candidate => $cnd) {
			$temp['id'] = $cnd['candidate_id'];
			$cdt = $this->candidate_model->get($cnd['candidate_id']);
			if ($cdt) {
				$temp['name'] = trim($cdt['firstname'] . " " . $cdt['lastname']);
				$arr_candidates[] = $temp;
			}
		}
		$data['exam'] = $exam;
		$data['title'] = "Download Exam Results PDF";
		$data['candidates'] = $arr_candidates;

		$this->load->view('app/exam-result-pdf', $data);
	}

	public function clearResults($exam_id = '')
	{
		$this->isAdminOrManager();
		$exam = $this->exam_model->get($exam_id);
		if (!$exam) {
			redirect('/exams');
		}
		@unlink('assets/admin/exams/' . $exam_id . ".pdf");
		$candidates = $this->exam_model->fetchExamCandidates($exam_id);
		$arr_candidates = [];
		foreach ($candidates as $candidate => $cnd) {
			$user_id = $cnd['candidate_id'];
			$filename = $this->generateName($user_id, $exam_id);
			$filepath = FCPATH . 'assets/admin/exams/' . $filename;
			if (file_exists($filepath)) {
				@unlink($filepath);
			}
		}

		$this->session->set_flashdata('success', 'All generated pdfs are cleared!');
		if (isset($_GET['ret'])) {
			redirect('exams/' . $exam_id . '/download-results-pdf');
		} else {
			redirect('exams/' . $exam_id . '/view-exam-dashboard');
		}
	}

	public function generateFakeAnswers()
	{
		$jsonResponse = (isset($_GET['return']) && $_GET['return'] == 'json');
		if (!isset($_GET['userid']) || !isset($_GET['examid'])) {
			redirect('logout');
		}

		$exam_id = $this->input->get('examid', true);
		$userid = $this->input->get('userid', true);
		$user = $this->candidate_model->getUserByAadhaar($userid);
		$user_id = $user['user_id'];

		$exam = $this->exam_model->get($exam_id);
		$can['exam_id'] = $exam['id']; // Corrected to directly use the exam data
		$can['user_id'] = $user_id; // Directly using the fetched user_id
		$can['entered_at'] = date('Y-m-d H:i:s', strtotime($exam['exam_datetime']));
		$can['left_at'] = date('Y-m-d H:i:s', strtotime($exam['exam_endtime']));
		$can['exam_token'] = uniqid();
		$this->exam_model->deleteCandidateExamInfo($can['exam_id'], $can['user_id']);
		$this->exam_model->setCandidateExamInfo($can);
		$this->exam_model->deleteCandidateExamAnswers($can);

		$mark = $this->input->get('mark', true);
		$questions = $this->exam_model->getExamQuestions($exam_id);
		$totalQuestions = count($questions);
		$correctAnswersCount = $mark; 
		
		shuffle($questions);
		$created_at = strtotime($exam['exam_datetime']);

		foreach ($questions as $index => $que) {
			$answers_rec = $this->answer_model->getAnswersOfQuestion($que['question_id']);
			
			
			$correctAnswers = array_filter($answers_rec, function($answer) {
				return $answer['isCorrect'] == 1;
			});
			
			$incorrectAnswers = array_filter($answers_rec, function($answer) {
				return $answer['isCorrect'] == 0;
			});

			if ($correctAnswersCount > 0 && count($correctAnswers) > 0) {
				$selectedAnswer = $correctAnswers[array_rand($correctAnswers)];
				$correctAnswersCount--;
			} else {
				$selectedAnswer = $incorrectAnswers[array_rand($incorrectAnswers)];
			}
			
			$record = [
				'user_id' => $user_id,
				'question_id' => $que['question_id'],
				'answer_id' => $selectedAnswer['id'],
				'exam_id' => $exam_id,
				'status' => $selectedAnswer['isCorrect'] == 1 ? 'correct' : 'incorrect',
				'created_at' => date('Y-m-d H:i:s', $created_at),
			];

			$this->exam_model->submitAnswer($record);
			
			$created_at += rand(30, 90);
		}

		$res = ['status' => 'SUCCESS'];
		echo json_encode($res);
	}

}

/* End of file Exams.php */
/* Location: ./application/controllers/Exams.php */