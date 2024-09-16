<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidates_model extends CI_Model {
	
	public $primary_table = 'candidates';

	public function __construct()
	{
		parent::__construct();
	}

	public function countActiveUsers($date='')
	{
		$this->db->group_by('user_id');
		$this->db->from('logs_tbl');
		$this->db->where("type","candidate");
		$this->db->like('datetime', $date);
		return $this->db->count_all_results();
	}

	public function countUserRegistrations($date='')
	{
		$this->db->from('candidates');
		$this->db->like('created_at', $date);
		return $this->db->count_all_results();
	}

	public function count($company_id='', $status='', $search='', $columnName=null, $columnSortOrder=null)
	{
		if (!empty($company_id)){ 

			if (is_array($company_id) && count($company_id) > 0 && !empty($company_id[0])) {
				$this->db->where_in('c.company_id', $company_id); 
			}

			if(!is_array($company_id)){
				$this->db->where('c.company_id', $company_id); 
			}
		}

		$pattern = '/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[01])-\d{4}$/';
        $phone = '/^\d{1,10}$/';
        $aadhaar = '/^\d{1,12}$/';

		if ($search) {
        	$search = strip_tags(trim($search));
            $this->db->group_start();
            $this->db->like('c.firstname', $search);
            $this->db->or_like('c.middlename', $search);
            $this->db->or_like('c.lastname', $search);
            $this->db->or_like('cd.father_name', $search);
            $this->db->or_where('c.email', $search);
            $this->db->or_where('c.gender', $search);
            if (preg_match($phone, $search)) { $this->db->or_where('c.phone', $search); }
            if (preg_match($aadhaar, $search)) { $this->db->or_where('cd.aadhaar_number', $search); }
            if (preg_match($pattern, $search)) { $this->db->or_where('cd.dob', date('Y-m-d', strtotime($search))); }
            
            $this->db->group_end();
        }

		if (!empty($status)) {
			$this->db->where('c.status', $status); 
		}
		$this->db->from('candidates c');
        $this->db->join('candidate_details cd', 'cd.user_id = c.id', 'left');
		return $this->db->count_all_results();
	}

	public function insert($data='')
	{
		$this->db->insert($this->primary_table , $data);
		return $this->db->insert_id();
	}

	public function updateCandidateInfo($data='', $user_id='')
	{
		$this->db->update('candidate_details', $data, ['user_id'=>$user_id]);
		return $this->db->affected_rows();
	}

	public function insertCandidateInfo($data='')
	{
		$this->db->insert('candidate_details', $data);
		return $this->db->insert_id();
	}

	public function updateFilename ($userid='', $newFilename=''){
		$this->db->update('candidates', ['profile_img' => $newFilename], ['id'=>$userid]);
		return $this->db->affected_rows();
	}

	public function get($value='')
	{
		$this->db->select('c.*');
		$this->db->from('candidates c');
		if ($value) {
			$this->db->where('c.id', $value);
			$q = $this->db->get();
			return $q->row_array();
		} else {
			$q = $this->db->get();
			return $q->result_array();
		}
		
	}

	public function getUser($value='')
	{
		$this->db->from('candidates c');
		$this->db->join('candidate_details cd', 'cd.user_id = c.id', 'left');
		if ($value) {
			$this->db->where('c.id', $value);
		}

		$q = $this->db->get();
		return $q->row_array();
	}

	public function getUserByAadhaar($value='')
	{
		$this->db->from('candidates c');
		$this->db->join('candidate_details cd', 'cd.user_id = c.id', 'left');
		if ($value) {
			$this->db->where('cd.aadhaar_number', $value);
		}

		$q = $this->db->get();
		return $q->row_array();
	}

	public function candidateExists($value='')
	{
		$this->db->from('candidates c');
		if ($value) {
			$this->db->where('c.phone', $value);
		}

		$q = $this->db->get();
		return $q->row_array();
	}

	public function getData($start, $length, $search, $filter=[], $columnName=null, $columnSortOrder=null) {

		$this->db->select('c.id as user_id, c.firstname, c.middlename, c.lastname, c.phone, c.email, c.gender, cd.dob, cd.father_name, cd.aadhaar_number');
        $this->db->from('candidates c');
        $this->db->join('candidate_details cd', 'cd.user_id = c.id', 'left');

        if(count($filter)){
        	if (isset($filter['company_id'])) {
        		$this->db->where('c.company_id', $filter['company_id']);
        	}
        	if (isset($filter['status'])) {
        		$this->db->where('c.status', $filter['status']);
        	}
        }
        $pattern = '/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[01])-\d{4}$/';
        $phone = '/^\d{1,10}$/';
        $aadhaar = '/^\d{1,12}$/';
        if ($search) {
        	$search = strip_tags(trim($search));
            $this->db->group_start();
            $this->db->like('c.firstname', $search);
            $this->db->or_like('c.middlename', $search);
            $this->db->or_like('c.lastname', $search);
            $this->db->or_like('cd.father_name', $search);
            $this->db->or_where('c.email', $search);
            $this->db->or_where('c.gender', $search);
            if (preg_match($phone, $search)) { $this->db->or_where('c.phone', $search); }
            if (preg_match($aadhaar, $search)) { $this->db->or_where('cd.aadhaar_number', $search); }
            if (preg_match($pattern, $search)) { $this->db->or_where('cd.dob', date('Y-m-d', strtotime($search))); }
            
            $this->db->group_end();
        }
		if ($length != "-1" && !empty($length)) {
			$this->db->limit($length, $start);
		}
		if (empty($columnName) || empty($columnSortOrder)) {
			$this->db->order_by('c.id', 'desc');
		} else {
			$this->db->order_by($columnName, $columnSortOrder);
		}
        // $q = $this->db->get_compiled_select();
        // return $q;
        $q = $this->db->get();
        return $q->result_array();
    }

	public function getUserDetails($value='')
	{
		$q = $this->db->get_where('candidate_details', ['user_id'=>$value]);
		return $q->row_array();
	}

	public function remove($value='')
	{
		$this->db->delete('candidate_details', ['user_id' => $value]);
		$this->db->delete('candidates', ['id' => $value]);
		return $this->db->affected_rows();
	}

	public function getCompany($company_id='')
	{
		$q = $this->db->get_where('companies', ['id' => $company_id]);
		return $q->row_array();
	}

	public function get_data($limit, $offset, $order="desc", $company_id='', $status='')
    {
    	$this->db->select('c.id, c.firstname, c.middlename, c.lastname, c.gender, c.phone, c.email, c.profile_img, c.status, cd.father_name, cd.aadhaar_number, cd.dob');
    	$this->db->order_by('c.created_at', $order);
        $this->db->limit($limit, $offset);
        $this->db->from('candidates c');
        $this->db->join('candidate_details cd', 'cd.user_id = c.id', 'left');
        if (!empty($status)) { $this->db->where('c.status', $status); }
        if (!empty($company_id)) { $this->db->where_in('c.company_id', $company_id); }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function filter_data($data='', $company_id='')
    {
    	$this->db->select('c.id, c.firstname, c.middlename, c.lastname, c.gender, c.phone, c.email, c.profile_img, c.status, cd.father_name, cd.dob, cd.aadhaar_number');
    	$this->db->order_by('c.created_at', 'DESC');
        $this->db->from('candidates c');
        $this->db->join('candidate_details cd', 'cd.user_id = c.id');

        if (!empty($data['search_name'])) { 
        	$this->db->like('c.firstname', $data['search_name']); 
        	$this->db->or_like('c.middlename', $data['search_name']); 
        	$this->db->or_like('c.lastname', $data['search_name']); 
        }

        if (!empty($data['search_phone'])) { $this->db->where('c.phone', $data['search_phone']); }

        if (!empty($data['search_email'])) { $this->db->where('c.email', $data['search_email']); }

        if (!empty($data['search_gender'])) { $this->db->where('c.gender', $data['search_gender']); }

        if (!empty($data['dob'])) { $this->db->where('cd.dob', $data['dob']); }

        if (!empty($data['aadhaar_number'])) { $this->db->where('cd.aadhaar_number', $data['aadhaar_number']); }

        if (!empty($data['father_name'])) { $this->db->like('cd.father_name', $data['father_name']); }

        if (!empty($data['search_state'])) { 
        	$this->db->where('cd.pa_state', $data['search_state']); 
        	$this->db->or_where('cd.ca_state', $data['search_state']); 
        }

        
        if (!empty($data['from_date']) && !empty($data['to_date'])) { 
        	$this->db->where('created_at BETWEEN "'. date('Y-m-d', strtotime($data['from_date'])). '" and "'. date('Y-m-d', strtotime($data['to_date'])).'"'); 
        }

        if (!empty($company_id)) { $this->db->where_in('c.company_id', $company_id); }

        $query = $this->db->get();
        return $query->result_array();
    }

	public function updateCandidate($data=[], $user_id='') {
		if (isset($data['password']) && !empty($data['password'])) { $data['password'] = md5($data['password']); }
		$this->db->update($this->primary_table , $data, ['id'=>$user_id]);
		return $this->db->affected_rows();
	}

	public function searchCandidate($term='', $comp_id=''){
		$sql = "SELECT id as user_id, firstname, middlename, lastname, profile_img, phone, email FROM candidates WHERE firstname LIKE '%".$term."%' OR lastname LIKE '%".$term."%' OR middlename LIKE '%".$term."%' OR phone = '".$term."' OR email = '".$term."'";
		if ($comp_id) {
			$sql .= " AND company_id=" . $comp_id;
		}
		$q = $this->db->query($sql);
		return $q->num_rows() > 0 ? $q->result_array(): [];
	}

	public function getByPhone($term='', $comp_id=''){
		$sql = "SELECT id, firstname, middlename, lastname, profile_img, phone, email, company_id FROM candidates WHERE phone = '".$term."'";
		if ($comp_id) {
			$sql .= " AND company_id=" . $comp_id;
		}
		$q = $this->db->query($sql);
		return $q->row_array();
	}

	public function getActiveUsersCount()  {
		$sql = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL MONTHS.month - 1 MONTH), '%b') AS `Month`, COUNT(DISTINCT logs.user_id) AS `Count` FROM ( SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 ) AS MONTHS LEFT JOIN logs_tbl AS logs ON MONTHS.month = MONTH(logs.datetime) AND logs.datetime >= DATE_ADD(NOW(), INTERVAL - 12 MONTH) GROUP BY MONTHS.month ORDER BY MONTHS.month;";
		
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function fetchActiveUsersData($conArr=[], $days='') {
		if (empty($days) || $days >= 365 ) {
			$this->db->select('DATE_FORMAT(lt.datetime, "%b %y") AS date, COUNT(DISTINCT(lt.user_id)) as countVal');
		} else {
			$this->db->select('DATE_FORMAT(lt.datetime, "%D %b %y") AS date, COUNT(DISTINCT(lt.user_id)) as countVal');
		}
		
		$this->db->from('logs_tbl lt');
		$this->db->join('candidates c', 'lt.user_id = c.id');

		if (isset($conArr['company_id'])) {
			$this->db->where('c.company_id', $conArr['company_id']);
		}

		if  ( (isset($conArr['startDate']) && !empty($conArr['startDate'])) && (isset($conArr['endDate']) && !empty($conArr['endDate'])) ) {
			$this->db->where('lt.datetime BETWEEN "' . $conArr['startDate'] . '" AND "' . $conArr['endDate'] . '"');
		}

		$this->db->group_by("date");
		$this->db->order_by("MONTH(lt.datetime)", 'ASC');
		$this->db->order_by("YEAR(lt.datetime)", 'ASC');
		$q = $this->db->get();
		return $q->result_array();
	}


	public function getCandidateRegistrationsCount()  {
		$sql = "SELECT DATE_FORMAT( DATE_ADD( NOW(), INTERVAL MONTHS.month - 0 MONTH), '%b' ) AS `Month`, COUNT(candidate.id) AS `Count` FROM ( SELECT 1 AS MONTH UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 ) AS MONTHS LEFT JOIN candidates AS candidate ON MONTHS.month = MONTH(candidate.created_at) AND candidate.created_at >= DATE_ADD(NOW(), INTERVAL - 12 MONTH) GROUP BY MONTHS.month ORDER BY MONTHS.month";
		
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function fetchCandidateRegsData($conArr=[], $days='') {
		if (!empty($days) && $days >= 90 ) {
			$this->db->select('DATE_FORMAT(c.created_at, "%b %y") AS date, COUNT(DISTINCT(c.id)) as countVal');
			$this->db->order_by("MONTH(c.created_at)", 'ASC');
			$this->db->order_by("YEAR(c.created_at)", 'ASC');
		} else {
			$this->db->select('DATE_FORMAT(c.created_at, "%D %b %y") AS date, COUNT(DISTINCT(c.id)) as countVal');
			$this->db->order_by("c.created_at", 'DESC');
		}
		
		$this->db->from('candidates c');

		if (isset($conArr['company_id'])) {
			$this->db->where('c.company_id', $conArr['company_id']);
		}

		if  ( (isset($conArr['startDate']) && !empty($conArr['startDate'])) && (isset($conArr['endDate']) && !empty($conArr['endDate'])) ) {
			$this->db->where('c.created_at BETWEEN "' . $conArr['startDate'] . '" AND "' . $conArr['endDate'] . '"');
		}

		$this->db->group_by("date");
		
		$q = $this->db->get();
		return $q->result_array();
	}
}

/* End of file  */
/* Location: ./application/models/ */