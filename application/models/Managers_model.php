<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managers_model extends CI_Model {

	public $primary_table = 'business_units';

	public function __construct()
	{
		parent::__construct();
	}

	public function count()
	{
		$this->db->from($this->primary_table);
		return $this->db->count_all_results();
	}

	public function insert($data='')
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
			'gender' => $data['gender']??'other'
		];
		$this->db->insert($this->primary_table , $ins_data);
		return $this->db->insert_id();
	}

    public function update($data='', $id='')
	{
		$ins_data = [
			'firstname' => $data['firstname'],
			'middlename' => $data['middlename']??'',
			'lastname' => $data['lastname']??'',
			'phone' => $data['phone'],
			'email' => $data['email'],
			'status' => $data['status']
		];
		if (!empty($data['gender'])) { $ins_data['gender'] = $data['gender']; }
		if (!empty($data['password'])) { $ins_data['password'] = md5($data['password']); }
		if (!empty($data['profile_img'])) { $ins_data['profile_img'] = $data['profile_img']; }
		$this->db->update($this->primary_table , $ins_data, ['id'=>$id]);
		return $this->db->affected_rows();
	}

	public function get($value=''){
		$this->db->from($this->primary_table);
		if($value) {
			$this->db->where(['id'=>$value]);
			$q = $this->db->get();
			return $q->row_array();
		} else {
			$q = $this->db->get();
			return $q->result_array();
		}
	}

	public function get_data($limit, $offset, $order="desc")
    {
    	$this->db->select('id, firstname, middlename, lastname, gender, phone, email, profile_img, status');
    	$this->db->order_by('created_at', $order);
        $this->db->limit($limit, $offset);
        $this->db->from('business_units');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete($value='')
    {
    	$this->db->delete('com_usr_link', ['user_id'=>$value]);
    	$this->db->delete('business_units', ['id'=>$value]);
    	return $this->db->affected_rows();
    }

    public function genericUpdate($data='', $id='')
	{
		$this->db->update($this->primary_table , $data, ['id'=>$id]);
		return $this->db->affected_rows();
	}
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */