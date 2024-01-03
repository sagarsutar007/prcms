<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function getSiteSetting($value='')
	{
		$this->db->limit(1);
		$this->db->from('app_preferences');
		$q = $this->db->get();
		return $q->row_array();
	}

    public function insertLog($data='') {
        $this->db->insert('notification_logs_tbl', $data);
        return $this->db->insert_id();
    }

	public function getLogs($type='') {
		$this->db->limit(2000);
		$this->db->order_by('created_on', 'DESC');
		$q = $this->db->get_where('notification_logs_tbl', ['type' => $type]);
		return $q->result_array();
	}

	public function get($id='') {
		$q = $this->db->get_where('notification_logs_tbl', ['id' => $id]);
		return $q->row_array();
	}

	public function getUserSMS($user_id=''){
		$this->db->limit(500);
		$this->db->where('user_id', $user_id);
		$this->db->where('type', 'sms');
		$this->db->order_by('created_on', 'DESC');
		$this->db->from('notification_logs_tbl');
		$q = $this->db->get();
		return $q->result_array();
	}

	public function getUserEmail($user_id=''){
		$this->db->limit(500);
		$this->db->where('user_id', $user_id);
		$this->db->where('type', 'email');
		$this->db->order_by('created_on', 'DESC');
		$this->db->from('notification_logs_tbl');
		$q = $this->db->get();
		return $q->result_array();
	}
}
