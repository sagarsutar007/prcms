<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients_model extends CI_Model {

    public $primary_table = 'clients';

	public function __construct()
	{
		parent::__construct();
	}

    public function count()
	{
		$this->db->from($this->primary_table);
		return $this->db->count_all_results();
	}

    public function create($data='')
	{
		$ins_data = [
			'firstname' => $data['firstname'],
			'middlename' => $data['middlename']??'',
			'lastname' => $data['lastname']??'',
			'phone' => $data['phone'],
			'email' => strtolower($data['email']),
			'password' => md5($data['password']),
			'status' => $data['status']??'active',
			'profile_img' => $data['profile_img']??'',
			'gender' => $data['gender']??'other',
			'company_id' => $data['company_id'],
		];
		$this->db->insert($this->primary_table , $ins_data);
		return $this->db->insert_id();
	}

    public function getClients($company_id='')
    {
        $this->db->select('c.*');
        $this->db->from('companies c');
        $this->db->join('com_usr_link cul', 'c.id = cul.company_id');
        $this->db->join('clients cl', 'cl.id = cul.user_id');
        $this->db->where('cul.type', 'client');
        if (!empty($company_id)) { $this->db->where('cl.company_id', $company_id); }
        $query = $this->db->get();
        return $query->result_array();
    }

	public function get($limit, $offset, $order="desc", $company_id='', $status='')
    {
    	$this->db->select('c.id, c.company_name, c.company_logo, c.company_about, cl.firstname, cl.middlename, cl.lastname, cl.phone, cl.email, cl.profile_img, cl.status, cl.gender');
        $this->db->select('(SELECT company_name FROM `companies` WHERE id = cl.company_id) AS business_unit');
    	$this->db->order_by('c.created_at', $order);
        $this->db->limit($limit, $offset);
        $this->db->from('companies c');
        $this->db->join('com_usr_link cul', 'c.id = cul.company_id');
        $this->db->join('clients cl', 'cl.id = cul.user_id');
        $this->db->where('cul.type', 'client');
        if (!empty($status)) { $this->db->where('cl.status', $status); }
        if (!empty($company_id) && !empty($company_id[0])) { $this->db->where_in('cl.company_id', $company_id); }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getClientInfo($value='')
    {
        $this->db->select('c.id, c.company_name, c.company_logo, c.company_about, u.id as user_id, u.firstname, u.middlename, u.lastname, u.phone, u.email, u.profile_img, u.status, u.gender, u.company_id');
        $this->db->from('companies c');
        $this->db->join('com_usr_link cul', 'c.id = cul.company_id');
        $this->db->join('clients u', 'u.id = cul.user_id');
        $this->db->where('cul.type', 'client');
        $this->db->where('c.id', $value);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getClientInfoByUserId($value='')
    {
        $this->db->select('c.id, c.company_name, c.company_logo, c.company_about, u.id as user_id, u.firstname, u.middlename, u.lastname, u.phone, u.email, u.profile_img, u.status, u.gender');
        $this->db->from('companies c');
        $this->db->join('com_usr_link cul', 'c.id = cul.company_id');
        $this->db->join('clients u', 'u.id = cul.user_id');
        $this->db->where('cul.type', 'client');
        $this->db->where('u.id', $value);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getClientExams($value='')
    {
        $this->db->select('e.id, e.name, e.duration, e.lang, e.exam_datetime');
        $this->db->select('(SELECT company_name FROM companies WHERE companies.id = e.company_id) AS company_name');
        $this->db->select('(SELECT count(*) FROM exam_questions WHERE exam_questions.exam_id = e.id) AS total_question');
        $this->db->select('(SELECT count(*) FROM exam_candidates WHERE exam_candidates.exam_id = e.id) AS total_candidates');
        $this->db->from('exams e');
        $this->db->join('exam_clients ecl', 'ecl.exam_id = e.id');
        $this->db->where('ecl.client_id', $value);
        $q = $this->db->get();
        return $q->result_array();
    }

    public function getCompanyByUserId($user_id='')
    {
        $this->db->select('c.*');
        $this->db->from('companies c');
        $this->db->join('com_usr_link cul', 'cul.company_id = c.id');
        $this->db->where('cul.user_id', $user_id);
        $this->db->where('cul.type', 'client');
        $q = $this->db->get();
        return $q->row_array();
    }

    public function get_data($limit, $offset, $order="desc", $company_id='')
    {
        $currentDatetime = date('Y-m-d H:i:s');
        $this->db->select('e.*');
        $this->db->select('(SELECT COUNT(*) AS candidates FROM `exam_candidates` WHERE exam_id = e.id) AS total_candidates');
        $this->db->from('exams e');
        $this->db->join('exam_clients ec', 'ec.exam_id = e.id');
        $this->db->where('ec.client_id', $company_id);
        $this->db->where('e.exam_datetime <', $currentDatetime);
        $this->db->order_by('e.created_at', $order);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCompanyData($company_id='', $type='')
    {
        $this->db->select('c.*');
        $this->db->from('companies c');
        $this->db->where('c.id', $company_id);
        if ($type) {
            $this->db->join('com_usr_link cul', 'cul.company_id = c.id');
            $this->db->where('cul.type', $type);
        }
        $query = $this->db->get();
        return $query->row_array();
    }


    public function searchCompany($value='')
    {
        $this->db->select('c.*');
        $this->db->from('companies c');
        $this->db->where('company_name', $value);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update($data='', $id='')
	{
		$ins_data = [
			'firstname' => $data['firstname'],
			'middlename' => $data['middlename']??'',
			'lastname' => $data['lastname']??'',
			'phone' => $data['phone'],
			'email' => $data['email']
		];
		if (!empty($data['status'])) { $ins_data['status'] = $data['status']; }
		if (!empty($data['type'])) { $ins_data['type'] = $data['type']; }
		if (!empty($data['gender'])) { $ins_data['gender'] = $data['gender']; }
		if (!empty($data['password'])) { $ins_data['password'] = md5($data['password']); }
		if (!empty($data['profile_img'])) { $ins_data['profile_img'] = $data['profile_img']; }
		if (!empty($data['company_id'])) { $ins_data['company_id'] = $data['company_id']; }
		$this->db->update($this->primary_table , $ins_data, ['id'=>$id]);
		return $this->db->affected_rows();
	}

    public function updatePassword($data='', $id='')
	{
        $ins_data = [];
		if (!empty($data['password'])) { $ins_data['password'] = md5($data['password']); }
		$this->db->update($this->primary_table , $ins_data, ['id'=>$id]);
		return $this->db->affected_rows();
	}

    public function removeManager($value='')
    {
    	$this->db->delete('com_usr_link', ['user_id'=>$value]);
    	$this->db->delete($this->primary_table, ['id'=>$value]);
    	return $this->db->affected_rows();
    }

    public function getClient($value='')
	{
		$this->db->select('c.id, c.firstname, c.middlename, c.lastname, c.gender, c.phone, c.email, c.profile_img, c.status, c.authtoken');
		$this->db->from('clients c');
		if ($value) {
			$this->db->where('c.id', $value);
			$q = $this->db->get();
			return $q->row_array();
		} else {
			$q = $this->db->get();
			return $q->result_array();
		}
		
	}

    public function genericUpdate($data='', $id='')
    {
        $this->db->update($this->primary_table , $data, ['id'=>$id]);
        return $this->db->affected_rows();
    }
}

/* End of file  */
/* Location: ./application/models/ */