<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_units_model extends CI_Model {

	public $primary_table = "companies";
	public $users_table = "users";
	public $manager_table = "business_units";

	public function __construct()
	{
		parent::__construct();
	}

	public function count()
	{
		return $this->db->count_all_results($this->primary_table);
	}

	public function create($data='')
	{
		$this->db->insert($this->primary_table, $data);
		return $this->db->insert_id();
	}

	public function get_data($limit, $offset, $order="desc")
    {
    	$this->db->select('DISTINCT(`c`.id) AS id, c.company_name, c.company_logo, c.company_about');
    	$this->db->select('(SELECT COUNT(*) AS total FROM `com_usr_link` WHERE company_id = c.id) AS total');
    	$this->db->order_by('c.created_at', $order);
        $this->db->limit($limit, $offset);
        $this->db->from('companies c');
        $this->db->join('com_usr_link cul', 'cul.company_id = c.id', 'left');
        $this->db->join('business_units bu', 'bu.id = cul.user_id');
        $this->db->where('cul.type', 'business unit');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get($value='')
    {
    	if ($value) {
    		$q = $this->db->get_where($this->primary_table, ['id'=>$value]);
	    	return $q->row_array();
    	} else {
    		$this->db->select('DISTINCT(c.id) AS id, c.company_name, c.company_logo, c.company_about, c.company_address');
			$this->db->from('companies c');
    		$this->db->join('com_usr_link cul', 'c.id = cul.company_id');
    		$this->db->join('business_units bu', 'bu.id = cul.user_id');
    		$this->db->where('cul.type', 'business unit');
    		$q = $this->db->get();
    		return $q->result_array();
    	}
    	
    }

    public function linkUsersToCompany($company_id='', $user_ids=[], $type='')
    {
    	if (empty($company_id) || empty($user_ids)) {
	        return false;
	    }

	    $data = array();
	    foreach ($user_ids as $user_id) {
	        $data[] = array(
	            'company_id' => $company_id,
	            'user_id' => $user_id,
				'type' => ($type=='')?'business unit':$type
	        );
	    }

	    $this->db->insert_batch('com_usr_link', $data);

	    return $this->db->affected_rows();
    }

    public function getCompanyUsers($company_id='')
    {
    	$this->db->select('bu.id, bu.firstname, bu.middlename, bu.lastname, bu.gender, bu.phone, bu.email, bu.profile_img, bu.status');
	    
	    $this->db->from('com_usr_link cul');
	    $this->db->join('business_units bu', 'cul.user_id = bu.id');
	    $this->db->where('cul.company_id', $company_id);
	    $this->db->where('cul.type', 'business unit');
	    return $this->db->get()->result_array();
    }

    public function updateCompany($data='', $id='')
    {
    	$this->db->update($this->primary_table, $data, $id);
    	return $this->db->affected_rows();
    }

    public function belongsToCompany($id='', $user_id='')
    {
    	$q = $this->db->get_where('com_usr_link', ['company_id' => $id, 'user_id' => $user_id]);
    	return $q->row_array();
    }

    public function removeBusiness($value='')
    {
    	$this->db->delete('com_usr_link', ['company_id'=>$value]);
    	$this->db->delete($this->primary_table, ['id'=>$value]);
    	return $this->db->affected_rows();
    }

    public function deleteMultiple($values = [])
	{
	    if (empty($values)) { return 0; }

	    $this->db->where_in('company_id', $values);
	    $this->db->delete('com_usr_link');

	    $this->db->where_in('id', $values);
	    $this->db->delete($this->primary_table);

	    return $this->db->affected_rows();
	}

	public function getUserCompanies($user_id='', $type='')
	{
		$this->db->select('distinct(c.id) AS id, c.company_name, c.company_logo');
		$this->db->from('companies c');
		$this->db->join('com_usr_link cul', 'c.id = cul.company_id');

		if ($type=='admin') {
			$this->db->select('bu.phone, bu.email, bu.firstname, bu.lastname');
			$this->db->join('business_units bu', 'bu.id = cul.user_id');
			$this->db->where('cul.type', 'business unit');
		} else if ($type=='client') {
			$this->db->select('cl.phone, cl.email, cl.firstname, cl.lastname');
			$this->db->join('clients cl', 'cl.id = cul.user_id');
			$this->db->where('cl.id', $user_id);
			$this->db->where('cul.type', $type);
		} else if ($type=='business unit') {
			$this->db->select('bu.phone, bu.email, bu.firstname, bu.lastname');
			$this->db->join('business_units bu', 'bu.id = cul.user_id');
			$this->db->where('bu.id', $user_id);
			$this->db->where('cul.type', $type);
		} else {
			$this->db->select('bu.phone, bu.email, bu.firstname, bu.lastname');
			$this->db->join('business_units bu', 'bu.id = cul.user_id');
			$this->db->join('candidates cd', 'cd.company_id = c.id');
			$this->db->where('cd.id', $user_id);
			$this->db->limit(1);
		}

		$q = $this->db->get();
		return $q->result_array();
	}

	public function getAdminCompanies()
	{
		$this->db->select('distinct(c.id) AS id, c.company_name, c.company_logo');
		$this->db->from('companies c');
		$this->db->join('com_usr_link cul', 'c.id = cul.company_id');
		$this->db->where('cul.type', 'business unit');
		$q = $this->db->get();
		return $q->result_array();
	}

	public function insertManager($data='')
	{
		$ins_data = [
			'firstname' => $data['firstname'],
			'middlename' => $data['middlename']??'',
			'lastname' => $data['lastname']??'',
			'phone' => $data['phone'],
			'email' => strtolower($data['email']),
			'password' => md5($data['password']),
			'status' => $data['status'],
			'profile_img' => $data['profile_img']??'',
			'gender' => $data['gender']??'other'
		];
		$this->db->insert($this->manager_table , $ins_data);
		return $this->db->insert_id();
	}

	public function getManager($user_id = '') {
		$q = $this->db->get_where($this->manager_table , ['id'=>$user_id]);
		return $q->row_array();
	}

	public function updateManager($data=[], $user_id='') {
		if(isset($data['password']) && !empty($data['password'])) {
			$data['password'] = md5($data['password']);
		}
		$this->db->update($this->manager_table , $data, ['id'=>$user_id]);
		return $this->db->affected_rows();
	}

	public function getBusinesses($userid=''){
		if ($userid) {
			$this->db->where('cul.user_id', $userid);
		}
		$this->db->select('c.*');
		$this->db->from('com_usr_link cul');
		$this->db->join('business_units bu', 'bu.id = cul.user_id');
		$this->db->join('companies c', 'c.id = cul.company_id');
		$this->db->where('cul.type', 'business unit');
		$q = $this->db->get();
		return $q->result_array();
	}

	public function removeUsersFromCompany($id=''){
		$this->db->delete('com_usr_link', ['company_id'=>$id]);
		return $this->db->affected_rows();
	}
}

/* End of file Business_units_model.php */
/* Location: ./application/models/Business_units_model.php */