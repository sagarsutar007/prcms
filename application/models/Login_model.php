<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function authenticate($data='', $type='')
	{
		$this->db->select('id, firstname, middlename, lastname, gender, phone, email, profile_img, status');
		if ($type=='admin') {
			$this->db->from('users');
		} else if ($type=='business unit') {
			$this->db->from('business_units');
		} else if ($type=='client') {
			$this->db->from('clients');
		} else {
			$this->db->select('company_id');
			$this->db->from('candidates');
		}
		$this->db->where(['email'=>strtolower($data['email']), 'password'=>md5($data['password'])]);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get($value='')
	{
		$this->db->select('id, firstname, middlename, lastname, gender, phone, type, email, profile_img, status');
		$query = $this->db->get_where('users', ['id'=>$value]);
		return $query->row_array();
	}

	public function getApplicationInfo($value='')
	{
		$this->db->from('app_preferences');
		$this->db->limit(1);
		$q = $this->db->get();
		return $q->row_array();
	}

	public function captureLog($data=[])
	{
		$this->db->insert('logs_tbl', $data);
		return $this->db->insert_id();
	}
}

/* End of file  */
/* Location: ./application/models/ */