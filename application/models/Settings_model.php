<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

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

	public function insert($value='')
	{
		$this->db->insert('app_preferences', $value);
		return $this->db->insert_id();
	}

	public function update($value='', $id='')
	{
		$value['updated_at'] = date('Y-m-d H:i:s');
		$this->db->update('app_preferences', $value, ['id'=>$id]);
		return $this->db->insert_id();
	}
}

/* End of file  */
/* Location: ./application/models/ */