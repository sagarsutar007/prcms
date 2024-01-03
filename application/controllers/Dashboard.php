<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Questions_model', 'questions');
		$this->load->model('Users_model', 'users');
		$this->load->model('Exams_model', 'exams');
		$this->load->model('Login_model', 'login');
		$this->load->model('Clients_model', 'client');
		$this->load->model('Candidates_model', 'candidate');
	}

	public function index()
	{
		$app_info = $this->login->getApplicationInfo();

		$this->session->set_userdata('app_name', $app_info['app_name']);
		$this->session->set_userdata('app_icon', $app_info['app_icon']);

		if ($this->session->has_userdata('id')) {
			if ($this->session->userdata('type') == 'candidate') {
				$this->candidate();
			} else if ($this->session->userdata('type') == 'client') {
				$this->client();
			} else {
				$this->admin();
			}
			
		} else {
			redirect('logout');
		}
	}

	public function admin()
	{
		if ($this->session->has_userdata('id')) {
			$data['total_question'] = $this->questions->count();
			// $data['total_exams'] = $this->exams->count();
			$companies = [];
			if (count($_SESSION['companies'])) {
				foreach ($_SESSION['companies'] as $key => $value) {
					$companies[] = $value['id'];
				}
			}
			$data['conducted_exams'] = $this->exams->countConductedExams($companies);
			$data['upcoming_exams'] = $this->exams->countUpcomingExams($companies);
			$data['total_candidate'] = $this->candidate->count();
			$data['total_client'] = $this->client->count();

			$actv_users_arr = [];
			$cand_regs = [['Date', 'Users']];
			$exam_recs = [['Date', 'Users']];

			for ($i=6; $i>=0; $i--) { 
				$date = date('Y-m', strtotime('-' . $i . ' months'));
				$re_date = date('M y', strtotime($date));
				$au_count = $this->candidate->countActiveUsers($date);
				$actv_users_arr[] = [$re_date, $au_count];

				$ur_count = $this->candidate->countUserRegistrations($date);
				$cand_regs[] = [$re_date, $ur_count];

				$er_count = $this->exams->countExamsConducted($date);
				$exam_recs[] = [$re_date, $er_count];
			}
			$data['active_users'] = json_encode($actv_users_arr);
			$data['candidate_regs'] = json_encode($cand_regs);
			$data['exam_records'] = json_encode($exam_recs);

			$this->load->view('app/dashboard', $data);

		} else {
			redirect('logout');
		}
	}

	public function client()
	{
		if ($this->session->has_userdata('id')) {
			$data = [];
			$data['app_info'] = $this->login->getApplicationInfo();
			$company = $this->client->getClientInfoByUserId($this->session->userdata('id'));
			$data['total_exams'] = (!empty($company))?$this->exams->countClientExams($company['id']):0;
			$data['upcoming_exams'] = (!empty($company))?$this->exams->countClientUpcomingExams($company['id']):0;
			$data['conducted_exams'] = (!empty($company))?$this->exams->countClientConductedExams($company['id']):0;

			$exam_records = $this->exams->getClientExamsConductedCount($company['id']);

			$exam_recs = [['Date', 'Users']];
			foreach ($exam_records as $exams_rec => $er) {
				$exam_recs[] = [$er['Month'], (int) $er['Count']];
			}
			$data['exam_records'] = json_encode($exam_recs);
			$data['company'] = $company;
			$this->load->view('app/dashboard', $data);

		} else {
			redirect('logout');
		}
	}

	public function candidate()
	{
		if ($this->session->has_userdata('id')) {
			$data['total_exams'] = $this->exams->countCandidatesTotalExams($this->session->userdata('id'));
			$data['upcoming_exams'] = $this->exams->countCandidatesUpcomingExams($this->session->userdata('id'));
			$data['completed_exams'] = $this->exams->countCandidatesCompletedExams($this->session->userdata('id'));
			$data['app_info'] = $this->login->getApplicationInfo();

			$data['exams'] = $this->exams->getCandidatesTodaysExam(null, 0, 'desc', $this->session->userdata('id'));
			$this->load->view('app/dashboard', $data);

		} else {
			redirect('logout');
		}
	}

	public function fetchActiveUsersData() {
		if (!$this->session->has_userdata('id')) {
			return json_encode(['status' => false, 'msg' => 'Unauthorized Access!']);
		}

		if(!$this->input->post()){
			return json_encode(['status'=>false,'msg'=>"Invalid Request"]);
		}

		$post = $this->input->post();
		$conArr = [];

		if(!empty($post['business_unit'])) {
			$conArr['company_id'] = $post['business_unit']??'';
		}

		if (!empty($post['from_date']) && !empty($post['to_date'])) {
			$conArr['startDate'] = $post['from_date']?date("Y-m-d", strtotime($post['from_date'])):'';
			$conArr['endDate'] = $post['to_date']?date("Y-m-d", strtotime($post['to_date'] . " +1 day")):'';

			$startDateTime = new DateTime($conArr['startDate']);
			$endDateTime = new DateTime($conArr['endDate']);
			
			$dateDifference = $startDateTime->diff($endDateTime)->days;
			if ($dateDifference > 90) {
				$result = $this->candidate->fetchActiveUsersData($conArr, $dateDifference);
			} else {
				$result = $this->candidate->fetchActiveUsersData($conArr);
			}
		} else {
			$result = $this->candidate->fetchActiveUsersData($conArr);
		}

		$actv_users_arr = [['Date', 'Users']];
		foreach ($result as $active_user => $au) {
			$actv_users_arr[] = [$au['date'], (int) $au['countVal']];
		}

		echo json_encode(["status"=>true,"data"=>$actv_users_arr]);
	}

	public function fetchCandidateRegsData() {
		if (!$this->session->has_userdata('id')) {
			return json_encode(['status' => false, 'msg' => 'Unauthorized Access!']);
		}

		if(!$this->input->post()){
			return json_encode(['status'=>false,'msg'=>"Invalid Request"]);
		}

		$post = $this->input->post();
		$conArr = [];

		if(!empty($post['business_unit'])) {
			$conArr['company_id'] = $post['business_unit']??'';
		}

		if (!empty($post['from_date']) && !empty($post['to_date'])) {
			$conArr['startDate'] = $post['from_date']?date("Y-m-d", strtotime($post['from_date'])):'';
			$conArr['endDate'] = $post['to_date']?date("Y-m-d", strtotime($post['to_date'] . " +1 day")):'';

			$startDateTime = new DateTime($conArr['startDate']);
			$endDateTime = new DateTime($conArr['endDate']);
			
			$dateDifference = $startDateTime->diff($endDateTime)->days;
			if ($dateDifference > 90) {
				$result = $this->candidate->fetchCandidateRegsData($conArr, $dateDifference);
			} else {
				$result = $this->candidate->fetchCandidateRegsData($conArr);
			}
		} else {
			$result = $this->candidate->fetchCandidateRegsData($conArr);
		}

		$actv_users_arr = [['Date', 'Users']];
		foreach ($result as $active_user => $au) {
			$actv_users_arr[] = [$au['date'], (int) $au['countVal']];
		}

		echo json_encode(["status"=>true,"data"=>$actv_users_arr]);
	}

	public function fetchExamsChartData() {
		if (!$this->session->has_userdata('id')) {
			return json_encode(['status' => false, 'msg' => 'Unauthorized Access!']);
		}

		if(!$this->input->post()){
			return json_encode(['status'=>false,'msg'=>"Invalid Request"]);
		}

		$post = $this->input->post();
		
		$conArr = [];
		$conArr['type'] = $this->session->userdata('type');

		if(!empty($post['business_unit'])) {
			$conArr['company_id'] = $post['business_unit']??'';
		}

		if (!empty($post['from_date']) && !empty($post['to_date'])) {
			$conArr['startDate'] = $post['from_date']?date("Y-m-d", strtotime($post['from_date'])):'';
			$conArr['endDate'] = $post['to_date']?date("Y-m-d", strtotime($post['to_date'] . " +1 day")):'';


			$startDateTime = new DateTime($conArr['startDate']);
			$endDateTime = new DateTime($conArr['endDate']);
			
			$dateDifference = $startDateTime->diff($endDateTime)->days;
			if ($dateDifference > 90) {
				$result = $this->exams->fetchExamsChartData($conArr, $dateDifference);
			} else {
				$result = $this->exams->fetchExamsChartData($conArr);
			}
		} else {
			$result = $this->exams->fetchExamsChartData($conArr);
		}

		$exams_records = [['Date', 'Users']];
		foreach ($result as $exams_recs => $er) {
			$exams_records[] = [$er['date'], (int) $er['countVal']];
		}

		echo json_encode(["status"=>true,"data"=>$exams_records]);
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */