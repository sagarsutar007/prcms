<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Exams_model extends CI_Model
{

	public $primary_table = 'exams';

	public function __construct()
	{
		parent::__construct();

	}

	public function countExamsConducted($date = '')
	{
		$this->db->from('exams');
		$this->db->like('created_at', $date);
		return $this->db->count_all_results();
	}

	public function count($company_id = '')
	{
		$this->db->where('company_id', $company_id);
		return $this->db->count_all_results($this->primary_table);
	}

	public function countConductedExams($company_id = [])
	{
		if (count($company_id)) {
			$this->db->where_in('company_id', $company_id);
		}
		$this->db->where('status', 'scheduled');
		$this->db->where('exam_endtime < ', date('Y-m-d H:i:s'));
		return $this->db->count_all_results($this->primary_table);
	}

	public function countUpcomingExams($company_id = [])
	{
		if (count($company_id)) {
			$this->db->where_in('company_id', $company_id);
		}
		$this->db->where('status', 'scheduled');
		$this->db->where('exam_datetime > ', date('Y-m-d H:i:s'));
		return $this->db->count_all_results($this->primary_table);
	}

	public function get($value = '')
	{
		$this->db->select('*');
		$this->db->select('(SELECT COUNT(*) AS clients FROM `exam_clients` WHERE exam_id = exams.id) AS clients');
		$this->db->select('(SELECT COUNT(*) AS candidates FROM `exam_candidates` WHERE exam_id = exams.id) AS candidates');
		$this->db->select('(SELECT COUNT(*) AS questions FROM `exam_questions` WHERE exam_id = exams.id) AS questions');
		$this->db->select('(SELECT company_name FROM `companies` WHERE id = exams.company_id) AS company_name');
		$this->db->where('id', $value);
		$this->db->from($this->primary_table);
		$q = $this->db->get();
		return $q->row_array();
	}

	public function get_data($limit, $offset, $order = "desc", $company_id = '')
	{
		$this->db->select('*');
		$this->db->select('(SELECT COUNT(*) AS total FROM `exam_clients` WHERE exam_id = exams.id) AS total');
		$this->db->select('(SELECT COUNT(*) AS candidates FROM `exam_candidates` WHERE exam_id = exams.id) AS total_candidates');
		$this->db->select('(SELECT COUNT(*) AS questions FROM `exam_questions` WHERE exam_id = exams.id) AS total_questions');
		$this->db->select('(SELECT company_name FROM `companies` WHERE id = exams.company_id) AS company_name');
		$this->db->order_by('created_at', $order);
		$this->db->limit($limit, $offset);
		$this->db->from($this->primary_table);
		if ($company_id) {
			$this->db->where('company_id', $company_id);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function create($data = '')
	{
		$ins_data = [
			'name' => $data['name'],
			'company_id' => $data['company_id'] ?? '',
			'duration' => $data['duration'],
			'created_at' => $data['created_at'],
			'lang' => $data['lang'],
			'pass_percentage' => $data['pass_percentage'],
			'url' => $data['url'],
			'exam_datetime' => $data['exam_datetime'] ?? '',
			'exam_endtime' => $data['exam_endtime'] ?? '',
			'status' => $data['status'],
			'created_at' => $data['created_at'],
			'created_by' => $data['created_by'],
			'creator_type' => $data['creator_type'],
			'show_marks' => $data['show_marks'],
			'sms_notif' => $data['sms_notif'],
			'email_notif' => $data['email_notif'],
			'short_url' => $data['short_url'] ?? ''
		];
		$this->db->insert($this->primary_table, $ins_data);
		return $this->db->insert_id();
	}

	public function update($data = '', $id = '')
	{
		$ins_data = [
			'name' => $data['name'],
			'company_id' => $data['company_id'],
			'duration' => $data['duration'],
			'pass_percentage' => $data['pass_percentage'],
			'lang' => $data['lang'],
			'exam_datetime' => $data['exam_datetime'],
			'exam_endtime' => $data['exam_endtime'],
			'show_marks' => $data['show_marks'],
			'sms_notif' => $data['sms_notif'],
			'email_notif' => $data['email_notif'],
		];
		if (isset($data['status'])) {
			$ins_data['status'] = $data['status'];
		}
		$this->db->update($this->primary_table, $ins_data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function updateOnly($data = '', $id = '')
	{
		$this->db->update($this->primary_table, $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function getExamClients($value = '')
	{
		$this->db->select('c.id, c.company_name, c.company_logo');
		$this->db->from('companies c');
		$this->db->join('exam_clients ec', 'c.id = ec.client_id');
		$this->db->where('ec.exam_id', $value);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function insertExamQuestions($data = '')
	{
		$this->db->insert_batch('exam_questions', $data);
		return $this->db->affected_rows();
	}

	public function insertExamQuestion($data = '')
	{
		$this->db->insert('exam_questions', $data);
		return $this->db->affected_rows();
	}

	public function deleteQuestionFromExam($data = '')
	{
		$this->db->delete('exam_questions', $data);
		return $this->db->affected_rows();
	}

	public function insertExamCandidate($data = '')
	{
		$this->db->insert('exam_candidates', $data);
		return $this->db->insert_id();
	}

	public function updateExamCandidate($data = '', $condition = '')
	{
		$this->db->update('exam_candidates', $data, $condition);
		return $this->db->affected_rows();
	}

	public function addExamLog($data = [])
	{
		if (isset($data['headers']) && !empty($data['headers'])) {
			$headers = json_decode($data['headers'], true);
			if (isset($headers['Cookie']) && !empty($headers['Cookie'])) {
				$cookieString = $headers['Cookie'];

				$matches = array();

				if (preg_match("/exam_entry=(.*?);/", $cookieString, $matches)) {
				  $examEntryValue = $matches[1];
				  $data['req_cookie'] = $examEntryValue;
				} else {
				  $data['req_cookie'] = '';
				}
			}

			if (isset($headers['sec-ch-ua']) && !empty($headers['sec-ch-ua'])) {
				$channels = explode(",", $headers['sec-ch-ua']);
				$data['browser'] = end($channels);
			}

			if (isset($headers['sec-ch-ua-platform']) && !empty($headers['sec-ch-ua-platform'])) {
				$data['platform'] = $headers['sec-ch-ua-platform'];
			}

			if (isset($headers['sec-ch-ua-mobile']) && !empty($headers['sec-ch-ua-mobile'])) {
				$data['isMobile'] = $headers['sec-ch-ua-mobile'] == "?1" ? 'Yes' : 'No';
			}
		}
		
		$this->db->insert('exam_candidate_logs', $data);
		return $this->db->insert_id();
	}

	public function isExamAndCandidateExists($data = '')
	{
		$q = $this->db->get_where('exam_candidates', $data);
		return $q->row_array();
	}

	public function getExamCandidate($id = '')
	{
		$q = $this->db->get_where('exam_candidates', ['id' => $id]);
		return $q->row_array();
	}

	public function removeExamCandidate($id = '')
	{
		$this->db->delete('exam_candidates', ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function removeExamCandidates($exam_id = '')
	{
		$this->db->delete('exam_candidates', ['exam_id' => $exam_id]);
		return $this->db->affected_rows();
	}

	public function deleteExamCandidates($data = [])
	{
		$this->db->delete('exam_candidates', $data);
		return $this->db->affected_rows();
	}

	public function fetchExamCandidates($exam_id = '')
	{
		$q = $this->db->get_where('exam_candidates', ['exam_id' => $exam_id]);
		return $q->result_array();
	}

	public function getExamCandidates($exam_id = '', $limit = null, $offset = null, $company_id = '', $status = '', $search_term = '', $order_column = '', $order_dir = '')
	{
		$sql = "SELECT `u`.`firstname`, `u`.`middlename`, `u`.`lastname`, `u`.`phone`, `u`.`email`, `u`.`id` AS `user_id`, `ec`.`id`, `ec`.`sms_sent`, `ec`.`email_sent`, `u`.`created_at`, `u`.`empid`
	            FROM `candidates` `u`
	            LEFT JOIN `exam_candidates` `ec` ON `u`.`id` = `ec`.`candidate_id` AND `ec`.`exam_id` = '" . $exam_id . "'
	            WHERE `u`.`company_id` = " . $company_id . " AND `u`.`status` = '" . $status . "'";

		if (!empty($search_term)) {
			$sql .= " AND (";
			$sql .= "`u`.`firstname` LIKE '%" . $search_term . "%' OR ";
			$sql .= "`u`.`middlename` LIKE '%" . $search_term . "%' OR ";
			$sql .= "`u`.`lastname` LIKE '%" . $search_term . "%' OR ";
			$sql .= "`u`.`phone` LIKE '%" . $search_term . "%' OR ";
			$sql .= "`u`.`email` LIKE '%" . $search_term . "%'";
			$sql .= ")";
		}

		if (!empty($order_column) && !empty($order_dir)) {
			switch ($order_column) {
				case 'Name':
					$sql .= " ORDER BY `u`.`firstname` " . $order_dir . ", `u`.`middlename` " . $order_dir . ", `u`.`lastname` " . $order_dir;
					break;
				case 'Phone':
					$sql .= " ORDER BY `u`.`phone` " . $order_dir;
					break;
				case 'Email':
					$sql .= " ORDER BY `u`.`email` " . $order_dir;
					break;
				case 'Registered':
					$sql .= " ORDER BY `u`.`created_at` " . $order_dir;
					break;
				default:
					$sql .= " ORDER BY CASE WHEN `ec`.`exam_id` = '" . $exam_id . "' AND `ec`.`candidate_id` = `u`.`id` THEN 0 ELSE 1 END, `user_id` DESC";
			}
		} else {
			$sql .= " ORDER BY CASE WHEN `ec`.`exam_id` = '" . $exam_id . "' AND `ec`.`candidate_id` = `u`.`id` THEN 0 ELSE 1 END, `user_id` DESC";
		}

		if ($limit !== null && $offset !== null) {
			$sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
		}
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function countExamCandidatesData($exam_id = '', $company_id = '', $status = '', $search_term = '', $order_column = '', $order_dir = '')
	{
		$sql = "SELECT count(*) AS total, `u`.`id` AS `user_id` FROM `candidates` `u` LEFT JOIN `exam_candidates` `ec` ON `u`.`id` = `ec`.`candidate_id` AND `ec`.`exam_id` = '" . $exam_id . "'
	            WHERE `u`.`company_id` = " . $company_id . " AND `u`.`status` = '" . $status . "'";

		if (!empty($search_term)) {
			$sql .= " AND (";
			$sql .= "`u`.`firstname` LIKE '%" . $search_term . "%' OR ";
			$sql .= "`u`.`middlename` LIKE '%" . $search_term . "%' OR ";
			$sql .= "`u`.`lastname` LIKE '%" . $search_term . "%' OR ";
			$sql .= "`u`.`phone` LIKE '%" . $search_term . "%' OR ";
			$sql .= "`u`.`email` LIKE '%" . $search_term . "%'";
			$sql .= ")";
		}

		if (!empty($order_column) && !empty($order_dir)) {
			switch ($order_column) {
				case 'Name':
					$sql .= " ORDER BY `u`.`firstname` " . $order_dir . ", `u`.`middlename` " . $order_dir . ", `u`.`lastname` " . $order_dir;
					break;
				case 'Phone':
					$sql .= " ORDER BY `u`.`phone` " . $order_dir;
					break;
				case 'Email':
					$sql .= " ORDER BY `u`.`email` " . $order_dir;
					break;
				case 'Registered':
					$sql .= " ORDER BY `u`.`created_at` " . $order_dir;
					break;
				default:
					$sql .= " ORDER BY CASE WHEN `ec`.`exam_id` = '" . $exam_id . "' AND `ec`.`candidate_id` = `u`.`id` THEN 0 ELSE 1 END, `user_id` DESC";
			}
		} else {
			$sql .= " ORDER BY CASE WHEN `ec`.`exam_id` = '" . $exam_id . "' AND `ec`.`candidate_id` = `u`.`id` THEN 0 ELSE 1 END, `user_id` DESC";
		}

		$q = $this->db->query($sql);
		$resp = $q->row_array();
		if ($resp) {
			return $resp['total'];
		} else {
			return 0;
		}
	}

	public function getExamScheduledCandidates($exam_id = '')
	{
		$sql = "SELECT `u`.`firstname`, `u`.`middlename`, `u`.`lastname`, `u`.`phone`, `u`.`email`, `u`.`id` AS `user_id`, `ec`.`id`, `ec`.`sms_sent`, `ec`.`email_sent`
		FROM `candidates` `u` INNER JOIN `exam_candidates` `ec` ON `u`.`id` = `ec`.`candidate_id` WHERE `ec`.`exam_id` = '" . $exam_id . "'";
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function changeStatus($id = '', $status = 'draft')
	{
		$this->db->update($this->primary_table, ['status' => $status], ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function getExamQuestionCategories($exam_id = '')
	{
		$this->db->select('DISTINCT(q.category_id) as category');
		$this->db->from('questions q');
		$this->db->join('exam_questions eq', 'eq.question_id = q.question_id');
		$this->db->where('eq.exam_id', $exam_id);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function getCandidatesUpcomingExam($limit, $offset, $order = "desc", $value = '')
	{
		$currentDatetime = date('Y-m-d H:i:s');
		$this->db->select('e.*');
		$this->db->select('(SELECT COUNT(*) AS total FROM `exam_questions` WHERE exam_id = e.id) AS total');
		$this->db->from('exam_candidates ec');
		$this->db->join('exams e', 'ec.exam_id = e.id');
		$this->db->where('ec.candidate_id', $value);
		$this->db->where('e.status', 'scheduled');
		$this->db->where('e.exam_datetime >', $currentDatetime);
		$this->db->order_by('e.created_at', $order);
		$this->db->limit($limit, $offset);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function getCandidatesTodaysExam($limit, $offset, $order = "desc", $value = '')
	{
		$currentDatetime = date('Y-m-d H:i:s');
		$this->db->select('e.*');
		$this->db->select('(SELECT COUNT(*) AS total FROM `exam_questions` WHERE exam_id = e.id) AS total');
		$this->db->from('exam_candidates ec');
		$this->db->join('exams e', 'ec.exam_id = e.id');
		$this->db->where('ec.candidate_id', $value);
		$this->db->where('e.status', 'scheduled');
		$this->db->where('e.exam_endtime >', $currentDatetime);
		$this->db->order_by('e.created_at', $order);
		$this->db->limit($limit, $offset);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function countCandidatesUpcomingExam($value = '')
	{
		$currentDatetime = date('Y-m-d H:i:s');
		$this->db->select('e.*');
		$this->db->from('exam_candidates ec');
		$this->db->join('exams e', 'ec.exam_id = e.id');
		$this->db->where('ec.candidate_id', $value);
		$this->db->where('e.status !=', 'draft');
		$this->db->where('e.status !=', 'cancelled');
		$this->db->where('e.exam_datetime >', $currentDatetime);
		return $this->db->count_all_results();
	}

	public function countClientExams($value = '')
	{
		if (empty($value))
			return null;
		$this->db->where('ec.client_id', $value);
		$this->db->from('exam_clients ec');
		return $this->db->count_all_results();
	}

	public function countClientUpcomingExams($value = '')
	{
		if (empty($value))
			return null;
		$this->db->where('ec.client_id', $value);
		$this->db->where('e.status', 'scheduled');
		$this->db->where('e.exam_endtime >', date('Y-m-d H:i:s'));
		$this->db->from('exam_clients ec');
		$this->db->join('exams e', 'e.id = ec.exam_id');
		return $this->db->count_all_results();
	}

	public function countClientConductedExams($value = '')
	{
		if (empty($value))
			return null;

		$this->db->where('ec.client_id', $value);
		$this->db->where('e.status', 'scheduled');
		$this->db->where('e.exam_endtime <', date('Y-m-d H:i:s'));
		$this->db->from('exam_clients ec');
		$this->db->join('exams e', 'e.id = ec.exam_id');
		return $this->db->count_all_results();
	}

	public function countCandidatesCompletedExam($value = '')
	{
		$this->db->select('e.*');
		$this->db->from('exam_candidates ec');
		$this->db->join('exams e', 'ec.exam_id = e.id');
		$this->db->where('ec.candidate_id', $value);
		$this->db->where('e.status', 'conducted');
		return $this->db->count_all_results();
	}

	public function getCandidatesExam($candidate_id = '')
	{
		$currentDatetime = date('Y-m-d H:i:s');
		$tenMinutesBefore = date('Y-m-d H:i:s', strtotime('-10 minutes', strtotime($currentDatetime)));
		$tenMinutesAhead = date('Y-m-d H:i:s', strtotime('+10 minutes', strtotime($currentDatetime)));

		$this->db->select('e.*');
		$this->db->select('(SELECT COUNT(*) AS total FROM `exam_questions` WHERE exam_id = e.id) AS total');
		$this->db->from('exam_candidates ec');
		$this->db->join('exams e', 'ec.exam_id = e.id');
		$this->db->where('ec.candidate_id', $candidate_id);
		$this->db->where('e.status', 'scheduled');
		$this->db->where("'$currentDatetime' BETWEEN DATE_SUB(e.exam_datetime, INTERVAL 10 MINUTE) AND e.exam_endtime", null, false);

		$q = $this->db->get();
		return $q->result_array();
	}

	public function getFromUrl($value = '')
	{
		$this->db->where('url', $value);
		$this->db->from($this->primary_table);
		$q = $this->db->get();
		return $q->row_array();
	}

	public function countExamQuestion($value = '')
	{
		$this->db->where('exam_id', $value);
		return $this->db->count_all_results('exam_questions');
	}

	public function countExamCandidates($value = '')
	{
		$this->db->where('exam_id', $value);
		return $this->db->count_all_results('exam_candidates');
	}

	public function checkExamAndQuestionExists($data = [])
	{
		$this->db->where($data);
		$this->db->from('exam_questions');
		$q = $this->db->get();
		return $q->row_array();
	}

	public function removeExamQuestions($exam_id = '')
	{
		$this->db->delete('exam_questions', ['exam_id' => $exam_id]);
		return $this->db->affected_rows();
	}

	public function getExamQuestions($exam_id = '', $status = '')
	{
		$this->db->select('eq.id as eqid, q.*');
		$this->db->select('(SELECT category_name FROM `categories` WHERE id = q.category_id) AS category_name');
		$this->db->from('questions q');
		$this->db->join('exam_questions eq', 'eq.question_id = q.question_id');
		$this->db->where('eq.exam_id', $exam_id);
		if (!empty($status)) {
			$this->db->where('q.status', $status);
		}
		$q = $this->db->get();
		return $q->result_array();
	}

	public function getLeftQuestions($ids = [])
	{
		$this->db->select('q.*');
		$this->db->select('(SELECT category_name FROM `categories` WHERE id = q.category_id) AS category_name');
		$this->db->from('questions q');
		if (!empty($ids)) {
			$this->db->where_not_in('q.question_id', $ids);
		}
		$q = $this->db->get();
		return $q->result_array();
	}

	public function deleteExamQuestions($value = '')
	{
		$this->db->delete('exam_questions', ['exam_id' => $value]);
		return $this->db->affected_rows();
	}

	public function removeExamQuestion($value = '')
	{
		$this->db->delete('exam_questions', ['id' => $value]);
		return $this->db->affected_rows();
	}

	public function submitAnswer($value = '')
	{
		$this->db->insert('exam_records', $value);
		return $this->db->insert_id();
	}

	public function deleteAnswer($data = '')
	{
		$this->db->delete('exam_records', ['user_id' => $data['user_id'], 'question_id' => $data['question_id'], 'exam_id' => $data['exam_id']]);
		return $this->db->affected_rows();
	}

	public function deleteAnswerById($ans_id = '')
	{
		$this->db->delete('exam_records', ['id' => $ans_id]);
		return $this->db->affected_rows();
	}

	public function checkAnswerExists($data = '')
	{
		$q = $this->db->get_where('exam_records', [
			'user_id' => $data['user_id'],
			'question_id' => $data['question_id'],
			'exam_id' => $data['exam_id'],
			'answer_id' => $data['answer_id']
		]);
		return $q->row_array();
	}

	public function getUserAnswer($data = '')
	{
		$arr = [
			'user_id' => $data['user_id'],
			'question_id' => $data['question_id'],
			'exam_id' => $data['exam_id']
		];
		$this->db->where($arr);
		$this->db->from('exam_records');
		$q = $this->db->get();
		return $q->row_array();
	}

	public function getUserAnswers($data = '')
	{
		$arr = [
			'ec.user_id' => $data['user_id'],
			'ec.question_id' => $data['question_id'],
			'ec.exam_id' => $data['exam_id']
		];
		$this->db->select('ec.*, a.answer_text_en, a.answer_text_hi');
		$this->db->where($arr);
		$this->db->from('exam_records ec');
		$this->db->join('answers a', 'a.id = ec.answer_id');
		$q = $this->db->get();
		return $q->result_array();
	}

	public function getExamResult($exam_id = '', $user_id = '')
	{
		$arr = [
			'er.user_id' => $user_id,
			'er.exam_id' => $exam_id
		];
		$this->db->select('er.*, q.question_type');
		$this->db->from('exam_records er');
		$this->db->join('questions q', 'q.question_id = er.question_id');

		$this->db->where($arr);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function checkCandidateExamInfo($data = '')
	{
		$arr = [
			'user_id' => $data['user_id'],
			'exam_id' => $data['exam_id']
		];
		$this->db->where($arr);
		$this->db->from('candidate_exam_records');
		$q = $this->db->get();
		return $q->row_array();
	}

	public function enableRetry($data = '')
	{
		$arr = [
			'user_id' => $data['user_id'],
			'exam_id' => $data['exam_id']
		];
		$this->db->update('candidate_exam_records', [
			're_entry' => 'true',
			'exam_token' => '',
			'left_at' => null,
			're_entry_timestamp' => null
		], $arr);
		return $this->db->affected_rows();
	}

	public function setCandidateExamInfo($data = '')
	{
		$this->db->insert('candidate_exam_records', $data);
		return $this->db->insert_id();
	}

	public function updateCandidateExamInfo($data = '', $id = '')
	{
		$this->db->update('candidate_exam_records', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function updateCandidatesExamInfo($data = '', $id = '')
	{
		$this->db->update('candidate_exam_records', $data, ['exam_id' => $id]);
		return $this->db->affected_rows();
	}

	public function updateCandidatesExamLeftInfo($data = '', $id = '', $specifiedTime = '')
	{
		// Assuming $specifiedTime is in seconds
		$this->db->where("(left_at IS NULL OR TIMESTAMPDIFF(SECOND, left_at, NOW()) > '" . $specifiedTime . "')", NULL, FALSE);
		$this->db->where('exam_id', $id);
		$this->db->update('candidate_exam_records', $data);

		return $this->db->affected_rows();
	}

	public function insertExamClients($data = '', $exam_id = '')
	{
		$ins_arr = [];
		foreach ($data as $key => $obj) {
			$temp['client_id'] = $obj;
			$temp['exam_id'] = $exam_id;
			$ins_arr[] = $temp;
		}

		$this->db->insert_batch('exam_clients', $ins_arr);
		return $this->db->affected_rows();
	}

	public function removeExamClients($value = '')
	{
		$this->db->delete('exam_clients', ['exam_id' => $value]);
		return $this->db->affected_rows();
	}

	public function getExamResults($exam_id = '')
	{
		$this->db->select('u.id, u.firstname, u.middlename, u.lastname, u.phone, u.email, u.gender');
		$this->db->from('candidates u');
		$this->db->join('exam_candidates ec', 'ec.candidate_id = u.id');
		$this->db->where('ec.exam_id', $exam_id);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function countCandidatesTotalExams($user_id = '')
	{
		$this->db->from('exam_candidates');
		$this->db->where('candidate_id', $user_id);
		return $this->db->count_all_results();
	}

	public function countCandidatesUpcomingExams($user_id = '')
	{
		$currentDatetime = date('Y-m-d H:i:s');
		$this->db->from('exam_candidates ec');
		$this->db->join('exams e', 'e.id = ec.exam_id');
		$this->db->where('ec.candidate_id', $user_id);
		$this->db->where('e.exam_datetime >', $currentDatetime);
		$this->db->where('e.status', 'scheduled');
		return $this->db->count_all_results();
	}

	public function countCandidatesCompletedExams($user_id = '')
	{
		$this->db->select('COUNT(DISTINCT(exam_id)) AS total');
		$this->db->where('user_id', $user_id);
		$this->db->from('exam_records');

		$query = $this->db->get();
		if ($query->row()) {
			return $query->row()->total;
		} else {
			return "0";
		}
	}

	public function getCandidatesCompletedExam($limit, $offset, $order = "desc", $value = '')
	{
		$currentDatetime = date('Y-m-d H:i:s');
		$this->db->select('e.*');
		$this->db->select('(SELECT COUNT(*) AS total FROM `exam_questions` WHERE exam_id = e.id) AS total');
		$this->db->from('exams e');
		$this->db->join('candidate_exam_records ec', 'ec.exam_id = e.id');
		$this->db->where('ec.user_id', $value);
		$this->db->where('e.exam_datetime <', $currentDatetime);
		$this->db->order_by('e.created_at', $order);
		// $this->db->limit($limit, $offset);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function deleteExam($value = '')
	{
		$this->db->delete('exam_candidates', ['exam_id' => $value]);
		$this->db->delete('exam_clients', ['exam_id' => $value]);
		$this->db->delete('exam_questions', ['exam_id' => $value]);
		$this->db->delete('exam_records', ['exam_id' => $value]);
		$this->db->delete('exams', ['id' => $value]);
		return $this->db->affected_rows();
	}

	public function getCorrectExamAns($exam_id = '', $user_id = '')
	{
		$this->db->select('COUNT(question_id) as count_ans, status');
		$this->db->from('exam_records');
		$this->db->where('exam_id', $exam_id);
		$this->db->where('user_id', $user_id);
		$this->db->limit(1);
		$this->db->where('status', 'correct');
		$this->db->group_by('status');

		$query = $this->db->get();
		return $query->row_array();
	}

	public function isExamAttended($cand_id = '', $exam_id = '')
	{
		$q = $this->db->get_where('candidate_exam_records', ['user_id' => $cand_id, 'exam_id' => $exam_id]);
		if ($q->row()) {
			return true;
		} else {
			return false;
		}
	}

	public function countExamAppearedCandidates($exam_id = '')
	{
		$this->db->where('exam_id', $exam_id);
		return $this->db->count_all_results('candidate_exam_records');
	}

	// public function getCandidateWithStats($exam_id='')
	// {
	// 	$sql = "SELECT c.id, CONCAT_WS( ' ', c.firstname, c.middlename, c.lastname ) AS name, c.profile_img, ( SELECT COUNT(*) FROM exam_records ecr WHERE ecr.status = 'correct' AND ecr.user_id = c.id AND exam_id = ec.exam_id) AS correct_ans, ( SELECT COUNT(*) FROM exam_records ecr WHERE ecr.status = 'incorrect' AND ecr.user_id = c.id AND exam_id = ec.exam_id ) AS incorrect_ans, ( SELECT COUNT(*) FROM exam_records ecr WHERE ecr.status = 'unknown' AND ecr.user_id = c.id AND exam_id = ec.exam_id ) AS unknown_ans FROM `candidates` c INNER JOIN `exam_records` ec ON c.id = ec.user_id WHERE ec.exam_id = $exam_id GROUP BY ec.user_id ORDER BY correct_ans DESC";

	// 	$q = $this->db->query($sql);
	// 	return $q->result_array();
	// }

	public function getCandidateWithStats($exam_id = '')
	{
		$sql = "SELECT c.id, CONCAT_WS( ' ', c.firstname, c.middlename, c.lastname ) AS name, c.empid, cd.aadhaar_number, c.phone, c.profile_img FROM `candidates` c INNER JOIN candidate_details cd ON c.id = cd.user_id INNER JOIN `exam_candidates` ec ON c.id = ec.candidate_id WHERE ec.exam_id = $exam_id";

		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function getExamsConductedCount()
	{
		$sql = "SELECT DATE_FORMAT( DATE_ADD( NOW(), INTERVAL MONTHS.month - 0 MONTH), '%b' ) AS `Month`, COUNT(exams.id) AS `Count` FROM ( SELECT 1 AS MONTH UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 ) AS MONTHS LEFT JOIN exams ON MONTHS.month = MONTH(exams.created_at) AND exams.created_at >= DATE_ADD(NOW(), INTERVAL - 12 MONTH) GROUP BY MONTHS.month ORDER BY MONTHS.month";

		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function getClientExamsConductedCount($companyid = '')
	{
		$sql = "SELECT DATE_FORMAT( DATE_ADD( NOW(), INTERVAL MONTHS.month - 0 MONTH), '%b' ) AS `Month`, COUNT(exams.id) AS `Count` FROM ( SELECT 1 AS MONTH UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 ) AS MONTHS LEFT JOIN( SELECT exams.id, exams.created_at FROM exams INNER JOIN exam_clients ec ON exams.id = ec.exam_id AND ec.client_id = " . $companyid . " WHERE exams.created_at >= DATE_FORMAT(NOW(), '%Y-%m-01') - INTERVAL 12 MONTH) AS exams ON MONTHS.month = CAST( MONTH(exams.created_at) AS UNSIGNED ) GROUP BY MONTHS.month ORDER BY MONTHS.month";

		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function fetchExamsChartData($conArr = [], $days = '')
	{
		if (!empty($days) && $days >= 90) {
			$this->db->select('DATE_FORMAT(e.created_at, "%b %y") AS date, COUNT(DISTINCT(e.id)) as countVal');
			$this->db->order_by("MONTH(e.created_at)", 'ASC');
			$this->db->order_by("YEAR(e.created_at)", 'ASC');
		} else {
			$this->db->select('DATE_FORMAT(e.created_at, "%D %b %y") AS date, COUNT(DISTINCT(e.id)) as countVal');
			$this->db->order_by("e.created_at", 'DESC');
		}

		$this->db->from('exams e');
		if ($conArr['type'] == 'client') {
			$this->db->join('exam_clients ec', 'ec.exam_id = e.id');
			$this->db->where('ec.client_id', $conArr['company_id']);
		} else {
			if (isset($conArr['company_id'])) {
				$this->db->where('e.company_id', $conArr['company_id']);
			}
		}


		if ((isset($conArr['startDate']) && !empty($conArr['startDate'])) && (isset($conArr['endDate']) && !empty($conArr['endDate']))) {
			$this->db->where('e.created_at BETWEEN "' . $conArr['startDate'] . '" AND "' . $conArr['endDate'] . '"');
		}

		$this->db->group_by("date");

		$q = $this->db->get();
		return $q->result_array();
	}

	public function updateExamCandidatesPassword($examid = '', $password = '')
	{
		$sql = "UPDATE `candidates` SET `password`='" . md5($password) . "' WHERE id IN (SELECT candidate_id FROM `exam_candidates` WHERE exam_id = " . $examid . ")";
		$q = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getExamInfo($examid='')
	{
		return $this->db->get_where($this->primary_table, ['id' => $examid])->row_array();
	}

	public function updateExamCandidatesStatus($examid = '', $status = '')
	{
		if ($status == 1) {
			$sts = "active";
		} else {
			$sts = "blocked";
		}
		$sql = "UPDATE `candidates` SET `status`='$sts' WHERE id IN (SELECT candidate_id FROM `exam_candidates` WHERE exam_id = " . $examid . ")";
		$q = $this->db->query($sql);

		$esql = "UPDATE `exams` SET `candidate_status`='$status' WHERE id = $examid";
		$eq = $this->db->query($esql);
		
		return $this->db->affected_rows();
	}

	public function searchCandidatesExamsList($ids = [])
	{
		if (empty($ids)) { return []; }

		$this->db->where_in('user_id', $ids);
		$q = $this->db->get('candidate_exam_records');
		if ($q->num_rows() > 0) {
			$result = $q->result_array();
			$ids = array_column($result, 'exam_id');
			return $ids;
		}
		
		return [];
	}

	public function findExamsIn($ids = [])
	{
		if (empty($ids)) { return []; }

		$this->db->select('*');
		$this->db->select('(SELECT COUNT(*) AS clients FROM `exam_clients` WHERE exam_id = exams.id) AS clients');
		$this->db->select('(SELECT COUNT(*) AS candidates FROM `exam_candidates` WHERE exam_id = exams.id) AS candidates');
		$this->db->select('(SELECT COUNT(*) AS questions FROM `exam_questions` WHERE exam_id = exams.id) AS questions');
		$this->db->select('(SELECT company_name FROM `companies` WHERE id = exams.company_id) AS company_name');
		$this->db->where_in('id', $ids);
		$this->db->from($this->primary_table);
		$q = $this->db->get();
		return $q->result_array();
	}
	
	public function deleteCandidateExamInfo($examId='', $user_id = '')
	{
		$this->db->delete('candidate_exam_records', ['exam_id'=>$examId, 'user_id' => $user_id]);
		return $this->db->affected_rows();
	}
	
	public function deleteCandidateExamAnswers($data = '')
	{
		$this->db->delete('exam_records', ['user_id' => $data['user_id'], 'exam_id' => $data['exam_id']]);
		return $this->db->affected_rows();
	}

	public function searchCandidate($term='') {
		$sql = "SELECT c.id, c.empid, CONCAT_WS(' ', c.firstname, c.middlename, c.lastname) AS name, phone, email, c.status, c.company_id, co.company_name, cd.aadhaar_number  FROM candidates c INNER JOIN candidate_details cd ON c.id = cd.user_id LEFT JOIN companies co ON c.company_id = co.id WHERE firstname LIKE '%".$term."%' OR lastname LIKE '%".$term."%' OR middlename LIKE '%".$term."%' OR phone LIKE '%".$term."%' OR email LIKE '%".$term."%'";
		$q = $this->db->query($sql);
		
		return $q->result_array();
	}
	
}

/* End of file  */
/* Location: ./application/models/ */