<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	public $primary_table = 'users';

	public function __construct()
	{
		parent::__construct();
		
	}

	public function count($type='')
	{
		$this->db->where('type', $type);
		$this->db->from($this->primary_table);
		return $this->db->count_all_results();
	}

	public function insert($data='')
	{
		$this->db->insert($this->primary_table , $data);
		return $this->db->insert_id();
	}

	public function create($data='')
	{
		$ins_data = [
			'type' => $data['type'],
			'firstname' => $data['firstname'],
			'middlename' => $data['middlename']??'',
			'lastname' => $data['lastname']??'',
			'phone' => $data['phone'],
			'email' => strtolower($data['email']),
			'password' => md5($data['password']),
			'status' => $data['status'],
			'profile_img' => $data['profile_img']??'',
			'gender' => $data['gender']??'other',
		];
		$this->db->insert($this->primary_table , $ins_data);
		return $this->db->insert_id();
	}

	public function getUser($value='')
	{
		$this->db->from('users u');
		$this->db->join('candidate_details cd', 'cd.user_id = u.id', 'left');
		if ($value) {
			$this->db->where('u.id', $value);
		}

		$q = $this->db->get();
		return $q->row_array();
	}

	public function get($value='')
	{
		
		if ($value) { $this->db->where('id', $value); }
		$this->db->from($this->primary_table);
		$q = $this->db->get();
		return $q->row_array();
	}

	public function getUserOfType($types='')
	{
		$this->db->select('id, firstname, middlename, lastname, gender, phone, type, email, profile_img, status');
	    $this->db->where_in('type', $types);
	    return $this->db->get($this->primary_table)->result_array();
	}

	public function get_data($limit, $offset, $order="desc", $type='')
    {
    	$this->db->select('id, firstname, middlename, lastname, gender, phone, type, email, profile_img, status');
    	$this->db->order_by('create_datetime', $order);
        $this->db->limit($limit, $offset);
        $this->db->from($this->primary_table);
        $this->db->where('type', $type);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function removeManager($value='')
    {
    	$this->db->delete('com_usr_link', ['user_id'=>$value]);
    	$this->db->delete('business_units', ['id'=>$value]);
    	return $this->db->affected_rows();
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
		$this->db->update($this->primary_table , $ins_data, ['id'=>$id]);
		return $this->db->affected_rows();
	}

	public function updateUser($data='', $id='')
	{
		$ins_data = $data;
		if (!empty($data['password'])) { $ins_data['password'] = md5($data['password']); }
		$this->db->update($this->primary_table , $ins_data, ['id'=>$id]);
		return $this->db->affected_rows();
	}

	public function updatePassword($data='', $id='')
	{
		$ins_data['password'] = md5($data['password']);
		$this->db->update($this->primary_table , $ins_data, ['id'=>$id]);
		return $this->db->affected_rows();
	}

	public function getByEmail($email='', $type='') {
		$this->db->select("*");
		if ($type=='admin') {
			$this->db->from('users');
		} else if ($type=='business unit') {
			$this->db->from('business_units');
		} else if ($type=='client') {
			$this->db->from('clients');
		} else {
			$this->db->from('candidates');
		}
		$this->db->where('email', $email);
		$q = $this->db->get();
		return $q->row_array();
	}

	public function getByToken($token='', $type='') {
		$this->db->select("*");

		if ($type=='admin') {
			$this->db->from('users');
		} else if ($type=='business unit') {
			$this->db->from('business_units');
		} else if ($type=='client') {
			$this->db->from('clients');
		} else {
			$this->db->from('candidates');
		}

		$this->db->where('authtoken', $token);

		$q = $this->db->get();
		return $q->row_array();
	}

	public function getManagers($value=''){
		
		$this->db->from('business_units');
		if($value) {
			$this->db->where(['id'=>$value]);
			$q = $this->db->get();
			return $q->row_array();
		} else {
			$q = $this->db->get();
			return $q->result_array();
		}
	}

	public function getManagersList($limit, $offset, $order="desc")
    {
    	$this->db->select('id, firstname, middlename, lastname, gender, phone, email, profile_img, status');
    	$this->db->order_by('created_at', $order);
        $this->db->limit($limit, $offset);
        $this->db->from('business_units');
        $query = $this->db->get();
        return $query->result_array();
    }

	public function getProfile($id='', $type=''){
		

		if ($type=='admin') {
			$this->db->select('id AS userid, firstname, middlename, lastname, gender, phone, email, profile_img, status, created_at');
			$this->db->from('users');
			if($id){ $this->db->where('id', $id); }
		} else if ($type=='business unit') {
			$this->db->select('id AS userid, firstname, middlename, lastname, gender, phone, email, profile_img, status, created_at');
			$this->db->from('business_units');
			if($id){ $this->db->where('id', $id); }
		} else if ($type=='client') {
			$this->db->select('id AS userid, firstname, middlename, lastname, gender, phone, email, profile_img, status, created_at');
			$this->db->from('clients');
			if($id){ $this->db->where('id', $id); }
		} else {
			$this->db->select('c.id AS userid, c.firstname, c.middlename, c.lastname, c.gender, c.phone, c.email, c.profile_img, c.status, c.created_at');
			$this->db->select('cd.*');
			$this->db->from('candidates c');
			$this->db->join('candidate_details cd', 'cd.user_id = c.id');
			if($id){ $this->db->where('cd.id', $id); }
		}
		
        $query = $this->db->get();

		return $query->row_array();
	}
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */