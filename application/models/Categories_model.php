<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_model extends CI_Model {

	public $primary_table = "categories";
	public $question_table = "questions";

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
    	$this->db->select('*');
    	$this->db->select('(SELECT COUNT(*) AS total FROM `questions` WHERE category_id = categories.id) AS total');
    	$this->db->order_by('created_at', $order);
        $this->db->limit($limit, $offset);
        $this->db->from($this->primary_table);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get($value='')
    {
    	if($value) {
    		$q = $this->db->get_where($this->primary_table, ['id'=>$value]);
    		return $q->row_array();
    	} else {
    		$q = $this->db->get($this->primary_table);
    		return $q->result_array();
    	}
    }

	public function getExcept($value='')
    {
    	if($value) { $this->db->where('id !=', $value); } 
		$q = $this->db->get($this->primary_table);
		return $q->result_array();
    }

    public function search($value='')
    {
    	$this->db->like('category_name', $value);
    	$q = $this->db->get($this->primary_table);
    	return $q->row_array();
    }

    public function updateCategory($data='', $id='')
    {
    	$this->db->update($this->primary_table, $data, ['id'=>$id]);
    	return $this->db->affected_rows();
    }

    public function removeCategory($value='')
    {
    	$this->db->delete($this->primary_table, ['id'=>$value]);
    	return $this->db->affected_rows();
    }

    public function deleteMultiple($values = [])
	{
	    if (empty($values)) { return 0; }

	    $this->db->where_in('id', $values);
	    $this->db->delete($this->primary_table);

	    return $this->db->affected_rows();
	}

	public function updateToOthersCategory($value=[], $id='')
	{
		$this->db->where_in('category_id', $values);
	    $this->db->update('questions', ['category_id'=>$id]);

	    return $this->db->affected_rows();
	}

	public function createOtherCategory()
	{
		$this->db->insert($this->primary_table, ['category_name' => 'Others']);
		return $this->db->insert_id();
	}

	public function moveToCategory($ids = [], $cat_id = '') {
		if (empty($ids) || empty($cat_id)) {
			return;
		}
		$data = array('category_id' => $cat_id);
		$this->db->where_in('question_id', $ids);
		$this->db->update($this->question_table, $data);
		$affected_rows = $this->db->affected_rows();
		return $affected_rows;
	}
	

}

/* End of file Business_units_model.php */
/* Location: ./application/models/Business_units_model.php */